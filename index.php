<?php
// Start a session and check if the user is logged in
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

// Include the database connection file
include('db.php');


include('php/dark.php');


// logged in user's info
include('php/loggedin_user.php');


// post creator info
include('php/post_creator.php');


?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS Links-->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">    
	  <link rel="stylesheet" href="<?php echo $darkMode ? 'css/style-dark.css' : 'css/style.css'; ?>">
    <link rel="stylesheet" type="text/css" href="css/media.css">
    <link rel="stylesheet" type="text/css" href="css/all.css">

    <title>FriendsHive</title>
    
  </head>
<body>

    <?php include 'page_builder/header.php' ?>

    
    <section class="homepage">      

      <div class="container-fluid">
        <div class="row">



          <div class="col d-md-block d-none">
            <?php include 'page_builder/sidebar.php' ?>

          </div>

          <div class="col-lg-6 col-sm-10 col-12">
            <div class="main-content">

              <?php include 'create_post.php' ?>           



              <h1 class="heading mt-5">Recent Posts</h1>

              
              <!-- single post 1 -->       
              
          
              <?php while ($row = mysqli_fetch_assoc($result)): ?>
                  <div class="post-content">                
                      <div class="post-owner">
                          <ul class="list-inline">
                            <li class="list-inline-item">
                                <div class="post-profile">
                                  <img src="<?php echo $row['u_profile_pic'] ?>" class="img-fluid" alt="">
                                </div>
                            </li>
                            
                            <li class="list-inline-item">                
                              <p class="post-owner-name m-0">
                                <?php echo $row['post_author']?>                              
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
              <?php endwhile ?>
        

              <!-- single post 1 -->
            

            </div>
          </div>
          <div class="col d-sm-block d-none">
             <?php include 'page_builder/people.php' ?>
          </div>


          <div class="chat">           

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


