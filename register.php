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

/*if page is accessed after attempt */
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$email = $_POST['email'];
    $name = $_POST['name'];
	$pass = $_POST['pass'];
    
    //make sure all fields are set
    if (!empty($email) && !empty($pass) && !empty($name)){
        
	/* strip of any sketchy characters */
    $email = htmlspecialchars($email);
    $name = htmlspecialchars($name);
    $pass = htmlspecialchars($pass);

    /*connect to database */
	$user_name = "root";
    $pass_word = "root";
    $database = "users";
    $server = "localhost:8888";

	$db_handle = mysql_connect($server, $user_name, $pass_word);
	$db_found = mysql_select_db($database, $db_handle);

	if ($db_found) {

		$email = quote_smart($email, $db_handle);
        $name = quote_smart($name, $db_handle);
		$pass = quote_smart($pass, $db_handle);
        
        /*check if user exists */
        
		$SQL = "SELECT * FROM users WHERE email = $email";
		$result = mysql_query($SQL);
		$num_rows = mysql_num_rows($result);

		if ($num_rows > 0) {
			$errorMessage = "Username already taken";
		}
		else {

			$SQL = "INSERT INTO users (email, name, password) VALUES ($email, $name, $pass)";
            $errorMessage= "registered!";
			$result = mysql_query($SQL);
			mysql_close($db_handle);
                
            //open sessions
			session_start();
			$_SESSION['login'] = "1";

			header ("Location: index.php");
		}
	}
	else {
		$errorMessage = "Database Not Found";
	}
}
    else {
        $errorMessage = "Please enter all the fields!";
}
}
?>
<?php include("assets/templates/header.php"); ?>
    <section id="register" class="about section">
        <div class="container" class="intro text-center">
            <br>
            <br>
            <h2 class="title text-center">Register</h2>          
            <form action="#" method="post" class="intro text-center">
                <input type="text" name="name" placeholder="Name" class="inputs"><br>
                <input type="text" name="email" placeholder="E-mail" class="inputs"><br>
                <input type="password" name="pass" placeholder="Password" class="inputs"><br>
                <input type="password" name="pass2" placeholder="Re-enter Password" class="inputs"><br>
                <input type="submit" class="btn btn-cta-primary">
            </form>
        </div>
    </section>
<?PHP print $errorMessage;?> 
<?php include("assets/templates/footer.html"); ?>