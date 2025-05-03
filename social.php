<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

require_once 'controller/ProfileController.php'; // Connect to controller
$userId = getUserId(); // Get user ID
$databaseOperations = new DatabaseOperations($conn); // Create class object

// Fetch user details
$userDetails = $databaseOperations->getUserDetails($userId);

// Form processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $social_links = [];

  // Check for links in input
  foreach ($_POST as $key => $value) {
    if (in_array($key, ['facebook', 'twitter', 'linkedin', 'instagram', 'youtube', 'snapchat', 'whatsapp', 'tiktok', 'pinterest'])) {
      $url = filter_var($value, FILTER_VALIDATE_URL) ? $value : null;
      if ($url) {
        $social_links[] = ['name' => $key, 'url' => $url];
      }
    }
  }

  // Update links
  $databaseOperations->updateUserSocialLinks($userId, $social_links);
  $_SESSION['success'] = "Links saved successfully.";
  header("Location: social.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Manage Links - MyJob</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container py-5">
    <h2 class="mb-4">Manage Social Links</h2>

    <!-- Success message -->
    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success"><?= $_SESSION['success'];
                                        unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <!-- Add/Edit Links Form -->
    <form method="POST" class="mb-5">
      <div class="row g-3">
        <?php
        $platforms = ['facebook', 'twitter', 'linkedin', 'instagram', 'youtube', 'snapchat', 'whatsapp', 'tiktok', 'pinterest'];
        $existingLinks = [];

        // Convert links to platform-associated array
        if (!empty($userDetails['social_links']) && is_array($userDetails['social_links'])) {
          foreach ($userDetails['social_links'] as $link) {
            $existingLinks[$link['name']] = $link['url'];
          }
        }

        foreach ($platforms as $platform): ?>
          <div class="col-md-6">
            <label class="form-label"><?= ucfirst($platform) ?></label>
            <input type="url" name="<?= $platform ?>" class="form-control"
              value="<?= htmlspecialchars($existingLinks[$platform] ?? '', ENT_QUOTES, 'UTF-8') ?>"
              placeholder="https://<?= $platform ?>.com/username">
          </div>
        <?php endforeach; ?>
      </div>

      <button type="submit" class="btn btn-primary mt-4">Save Changes</button>
    </form>

    <!-- Display Current Links -->
    <h4 class="mb-3">Your Current Links</h4>
    <?php if (empty($userDetails['social_links']) || !is_array($userDetails['social_links']) || count($userDetails['social_links']) == 0): ?>
      <p class="text-muted">No social links saved.</p>
    <?php else: ?>
      <div class="list-group">
        <?php foreach ($userDetails['social_links'] as $link): ?>
          <a href="<?= htmlspecialchars($link['url'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="list-group-item list-group-item-action">
            <strong><?= ucfirst($link['name']) ?>:</strong> <?= htmlspecialchars($link['url'], ENT_QUOTES, 'UTF-8') ?>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>