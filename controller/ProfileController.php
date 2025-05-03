<?php
require_once 'database/config.php';
require_once 'Traits/ValidatorTrait.php';
require_once 'Traits/CrudOperationsTrait.php';
require_once 'Traits/HandleFileTrait.php';
require_once 'controller/ErrorHandlerController.php';

class DatabaseOperations
{
    use CrudOperationsTrait, HandleFileTrait, ValidatorTrait;

    private $connection;

    public function __construct($conn)
    {
        $this->connection = $conn;
    }

    /*
    |--------------------------------------------------------------------------
    | validate Company Form Data
    |--------------------------------------------------------------------------
    */
    public function validateCompanyFormData($data)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'education' => 'nullable|string|max:255',
        ];
        return $this->validateRequestData($data, $rules);
    }

    /*
    |--------------------------------------------------------------------------
    | get User Details
    |--------------------------------------------------------------------------
    */
    public function getUserDetails($user_id)
    {
        $userDetails = $this->fetchUserDetails($user_id);
        if ($userDetails) {
            $userDetails['social_links'] = $this->fetchSocialLinks($user_id);
            return $userDetails;
        }
        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | fetch User Details
    |--------------------------------------------------------------------------
    */
    private function fetchUserDetails($user_id)
    {
        $sql = "SELECT users.*, user_details.*, 
                GROUP_CONCAT(social_links.name) AS social_links_names, 
                GROUP_CONCAT(social_links.url) AS social_links_urls
                FROM users
                LEFT JOIN user_details ON users.user_details_id = user_details.id
                LEFT JOIN social_links ON users.id = social_links.user_id
                WHERE users.id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /*
    |--------------------------------------------------------------------------
    | fetch Social Links
    |--------------------------------------------------------------------------
    */
    private function fetchSocialLinks($user_id)
    {
        $sql = "SELECT * FROM social_links WHERE user_id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $social_links = array();
        while ($row = $result->fetch_assoc()) {
            $social_links[] = $row;
        }
        return $social_links;
    }

    /*
    |--------------------------------------------------------------------------
    | create User Details
    |--------------------------------------------------------------------------
    */
    private function createUserDetails($user_id)
    {
        $sql = "INSERT INTO user_details (user_id) VALUES (?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }

    /*
    |--------------------------------------------------------------------------
    | update User Details
    |--------------------------------------------------------------------------
    */
    public function updateUserDetails($user_id, $name, $location, $email, $phone, $specialization, $education, $cv, $image)
    {
        // fetch current user details
        $currentUserDetails = $this->fetchUserDetails($user_id);

        // check if user details exist, if not create them
        $pathCV = $currentUserDetails['cv'] ?? null; // save current value if no new file is uploaded
        $pathImage = $currentUserDetails['image'] ?? null; // save current value if no new file is uploaded

        // upload new CV if it exists
        if (isset($cv['tmp_name']) && !empty($cv['tmp_name'])) {
            $pathCV = $this->uploadFiles($cv['tmp_name'], $cv['name'], 'cv');
        }

        // upload new image if it exists
        if (isset($image['tmp_name']) && !empty($image['tmp_name'])) {
            $pathImage = $this->uploadFiles($image['tmp_name'], $image['name'], 'image');
        }

        // update user details
        $sql = "UPDATE users
            LEFT JOIN user_details ON users.user_details_id = user_details.id
            SET users.name = ?, user_details.location = ?, users.email = ?, users.phone = ?, 
            user_details.specialization = ?, user_details.education = ?, user_details.cv = ?, users.image = ?
            WHERE users.id = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ssssssssi", $name, $location, $email, $phone, $specialization, $education, $pathCV, $pathImage, $user_id);
        $stmt->execute();
    }

    /*
    |--------------------------------------------------------------------------
    | update User Social Links
    |--------------------------------------------------------------------------
    */
    public function updateUserSocialLinks($user_id, $social_links)
    {
        $this->deleteUserSocialLinks($user_id);
        foreach ($social_links as $link) {
            $this->insertUserSocialLink($user_id, $link['name'], $link['url']);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | delete User Social Links
    |--------------------------------------------------------------------------
    */
    private function deleteUserSocialLinks($user_id)
    {
        $sql = "DELETE FROM social_links WHERE user_id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }

    /*
    |--------------------------------------------------------------------------
    | insert User Social Link
    |--------------------------------------------------------------------------
    */
    private function insertUserSocialLink($user_id, $name, $url)
    {
        $sql = "INSERT INTO social_links (name, url, user_id) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ssi", $name, $url, $user_id);
        $stmt->execute();
    }

    /*
    |--------------------------------------------------------------------------
    | find Company ById
    |--------------------------------------------------------------------------
    */
    public function findCompanyById($id)
    {
        $sql = $this->prepareCompanyQuery($id);
        return $this->executeQuery($sql);
    }

    /*
    |--------------------------------------------------------------------------
    | prepare Company Query
    |--------------------------------------------------------------------------
    */
    private function prepareCompanyQuery($id)
    {
        return "SELECT companies.*, 
                GROUP_CONCAT(DISTINCT job_postings.title SEPARATOR '<br>') AS job_titles,
                GROUP_CONCAT(DISTINCT job_postings.id SEPARATOR '<br>') AS job_ids
                FROM companies
                LEFT JOIN job_postings ON companies.id = job_postings.company_id
                WHERE companies.user_id IN (
                    SELECT companies.user_id FROM companies WHERE companies.user_id = $id
                )
                GROUP BY companies.id";
    }

    /*
    |--------------------------------------------------------------------------
    | execute Query
    |--------------------------------------------------------------------------
    */
    private function executeQuery($sql)
    {
        $result = $this->connection->query($sql);
        $results = array();

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $results[] = $row;
            }
        }

        return $results;
    }

    /*
    |--------------------------------------------------------------------------
    | upload Files
    |--------------------------------------------------------------------------
    */
    public function uploadFiles($tmp_name, $name, $type)
    {
        // Create upload directory if it doesn't exist
        $uploadDir = "uploads/" . $type . "/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Generate unique filename
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;

        // Move uploaded file
        if (move_uploaded_file($tmp_name, $uploadDir . $filename)) {
            return $uploadDir . $filename;
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | validate Request Data
    |--------------------------------------------------------------------------
    */
    public function validateRequestData($data, $rules)
    {
        $errors = [];

        foreach ($rules as $field => $rule) {
            $rulesArray = explode('|', $rule);

            foreach ($rulesArray as $ruleItem) {
                $params = [];

                if (strpos($ruleItem, ':') !== false) {
                    list($ruleName, $param) = explode(':', $ruleItem, 2);
                    $params = explode(',', $param);
                } else {
                    $ruleName = $ruleItem;
                }

                switch ($ruleName) {
                    case 'required':
                        if (!isset($data[$field]) || $data[$field] === '') {
                            $errors[$field][] = ucfirst($field) . ' is required';
                        }
                        break;

                    case 'string':
                        if (isset($data[$field]) && !is_string($data[$field])) {
                            $errors[$field][] = ucfirst($field) . ' must be a string';
                        }
                        break;

                    case 'email':
                        if (isset($data[$field]) && !filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                            $errors[$field][] = ucfirst($field) . ' must be a valid email address';
                        }
                        break;

                    case 'max':
                        if (isset($data[$field]) && is_numeric($params[0])) {
                            if (strlen($data[$field]) > $params[0]) {
                                $errors[$field][] = ucfirst($field) . ' must not exceed ' . $params[0] . ' characters';
                            }
                        }
                        break;

                    case 'nullable':
                        // Field is allowed to be null, no validation needed
                        break;
                }
            }
        }

        return $errors;
    }
}

/*
|--------------------------------------------------------------------------
| get User Id
|--------------------------------------------------------------------------
*/
function getUserId()
{
    if (isset($_GET['id'])) {
        return $_GET['id'];
    } elseif (isset($_SESSION['user_id'])) {
        return $_SESSION['user_id'];
    } else {
        header('location: index.php');
        exit;
    }
}

/*
|--------------------------------------------------------------------------
| handle Post Request
|--------------------------------------------------------------------------
*/
function handlePostRequest($databaseOperations, $userId, &$userDetails, &$error_messages)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['name']) && isset($_POST['location']) && isset($_POST['email']) && isset($_POST['phone'])) {
            $data = [
                "name" => $_POST['name'],
                "location" => $_POST['location'],
                "image" => $_FILES['image'],
                "cv" => $_FILES['cv'],
                "specialization" => $_POST['specialization'],
                "email" => $_POST['email'],
                "phone" => $_POST['phone'],
                "education" => $_POST['education'],
            ];
            $result = $databaseOperations->validateCompanyFormData($data);
            if ($result) {
                $error_messages = $result;
            } else {
                $databaseOperations->updateUserDetails($userId, $_POST['name'], $_POST['location'], $_POST['email'], $_POST['phone'], $_POST['specialization'], $_POST['education'], $_FILES['cv'], $_FILES['image']);
                $userDetails = $databaseOperations->getUserDetails($userId);
                $social_links = array();
                foreach ($userDetails['social_links'] as $social_link) {
                    $social_link_name = $social_link['name'];
                    $social_link_url = isset($_POST[$social_link_name]) ? $_POST[$social_link_name] : $social_link['url'];
                    if (!empty($social_link_url)) {
                        $social_links[] = array(
                            'name' => $social_link_name,
                            'url' => $social_link_url
                        );
                    }
                }
                $databaseOperations->updateUserSocialLinks($userId, $social_links);
                header('location: profile.php');
                exit;
            }
        }
    }
}

$userId = getUserId();
$databaseOperations = new DatabaseOperations($conn);
$error_messages = [];
$userDetails = $databaseOperations->getUserDetails($userId);
$companyData = $databaseOperations->findCompanyById($userId);
handlePostRequest($databaseOperations, $userId, $userDetails, $error_messages);
