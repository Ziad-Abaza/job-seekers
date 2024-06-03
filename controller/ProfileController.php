<?php
require_once 'database/config.php';
require_once 'Traits/ValidatorTrait.php';
require_once 'Traits/CrudOperationsTrait.php';

class DatabaseOperations
{
    use CrudOperationsTrait;

    private $connection;

    public function __construct($conn)
    {
        $this->connection = $conn;
    }

    /*
    |--------------------------------------------------------------------------
    | getUserDetails
    |--------------------------------------------------------------------------
    */

    public function getUserDetails($user_id)
    {
        $sql = $this->prepareUserDetailsQuery();
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $this->processUserDetailsResult($result);
    }

    /*
    |--------------------------------------------------------------------------
    | findCompanyById
    |--------------------------------------------------------------------------
    */

    public function findCompanyById($id)
    {
        $sql = $this->prepareCompanyQuery($id);
        return $this->executeQuery($sql);
    }

    /*
    |--------------------------------------------------------------------------
    | prepareUserDetailsQuery
    |--------------------------------------------------------------------------
    */

    private function prepareUserDetailsQuery()
    {
        return "SELECT users.*, user_details.*, 
                GROUP_CONCAT(social_links.name) AS social_links_names, 
                GROUP_CONCAT(social_links.url) AS social_links_urls
                FROM users
                LEFT JOIN user_details ON users.user_details_id = user_details.id
                LEFT JOIN social_links ON users.id = social_links.user_id
                WHERE users.id = ?";
    }

    /*
    |--------------------------------------------------------------------------
    | processUserDetailsResult
    |--------------------------------------------------------------------------
    */

    private function processUserDetailsResult($result)
    {
        $userDetails = $result->fetch_assoc();

        if ($userDetails) {
            $social_links_names = explode(",", $userDetails['social_links_names']);
            $social_links_urls = explode(",", $userDetails['social_links_urls']);
            $social_links = array();
            for ($i = 0; $i < count($social_links_names); $i++) {
                $social_links[] = array(
                    'name' => $social_links_names[$i],
                    'url' => $social_links_urls[$i]
                );
            }

            $userDetails['social_links'] = $social_links;
            return $userDetails;
        } else {
            return false;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | prepareCompanyQuery
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
}

/*
|--------------------------------------------------------------------------
| getUserId
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

$userId = getUserId();
$databaseOperations = new DatabaseOperations($conn);

$userDetails = $databaseOperations->getUserDetails($userId);
$companyData = $databaseOperations->findCompanyById($userId);
