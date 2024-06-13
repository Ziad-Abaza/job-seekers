<?php
if (isset($_GET['page'])) {
    $page = $_GET['page'];

    $allowed_pages = [
        'Dashboard/users.php',
        'Dashboard/job-list.php',
        'Dashboard/companies.php',
        'Dashboard/permissions.php'
    ];

    if (in_array($page, $allowed_pages) && file_exists($page)) {
        include($page);
    } else {
        echo "Page not found.";
    }
} else {
    echo "No page specified.";
}
?>
