<?php
// Include the database connection file
include('db.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$body = '';
$image = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $body = $_POST['body'];
    $image = $_FILES['image']['name'];

    $user_id = $_SESSION['id'];
    $query = "INSERT INTO posts (user_id, body, image) VALUES ('$user_id', '$body', '$image')";
    mysqli_query($conn, $query);

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

    header('location: index.php');
    exit();
    
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Friendshive - Create post</title>
</head>
<body>

<div class="create-post">
    <div class="create">

        <p class="message">Create a Post</p>
            
            <form method="post" action="create_post.php" enctype="multipart/form-data">

                <div>
                    <textarea style="border: none; width: 100%; display: block; overflow: visible; resize: none; margin-bottom: 20px;" name="body" id="p_text" rows="3" placeholder="Type something..." required><?php echo $body ?></textarea>
                </div>
                <div>
                    <input type="file" name="image">
                </div>
                <div>
                    <button type="submit" name="create_post" class="btn s_btn p_btn">Create post</button>
                </div>
            </form>
    </div>
</div>




</body>
</html>

<?php
mysqli_close($conn);
?>
