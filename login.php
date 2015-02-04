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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $errorMessage = "";
    
    /* strip of any sketchy characters */
    $email = htmlspecialchars($email);
    $pass = htmlspecialchars($pass);
    
    /*connect to database */
    $user_name = "root";
    $pass_word = "root";
    $database = "users";
    $server = "localhost:8888";
    
    $db_handle = mysql_connect($server, $user_name, $pass_word);
    $db_found = mysql_select_db($database, $db_handle);
    
    /* if dabatase connected */
    if ($db_found) {
        /*prevent SQL injection */
        $email = quote_smart($email, $db_handle);
		$pass = quote_smart($pass, $db_handle);
        
        /* build sql query */
        $SQL = "SELECT * FROM users WHERE email = $email AND password = $pass";
        $result = mysql_query($SQL);
        
        /* if query returned */
        if ($result) {
            $num_rows = mysql_num_rows($result);
            /* if there is atleast one row, user exists */
            if ($num_rows > 0) {
                $errorMessage= "logged on ";
                /* create session */
                session_start();
                $_SESSION['login'] = "1";
                header ("Location: index.php");
            }
            else {
                $errorMessage= "Incorrect email or password!";               
            }
        }
        else {
            $errorMessage = "No sql result";
        }
    }
    else {
        $errorMessage = "SQL error";
    }
    
}
?>
<?php include("assets/templates/header.php"); ?>
    <section id="register" class="about section">
        <div class="container" class="intro text-center">
            <br>
            <br>
            <h2 class="title text-center">Login</h2>  
            <h3 class="title text-center"><?PHP print $errorMessage;?> </h3>
            <form action="login.php" method="post" class="intro text-center">
                <input type="text" name="email" placeholder="E-mail" class="inputs"><br>
                <input type="password" name="pass" placeholder="Password" class="inputs"><br>
                <input type="submit" class="btn btn-cta-primary">
            </form>
        </div>
    </section>
<?php include("assets/templates/footer.html"); ?>