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
<br>
<br>
<br>
<br>
    <div id="login-overlay" class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
              <h4 class="modal-title" id="myModalLabel">Login to CommunityFund</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-xs-6">
                      <div class="well">
                          <h3 class="title text-center"><?PHP print $errorMessage;?> </h3>
                          <form action="login_new.php" method="post" class="intro text-center">
                              <div class="form-group">
                                  <label for="username" class="control-label">Email</label>
                                  <input type="text" class="form-control" id="email" name="email" value="" required title="Please enter your email" placeholder="example@gmail.com">
                                  <span class="help-block"></span>
                              </div>
                              <div class="form-group">
                                  <label for="password" class="control-label">Password</label>
                                  <input type="password" class="form-control" id="password" name="pass" value="" required title="Please enter your password">
                                  <span class="help-block"></span>
                              </div>
                              <button type="submit" class="btn btn-success btn-block">Login</button>
                              <a href="#" class="btn btn-default btn-block">Can't Login</a>
                          </form>
                      </div>
                  </div>
                  <div class="col-xs-6">
                      <p class="lead">Register</p>
                      <ul class="list-unstyled" style="line-height: 2">
                          <li><span class="fa fa-check text-success"></span> Create Projects</li>
                          <li><span class="fa fa-check text-success"></span> Fund other's projects</li>
                          <li><span class="fa fa-check text-success"></span> Keep track of your projects</li>
                          <li><span class="fa fa-check text-success"></span> Join/Create Communities</li>
                          <li><span class="fa fa-check text-success"></span> Takes only 2 minutes</li>
                      </ul>
                      <p><a href="register.php" class="btn btn-info btn-block">Register now!</a></p>
                  </div>
              </div>
          </div>
      </div>
  </div>

<?php include("assets/templates/footer.html"); ?>