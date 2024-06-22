<?php
session_start();
include_once "database/config.php";
if (!isset($_SESSION['user_id'])) {
  header("location: login.php");
}
if (isset($_SESSION['row_data'])) {
  $row = $_SESSION['row_data'];
}
$user_id = $_SESSION['user_id'];
$sql = mysqli_query($conn, "SELECT * FROM users WHERE users.id = $user_id");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chats</title>
  <?php require_once 'components/head.php'; ?>
  <link rel="stylesheet" href="css/chats.css">
</head>

<body>
  <?php require_once 'components/spinner.php'; ?>
  <?php require_once 'components/navbar.php'; ?>
  <div class="wrapper">
    <section class="users" style="height: calc(100vh - 125px);">
      <section class="d-flex" style="height: calc(100vh - 125px);">
        <div class="w-35 d-flex " style=" margin-right:15px; ">
          <div class="w-full" style="    height: calc(100vh - 125px); display:flex; flex-direction: column; justify-content:space-between; padding:20px 0 20px 0;">
            <div class="users-list w-full" style="height: calc(100vh - 125px); padding:0 0 0 10px;overflow: auto;" id="sendData">
            </div>
          </div>
          <div class="vertical-line"></div>
        </div>
        <section class="chat-area w-full" id="chatArea"></section>
      </section>
    </section>
  </div>
  <?php require_once 'components/footer.php'; ?>
  <?php require_once 'components/scripts.php'; ?>
  <script src="js/chats.js"></script>
</body>

</html>