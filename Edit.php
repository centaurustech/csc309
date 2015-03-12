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
    $user_name = "root";
    $pass_word = "csc309";
    $database = "users";
    $server = "104.236.231.174:3306";;
    
    $db_handle = mysql_connect($server, $user_name, $pass_word);
    $db_found = mysql_select_db($database, $db_handle);

    $SQL = "SELECT * FROM users WHERE email = $email";
    $result = mysql_query($SQL);

    //retrieve data from sql server
    while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
    	$name = $row['name'];
  		$email = $row['email'];
    }
?>
    <section id="profile" class="about section">
        <div class="container" class="intro text-center">
            <br>
            <br>
            <h2 class="title text-center">Welcome to Edit profile page</h2> 
            <br>
        
        <form action="upload.php" method="post" enctype="multipart/form-data">
         Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
        </form>
        </div>
    

    </section>


<?php include("assets/templates/footer.html"); ?>