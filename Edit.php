<?php 
    include("assets/templates/header.php");
	session_start();
	$email = $_SESSION['email'];
	$email = htmlspecialchars($email);

	/*connect to database */
    include("sql.php");

    $SQL = "SELECT * FROM users WHERE email = '$email'";
    $result = mysql_query($SQL);

    //retrieve data from sql server
    while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
    	$name = $row['name'];
  		$email = $row['email'];
        $uid = $row['userid'];
        $password = $row['password'];
        $bio = $row['bio'];
    }
    $_SESSION['uid']=$uid;
    header("upload.php");
    echo getcwd() . "\n";
?>
    <section id="profile" class="about section">
        <div class="container">
            <br>
            <br>
            <h2 class="title text-center">Welcome to your profile edit page!</h2> 
			<?php
				if (isset($_GET['password_status'])) {
					echo '<h3 class="text-center">Please ensure that your passwords match!</h3>';
				}
			?>
            <br>
        <div id="edit_content">
			<form action="upload.php" method="post" enctype="multipart/form-data">
				Select image to upload:
				<input type="file" name="fileToUpload" id="fileToUpload" >
				<br>
				<label for="name">Name:</label>
				<br>
				<input type="text" id="name" name="nameInput" class="inputs" placeholder="Name" value=<?=$name?>>
				<br>
				<label for="password">Password:</label>
				<br>
				<input type="password" id="password" name="password" class="inputs" placeholder="Password" value=<?=$password?>>
				<br>
				<label for="confirm_password">Confirm Password:</label>
				<br>
				<input type="password" id="confirm_password" name="password2" class="inputs" placeholder="Retype your password" value=<?=$password?>><br>
				<br>
				<label for="bio">About Me:</label>
				<br>
				<textarea id="bio" rows="6" cols="50" name="bio" id="bio" class="inputs"><?=$bio?></textarea>
				<br>
				<a class="btn btn-cta-secondary" href="profile.php">Back</a>
				<input type="submit" name="submit" class="btn btn-cta-secondary">
			</form>
        </div> 
    </section>
<?php include("assets/templates/footer.html"); ?>