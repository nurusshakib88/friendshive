<?php
include('db.php');

// Fetch list of users from the database
$sql = "SELECT * FROM users";
$userlist = mysqli_query($conn, $sql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


<?php while ($row = mysqli_fetch_assoc($userlist)): ?>

	<a href="user_profile.php?id=<?php echo $row['id'] ?>">
		<ul class="list-inline">
			<li class="list-inline-item">
			<div class="online-img">
				<img src="<?php echo $row['profile_pic'] ?>" class="img-fluid" alt="">
			</div>
			</li>
			<li class="list-inline-item">
			<div class="online-name d-none d-lg-block">
				<?php echo isset($row['username']) ? $row['username'] : '' ?>
			</div>
			</li>
		</ul>  
	</a>





<?php endwhile ?>

    
</body>
</html>