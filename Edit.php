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
    echo getcwd() . "\n";
?>
    <section id="profile" class="about section">
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
            <input type="text" name="passwordInput" class="inputs" placeholder="Password"><br>
            <input type="text" name="passwordInput2" class="inputs" placeholder="Retype your password"><br>
            <input type="text" name="emailInput" class="inputs" placeholder="E-mail"><br>
            <br>
            <input type="submit" name="submit" class="btn btn-cta-secondary">
        </div> 
        <div class="floatcenter">
            Address<br>
            <input type="text" name="cityInput" class="inputs" placeholder="City"><br>
            <input type="text" name="stateInput" class="inputs" placeholder="State"><br>
            <input type="text" name="CountryInput" class="inputs" placeholder="Country"><br>
            <br>
            <br>
            Talk about yourself:<br>
            <textarea rows="6" cols="50" name="bioInput" class="inputs" placeholder="Comments"></textarea>
            <br>
        </div>
        </form>
    <div style="clear: both;">


    </section>


<?php include("assets/templates/footer.html"); ?>