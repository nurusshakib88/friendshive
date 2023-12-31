<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

// Check if post ID is set
if (!isset($_POST['id'])) {
    header('Location: index.php');
    exit();
}


$post_id = $_POST['id'];

// post details from the database
$sql = "SELECT * FROM posts WHERE id = $post_id";
$result = mysqli_query($conn, $sql);

// Check if post exists
if (mysqli_num_rows($result) == 0) {
    header('Location: index.php');
    exit();
}

$row = mysqli_fetch_assoc($result);

if ($row['user_id'] != $_SESSION['id']) {
    header('Location: index.php');
    exit();
}

$sql = "DELETE FROM posts WHERE id = $post_id";
mysqli_query($conn, $sql);

header('Location: index.php');
exit();
?>
