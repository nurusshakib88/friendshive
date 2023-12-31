<?php
session_start();
require_once 'db.php';

include('php/dark.php');

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}


// logged in user's info
include('php/loggedin_user.php');


// post creator info
include('php/post_creator.php');

$post_id = $_GET['id'];

// Get the post details from the database
$p_sql = "SELECT * FROM posts WHERE id = $post_id";
$p_result = mysqli_query($conn, $p_sql);

// Check if post exists
if (mysqli_num_rows($p_result) == 0) {
    header('Location: index.php');
    exit();
}

$row = mysqli_fetch_assoc($p_result);

// Check if the logged in user is the owner
if ($row['user_id'] != $_SESSION['id'] ) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_content = $_POST['post_content'];

    // Update the post
    $p_sql = "UPDATE posts SET body = '$post_content' WHERE id = $post_id";
    mysqli_query($conn, $p_sql);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>


    <!-- CSS Links-->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	  <link rel="stylesheet" href="<?php echo $darkMode ? 'css/style-dark.css' : 'css/style.css'; ?>">
    <link rel="stylesheet" type="text/css" href="css/media.css">
    <link rel="stylesheet" type="text/css" href="css/all.css">


	<title>Edit Post</title>
</head>
<body>


<?php include 'page_builder/header.php' ?>

<div class="container-fluid">
  <div class="row">
    <div class="col">

    <?php include 'page_builder/sidebar.php' ?>

    </div>
    <div class="col-lg-6 col-sm-8 col-12">
      <div class="main-content">

        <div class="create-post">
            <div class="create">
                
                <p class="message">Edit Post</p>
                <form method="POST" action="">           

                    <div>
                        <textarea style="border: none; width: 100%; display: block; overflow: visible; resize: none; margin-bottom: 20px;" name="post_content" id="post_content" rows="3"><?php echo $row['body']; ?></textarea>
                    </div>

                    <p>**the image file can not be edited</p>

                    <button type="submit" class="btn s_btn p_btn">Update</button>
                </form>
            </div>
        </div>          

      </div>
    </div>
    <div class="col">
      <?php include 'page_builder/people.php' ?>
    </div>
  </div>
</div>

</section> 

    <!--JS Links -->   
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
</body>
</html>