<?php
session_start();
require_once 'db.php';

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}


include('php/dark.php');

// logged in user's info
include('php/loggedin_user.php');


// post creator info
include('php/post_creator.php');

$user_id = $_GET['id'];



// Get the posts created by the user
$sql = "SELECT posts.*, users.* FROM posts
          JOIN users ON posts.user_id = users.id WHERE posts.user_id = $user_id
          ORDER BY posts.created_at DESC";




$result = mysqli_query($conn, $sql);

$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <!-- CSS Links-->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo $darkMode ? 'css/style-dark.css' : 'css/style.css'; ?>">
    <link rel="stylesheet" type="text/css" href="css/media.css">
    <link rel="stylesheet" type="text/css" href="css/all.css">
    <title>User Profile</title>
</head>
<body>



<?php include 'page_builder/header.php' ?>

<section class="homepage">
    

<div class="container-fluid">
        <div class="row">
            <div class="col">                
                <?php include 'page_builder/sidebar.php' ?>
            </div>

            <div class="col-lg-6 col-sm-8 col-12">
                <div class="main-content">
                    <div class="user_info">
                        <div class="goback">
                            <ul class="list-inline">
                                <li class="list-inline-item"><a href="index.php" class="mb-3"><i class="fa-solid fa-arrow-left"></i></a></li>                            
                                <li class="list-inline-item">
                                    <ul class="list-unstyled">
                                        <li><span class="message"><?php echo $user['username']; ?></span></li>                             
                                    </ul>
                                </li>
                            </ul>
                        </div>

                        <div class="profile-banner mb-5">

                            <div class="cover-photo">
                                <img src="images/cover-pic.jpg" class="img-fluid" alt="">
                            </div>                   

                            <div class="profile-photo">
                                <img src="<?php echo $user['profile_pic']; ?>" class="img-fluid" alt="">
                            </div>

                            <div class="edit mt-3">
                            <button class="btn s_btn p_btn">Edit Profile</button>
                            </div>
                        </div>

                        <div class="info">
                        <p><span>11</span>Following</p> <p><span>255</span>Followers</p>
                        </div>
                    </div>    
                    
                    
                    <h1 class="heading mt-5">Recent Posts</h1>
                    
                    
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        
                      
                        <!-- single post 1 -->   
                            
                            
                            
                        <div class="post-content">                
                            <div class="post-owner">
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <div class="post-profile">
                                        <img src="<?php echo $row['profile_pic'] ?>" class="img-fluid" alt="">
                                        </div>
                                    </li>
                                    
                                    <li class="list-inline-item">                
                                    <p class="post-owner-name m-0">
                                        <?php echo $row['username']?>                              
                                        <span class="date">Posted on <?php echo date('F j, Y - h:i A', strtotime($row['created_at'])) ?></span>
                                    </p>                      
                                    </li>
                                </ul>
                                
                            </div>
                            <p class="post-text"><?php echo $row['body'] ?></p>
                        

                            <?php if(!empty($row['image'])): ?>

                                <div class="post-img">
                                    <img src="uploads/<?php echo $row['image'] ?>" class="img-fluid" alt="Post Image">
                                </div>                    

                            <?php endif; ?>

                            <div class="post-ang">
                                <a href="#"><i class="fa-regular fa-heart"></i></a>
                                <a href="#"><i class="fa-regular fa-comment"></i></a>
                                <a href="#"><i class="fa-solid fa-share"></i></a>
                            </div>


                            <?php if (isset($_SESSION['id']) && $_SESSION['id'] == $row['user_id']): ?>
                
                                <div class="modify">
                                    <a class="dropdown-toggle" id="navbarDropdown1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu post-mod" aria-labelledby="navbarDropdown1">
                                    <li><a class="dropdown-item" href="edit_post.php?id=<?php echo $row['id'] ?>">Edit</a></li>
                                    <li>
                                        <form method="post" action="delete_post.php">
                                            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">            
                                            <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                                        </form>
                                    </li> 

                                </div>
                            <?php endif; ?>

                            
                        </div> 
                        

                        <!-- single post 1 -->
                        
                    <?php endwhile; ?>
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

