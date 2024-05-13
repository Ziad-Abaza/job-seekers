<?php
session_start();
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

    public function getUserDetails($user_id)
    {
        $userDetails = $this->fetchUserDetails($user_id);

        if ($userDetails) {
            $userDetails['social_links'] = $this->fetchSocialLinks($user_id);
            return $userDetails;
        }
    }

    private function fetchUserDetails($user_id)
    {
        $sql = "SELECT users.*, user_details.*, GROUP_CONCAT(social_links.name) AS social_links_names, GROUP_CONCAT(social_links.url) AS social_links_urls
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

    private function createUserDetails($user_id)
    {
        $sql = "INSERT INTO user_details (user_id) VALUES (?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }

    public function updateUserDetails($user_id, $name, $location, $email, $phone, $specialization, $education, $cv, $image)
    {
        if (isset($cv['tmp_name'])) {
            $pathCV = $this->uploadFiles($cv['tmp_name'], $cv['name'], 'cv');
        } else {
            $pathCV = null;
        }

        if (isset($image['tmp_name'])) {
            $pathImage = $this->uploadFiles($image['tmp_name'], $image['name'], 'image');
        } else {
            $pathImage = null;
        }

        $sql = "UPDATE users
                LEFT JOIN user_details ON users.user_details_id = user_details.id
                SET users.name = ?, user_details.location = ?, users.email = ?, users.phone = ?, user_details.specialization = ?, user_details.education = ?, user_details.cv = ?, users.image = ?
                WHERE users.id = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ssssssssi", $name, $location, $email, $phone, $specialization, $education, $pathCV, $pathImage, $user_id);
        $stmt->execute();
    }

    public function updateUserSocialLinks($user_id, $social_links)
    {
        $this->deleteUserSocialLinks($user_id);

        foreach ($social_links as $link) {
            $this->insertUserSocialLink($user_id, $link['name'], $link['url']);
        }
    }

    private function deleteUserSocialLinks($user_id)
    {
        $sql = "DELETE FROM social_links WHERE user_id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }

    private function insertUserSocialLink($user_id, $name, $url)
    {
        $sql = "INSERT INTO social_links (name, url, user_id) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ssi", $name, $url, $user_id);
        $stmt->execute();
    }
}

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
} elseif (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
} else {
    header('location: index.php');
    exit;
}

$databaseOperations = new DatabaseOperations($conn);
$error_messages = [];
$result = null;

$userDetails = $databaseOperations->getUserDetails($userId);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['name']) && isset($_POST['location']) && isset($_POST['email']) && isset($_POST['phone'])) {
        $name = $_POST['name'];
        $location = $_POST['location'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $specialization = $_POST['specialization'];
        $education = $_POST['education'];
        $cv = $_FILES['cv'];
        $image = $_FILES['image'];

        $data = [
            "name" => $name,
            "location" => $location,
            "image" => $image,
            "cv" => $cv,
            "specialization" => $specialization,
            "location" => $location,
            "email" => $email,
            "phone" => $phone,
            "education" => $education,
        ];

        $result = $databaseOperations->validateCompanyFormData($data);
        if (!$result) {
            $databaseOperations->updateUserDetails($userId, $name, $location, $email, $phone, $specialization, $education, $cv, $image);

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
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Profile</title>
    <?php require_once 'components/head.php'; ?>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner -->
        <?php require_once 'components/spinner.php'; ?>
        <!-- Navbar -->
        <?php require_once 'components/navbar.php'; ?>

        <!-- Edit Profile Form -->
        <div class="form-container">
            <div class="login-container text-center" id="login">
                <div class="top p-3 m-auto">
                    <header class="fs-3">Edit Profile</header>
                </div>
                <form method="post" action="edit-profile.php" class="body-form w-100" enctype="multipart/form-data">
                    <div class="form-box-section">
                        <input type="text" class="input-field input-form" id="name" name="name" value="<?php echo $userDetails['name']; ?>">
                        <label for="name">Name</label>
                        <i class="bx bx-user"></i>
                    </div>
                    <div class="form-box-section">
                        <select class="form-select" name="location">
                            <?php
                            $locations = ['Alexandria', 'Aswan', 'Asyut', 'Beheira', 'Beni Suef', 'Cairo', 'Dakahlia', 'Damietta', 'Faiyum', 'Gharbia', 'Giza', 'Ismailia', 'Kafr El Sheikh', 'Luxor', 'Matruh', 'Minya', 'Monufia', 'New Valley', 'North Sinai', 'Port Said', 'Qalyubia', 'Qena', 'Red Sea', 'Sharqia', 'Sohag', 'South Sinai', 'Suez'];
                            foreach ($locations as $loc) {
                                $selected = isset($userDetails['location']) && $userDetails['location'] == $loc ? 'selected' : '';
                                echo "<option value=\"$loc\" $selected>$loc</option>";
                            }
                            ?>
                        </select>
                        <!-- <i class="bi bi-geo-alt-fill"></i> -->
                    </div>
                    <div class="form-box-section">
                        <input type="email" class="input-field input-form" id="email" name="email" value="<?php echo $userDetails['email']; ?>">
                        <label for="email">Email</label>
                        <i class="bx bx-mail-send"></i>
                    </div>
                    <div class="form-box-section">
                        <input type="text" class="input-field input-form" id="specialization" name="specialization" value="<?php echo $userDetails['specialization']; ?>">
                        <label for="email">Specialization</label>
                        <i class="bx bx-mail-send"></i>
                    </div>
                    <div class="form-box-section">
                        <input type="text" class="input-field input-form" id="education" name="education" value="<?php echo $userDetails['education']; ?>">
                        <label for="email">Education</label>
                        <i class="bx bx-mail-send"></i>
                    </div>
                    <div class="form-box-section">
                        <input type="file" class="input-field input-form" name="image" id="image" placeholder=" ">
                        <label for="image">Profile Photo</label>
                        <i class="bx bx-use"></i>
                    </div>
                    <div class="form-box-section">
                        <input type="file" class="input-field input-form" name="cv" id="cv" placeholder=" ">
                        <label for="cv">CV</label>
                        <i class="bx bx-use"></i>
                    </div>
                    <div class="form-box-section">
                        <input type="text" class="input-field input-form" id="phone" name="phone" value="<?php echo $userDetails['phone']; ?>">
                        <label for="phone">Phone</label>
                        <i class="bx bxs-phone"></i>
                    </div>
                    <?php foreach ($userDetails['social_links'] as $social_link) : ?>
                        <div class="form-box-section">
                            <input type="text" class="input-field input-form" id="<?php echo $social_link['name']; ?>" name="<?php echo $social_link['name']; ?>" value="<?php echo $social_link['url']; ?>">
                            <label for="<?php echo $social_link['name']; ?>"><?php echo ucfirst($social_link['name']); ?></label>
                        </div>
                    <?php endforeach; ?>
                    <div class="form-box-section">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
                <?php ErrorHandler::displayErrors($error_messages); ?>
                <?php ErrorHandler::displayErrors($result); ?>
            </div>

        </div>

        <!-- Footer -->
        <?php require_once 'components/footer.php'; ?>
    </div>
    <!-- Scripts -->
    <?php require_once 'components/scripts.php'; ?>
</body>

</html>