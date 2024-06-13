<div class="container mt-5">
    <h1 class="text-center">Companies</h1>
    <?php
    include(__DIR__ . '/../database/config.php');

    // استرجاع المدخلات من النموذج
    $search = isset($_POST['search']) ? $_POST['search'] : '';
    $selectedCategory = isset($_POST['category']) ? $_POST['category'] : '';

    // بناء جملة SQL مع الفلترة
    $sql = "SELECT * FROM companies WHERE 1=1";
    if (!empty($search)) {
        $sql .= " AND name LIKE '%$search%'";
    }
    if (!empty($selectedCategory)) {
        $sql .= " AND category = '$selectedCategory'";
    }

    $result = $conn->query($sql);

    $categories = [
        'Web Development' => [],
        'UI/UX Design' => [],
        'App Development' => [],
        'Software Development' => [],
        'Database Administration' => [],
        'Network Engineering' => [],
        'Embedded Systems' => [],
        'IoT' => []
    ];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $category = $row['category'];
            if (array_key_exists($category, $categories)) {
                $categories[$category][] = $row;
            }
        }
    }

    $conn->close();
    ?>

    <form id="filterForm" action="#" method="POST">
        <div class="form-row align-items-center mb-4 d-flex gap-2">
            <div class="col-md-6">
                <label class="sr-only" for="search">Search</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <div class="col-md-3">
                <label class="sr-only" for="category">Category</label>
                <select class="form-control" id="category" name="category">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $cat => $value) : ?>
                        <option value="<?php echo $cat; ?>" <?php echo $selectedCategory == $cat ? 'selected' : ''; ?>><?php echo $cat; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary" id="filterBtn">Filter</button>
            </div>
        </div>
    </form>

    <div id="filteredResults" style="height: 100vh; overflow-y: auto;">
        <?php foreach ($categories as $category => $companies) : ?>
            <?php if (!empty($companies)) : ?>
                <div class="card my-4 category-card my-0" data-category="<?php echo $category; ?>">
                    <div class="card-header">
                        <h2><?php echo $category; ?></h2>
                    </div>
                    <div class="card-body p-2">
                        <div class="row">
                            <?php foreach ($companies as $company) : ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 company-card mb-3" data-name="<?php echo strtolower($company['name']); ?>" data-category="<?php echo $category; ?>" id="company-<?php echo $company['id']; ?>">
                                    <div class="card h-100">
                                        <div class="d-flex align-items-center p-3">
                                            <div class="rounded-circle overflow-hidden" style="width: 75px; height: 75px;">
                                                <img src="<?php echo $company['image']; ?>" class="img-fluid" alt="<?php echo $company['name']; ?>">
                                            </div>
                                            <div class="ml-3 flex-grow-1">
                                                <h5 class="card-title mb-1"><?php echo $company['name']; ?></h5>
                                                <p class="card-text mb-1">
                                                    <?php echo $company['category']; ?>
                                                </p>
                                                <p class="card-text mb-1">
                                                    <i class="fas fa-map-marker-alt"></i> <?php echo $company['location']; ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex justify-content-between">
                                            <a class="btn btn-primary btn-sm" href="company-detail.php?companyId=<?php echo $company['id']; ?>">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <button class="btn btn-danger btn-sm" onclick="deleteCompany(<?php echo $company['id']; ?>)">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

</div>