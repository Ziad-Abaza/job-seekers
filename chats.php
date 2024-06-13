<?php

session_start();
include_once "./database/config.php";

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
  <title>User List</title>
  <?php require_once 'components/head.php'; ?>
</head>

<body>
  <div class="wrapper">
    <section class="users">
      <section class="d-flex">
        <div class="w-35 d-flex " style=" margin-right:15px; ">

          <div class="w-full" style="height:100vh; display:flex; flex-direction: column; justify-content:space-between; padding:20px 0 20px 0;">
            <div class="users-list w-full" style="height: 100vh;" id="sendData">
              <!-- js doms here -->
            </div>

            <div class="logged_in_user w-full">
              <?php
              if (mysqli_num_rows($sql) > 0) {
                $row = mysqli_fetch_assoc($sql);
              ?>
                <div class="d-flex height-50px">
                  <div class="height-50px width-50px rounded-circle overflow-hidden">
                    <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name'] ?>" class="img-fluid w-full h-full">
                  </div>
                  <p style="margin-left:20px;"><?php echo $row['name'] ?></p>
                  <a href="./logout.php" class="logout">Logout</a>
                </div>

              <?php } ?>

            </div>
          </div>


          <div class="vertical-line"></div>
        </div>
        <section class="chat-area w-full" id="chatArea">
          <!-- js doms here -->
        </section>


      </section>
    </section>
  </div>
  <script src="js/chats.js"></script>
</body>

</html>



<style scoped>
  .height-5 {
    height: 5%;
  }

  .height-67px {
    height: 67px;
  }

  ul {
    list-style-type: none;
    padding: 0;

  }

  .width-50px {
    width: 50px;
  }

  .height-50px {
    height: 50px;
  }

  .w-full {
    width: 100%;
  }

  .h-full {
    height: 100%;
  }

  .w-35 {
    width: 35%;
  }

  .w-65 {
    width: 65%;
  }

  .vertical-line {
    width: 1px;
    height: 100%;
    background-color: lightgray;
    border-radius: 5px;
    border: none;
  }

  hr {
    height: 1px;
    width: 100%;
    border-radius: 5px;
    border: none;
    background-color: lightgray;
  }

  .user_container {
    display: flex;
    align-items: center;
  }

  .chat-box {
    display: flex;
    flex-direction: column;
    gap: 5px;
    padding-right: 20px;
  }

  p {
    padding: 0;
    margin: 0;
  }

  .chat-box .chat {
    max-width: 50%;
    border-radius: 10px;
    padding: 15px;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
  }

  .chat-box .msg {
    width: 100%;
  }

  .chat-box .outgoing {
    float: right;
    max-width: 100%;
    background-color: #26577d;
    color: white;
  }

  .chat-box .incoming {
    float: left;
    max-width: 100%;
    background-color: gray;
    color: white;
  }

  .input-field {
    border: none;
    background-image: none;
    background-color: white;
    padding: 0.5rem 1rem;
    margin-right: 1rem;
    border-radius: 1.125rem;
    flex-grow: 2;
    box-shadow:
      0 0 1rem rgba(black, 0.1),
      0rem 1rem 1rem -1rem rgba(black, 0.2);

    font-family: Red hat Display, sans-serif;
    font-weight: 400;
    letter-spacing: 0.025em;
    width: 100%;
  }

  button{
    background-color: white;
    border: 1px solid lightgray;
    border-radius: 100%;
    width: 50px;
    height: 50px;
  }
</style>