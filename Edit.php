<?php include("assets/templates/header.php"); ?>
<?php	
	function quote_smart($value, $handle) {
	   if (get_magic_quotes_gpc()) {
	       $value = stripslashes($value);
	   }

	   if (!is_numeric($value)) {
	       $value = "'" . mysql_real_escape_string($value, $handle) . "'";
	   }
	   return $value;
	}
	$email = $_SESSION['email'];
	$email = htmlspecialchars($email);

	/*connect to database */
    include("sql.php");

    $SQL = "SELECT * FROM users WHERE email = $email";
    $result = mysql_query($SQL);

    //retrieve data from sql server
    while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
    	$name = $row['name'];
  		$email = $row['email'];
        $uid = $row['userid'];
    }
    session_start();
    $_SESSION['uid']=$uid;
    header("upload.php");
    echo getcwd() . "\n";
?>
    <section id="profile" class="about section">
        <div class="container">
            <br>
            <br>
            <h2 class="title text-center">Welcome to Edit profile page</h2> 
            <br>
        <div class="wrap">
        <div class="floatleft">
        <form action="upload.php" method="post" enctype="multipart/form-data">
            Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload" >
            <br>
            Login Information<br>
            <input type="text" name="nameInput" class="inputs" placeholder="Name"><br>
            <input type="password" name="passwordInput" class="inputs" placeholder="Password"><br>
            <input type="password" name="passwordInput2" class="inputs" placeholder="Retype your password"><br>
            <br>
            <a class="btn btn-cta-secondary" href="profile.php">Back</a>
            <input type="submit" name="submit" class="btn btn-cta-secondary">
        </form>
        </div> 
        <div class="floatright">
            <br>
            Talk about yourself:<br>
            <textarea rows="6" cols="50" name="bioInput" id="bioInput" class="inputs" placeholder="Comment"></textarea>
            <br>
        </div>
        <div style="clear: both;"/>
        </div>
    </section>


<?php include("assets/templates/footer.html"); ?>