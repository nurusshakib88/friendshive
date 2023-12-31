<?php
session_start();

if (isset($_SESSION['id'])) {
    header('location: index.php');
    exit();
}

include('db.php');

$email = '';
$password = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
    $email = $_POST['email'];
    $password = $_POST['password'];


    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $user['id'];
        header('location: index.php');
        exit();
    } else {
        $error = "Invalid login credentials";
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- CSS Links-->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" type="text/css" href="css/login-media.css">
    <link rel="stylesheet" type="text/css" href="css/all.css">




    <title>FriendsHive - Login</title>
</head>
<body>    
   
    <section class="login">
      
      <div class="container-fluid">
        <div class="row align-items-center justify-content-center">


          <div class="col-lg-8">
            <div class="login_box">
              <div class="login_form px-4 py-3 w-100">
                <!-- logo start -->
                <a class="navbar-brand logo text-center" href="index.html">
                  Friends<span>Hive</span>
                </a>
                <!-- logo end -->
                

                <form method="post" action="login.php">     
                              
                  <div class="mb-2">
                    <label for="email" class="form-label">Enter your email</label>
                    <input type="email" class="form-control u_email" id="email" name="email" required>
                  </div>

                  <div class="mb-2">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control u_pass" id="password" name="password" required>
                  </div>
                  <div class="mb-3">
                    <p><?php echo $error ?></p>
                  </div>

                  <input type="submit" class="btn s_btn" value="login">

                  <p class="text-center pt-2 t_signup mb-0">Don't have an account? <a href="signup.php">Sign up</a></p>
                </form>
                
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

<?php
// Close the database connection
mysqli_close($conn);
?>
