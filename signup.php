<?php

session_start();

if (isset($_SESSION['id'])) {
    header('location: index.php');
    exit();
}

include('db.php');

$username = '';
$email = '';
$password = '';
$confirm_password = '';
$errors = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password != $confirm_password) { 
      $errors= "Passwords do not match"; }


    $profile_pic = '';

    if (!empty($_FILES['profile_pic']['name'])) {
        $file_name = basename($_FILES['profile_pic']['name']);
        $file_tmp = $_FILES['profile_pic']['tmp_name'];
        $file_type = $_FILES['profile_pic']['type'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $extensions = array("jpeg", "jpg", "png");
        if (in_array($file_ext, $extensions) === false) {
            array_push($errors2, "Extension not allowed, please choose a JPEG or PNG file.");
        } else {
            $upload_dir = 'uploads/';
            $profile_pic = $upload_dir . uniqid() . '.' . $file_ext;
            move_uploaded_file($file_tmp, $profile_pic);
        }
    }

    if (!$errors && !$errors2) {

        $query = "INSERT INTO users (username, email, password, profile_pic) VALUES ('$username', '$email', '$password', '$profile_pic')";
        mysqli_query($conn, $query);

        header('location: login.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html>
<head>


    <!-- CSS Links-->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">    
	  <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" type="text/css" href="css/login-media.css">
    <link rel="stylesheet" type="text/css" href="css/all.css">



    <title>Friendshive - Sign up</title>
</head>
<body>

    <section class="login">
      
      <div class="container-fluid">
        <div class="row align-items-center justify-content-center">


          <div class="col-lg-8 ">

            <div class="row">
              <div class="col-lg-12 align-self-center">
                <!-- login -->
                <div class="login_box sw-100">
                  <div class="login_form signup_form px-4 py-3">
                    <!-- logo start -->
                    <a class="navbar-brand logo text-center" href="index.html">
                      Social<span>media.</span>
                    </a>
                    <!-- logo end -->

                    <form  method="post" action="signup.php" enctype="multipart/form-data">
                      <div class="row g-3">
                        <div class="col-12">
                          <label for="username" class="form-label">Full name</label>
                          <input type="text" class="form-control" name="username" id="username" required>
                        </div>

                        <div class="col-12">
                          <label for="email" class="form-label">Email</label>
                          <input type="email" class="form-control" name="email" id="email" required>
                        </div>

                        <div class="col-6">
                          <label for="password" class="form-label">Password</label>
                          <input type="password" class="form-control" name="password" id="password" required>
                        </div>

                        <div class="col-6">
                          <label for="confirm_password" class="form-label">Confirm Password</label>
                          <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
                        </div> 

                        <div class="col">
                          <label for="profile_pic" class="form-label">Profile Picture</label>
                          <input type="file" class="form-control" name="profile_pic" id="profile_pic" required>
                        </div>           

                          
                          <?php if ($errors): ?>
                              <div class="error">
                                  <span style="color: red;"><?php echo $errors; ?></span>                                  
                              </div>
                          <?php endif ?>

                        <input type="submit" class="btn s_btn" name="signup" value="Sign Up">
                        <p class="text-center pt-2 mb-0 t_signup">Allready have an account? <a href="login.php">Login</a></p>
                      </div>
                    </form>
                    
                  </div>
                </div>
              </div>
            </div>


            

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


