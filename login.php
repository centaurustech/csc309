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
//This variable needs to be declared outside of the if block so that it is not undefined when people initially load the login page.
$errorMessage = "";
/*if page is accessed after attempt */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    
    /* strip of any sketchy characters */
    $email = htmlspecialchars($email);
    $pass = htmlspecialchars($pass);
    
    /*connect to database */
    $user_name = "root";
    $pass_word = "csc309";
    $database = "users";
    $server = "104.236.231.174:3306";
    
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
                $row = mysql_fetch_array($result, MYSQL_ASSOC);
                $_SESSION['login'] = "1";
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $row['name'];
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
                <input type="text" name="email" placeholder="E-mail" class="inputs" required><br>
                <input type="password" name="pass" placeholder="Password" class="inputs" required><br>
                <input type="submit" value="Login" class="btn btn-cta-primary">
            </form>
        </div>
    </section>
<?php include("assets/templates/footer.html"); ?>