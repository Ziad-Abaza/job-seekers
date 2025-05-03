<?php
require_once 'database/config.php';
require_once 'Traits/ValidatorTrait.php';
require_once 'Traits/CrudOperationsTrait.php';
require_once 'Traits/HandleFileTrait.php';

class DatabaseOperations
{
  use ValidatorTrait, CrudOperationsTrait, HandleFileTrait;

  private $connection;

  public function __construct($conn)
  {
    $this->connection = $conn;
  }

  /*
    |--------------------------------------------------------------------------
    | Get Unique Company Categories
    |--------------------------------------------------------------------------
    */
  public function getCompanyCategories()
  {
    $sql = "SELECT DISTINCT category FROM companies WHERE category IS NOT NULL AND category != ''";
    $result = $this->executeQuery($sql);

    $categories = [];
    while ($row = $result->fetch_assoc()) {
      $categories[] = $row['category'];
    }

    return $categories;
  }

  /*
    |--------------------------------------------------------------------------
    | Count Companies by Category
    |--------------------------------------------------------------------------
    */
  public function countCompaniesByCategory($category)
  {
    $safeCategory = mysqli_real_escape_string($this->connection, $category);
    $sql = "SELECT COUNT(*) AS count FROM companies WHERE category LIKE '%$safeCategory%'";
    $result = $this->executeQuery($sql);

    if ($result && $row = $result->fetch_assoc()) {
      return $row['count'];
    }

    return 0;
  }

  /*
    |--------------------------------------------------------------------------
    | Get All Unique Locations
    |--------------------------------------------------------------------------
    */
  public function getAllLocations()
  {
    $sql = "SELECT DISTINCT location FROM companies WHERE location IS NOT NULL AND location != ''";
    $result = $this->executeQuery($sql);

    $locations = [];
    while ($row = $result->fetch_assoc()) {
      $locations[] = $row['location'];
    }

    return $locations;
  }

  /*
    |--------------------------------------------------------------------------
    | Get Jobs with optional filter
    |--------------------------------------------------------------------------
    */
  public function getJobs($table, $relations = [], $conditions = [])
  {
    $sql = "SELECT job.*, company.location 
                FROM $table AS job";

    if (!empty($relations)) {
      foreach ($relations as $relation) {
        list($relatedTable, $relatedRecord) = explode(':', $relation);
        $sql .= " LEFT JOIN $relatedTable AS related ON job.$relatedRecord = related.$relatedRecord";
      }
    }

    $sql .= " LEFT JOIN companies AS company ON job.company_id = company.id";

    if (!empty($conditions)) {
      $sql .= " WHERE " . implode(" OR ", $conditions);
    }

    return $this->executeQuery($sql);
  }
}

// Initialize database operations
$databaseOperations = new DatabaseOperations($conn);

// Get all unique company categories
$companyCategories = $databaseOperations->getCompanyCategories();

// Prepare category data with counts
$categoryData = [];
foreach ($companyCategories as $category) {
  $categoryData[] = [
    'name' => $category,
    'count' => $databaseOperations->countCompaniesByCategory($category),
  ];
}

// Fetch all jobs
$allJobs = $databaseOperations->getJobs('job_postings', ['companies:id'], []);

// Fetch filtered jobs
$fullTimeJobs = $databaseOperations->getJobs('job_postings', ['companies:id'], ["job.type = 'Full Time'"]);
$partTimeJobs = $databaseOperations->getJobs('job_postings', ['companies:id'], ["job.type = 'Part Time'"]);
$remoteJobs = $databaseOperations->getJobs('job_postings', ['companies:id'], ["company.location = 'Remote'"]);
$locations = $databaseOperations->getAllLocations();

// Pass data to view
$data = [
  'categories' => $categoryData,
  'jobs' => $allJobs,
  'full_time_jobs' => $fullTimeJobs,
  'part_time_jobs' => $partTimeJobs,
  'remote_jobs' => $remoteJobs,
  'locations' => $locations 
];

return $data;
