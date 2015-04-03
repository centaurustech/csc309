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
//Initialize error message.
$errorMessage = "";
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
    include("sql.php");
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

            $SQL = "INSERT INTO users (email, name, password, location, bio) VALUES ($email, $name, $pass, '', '')";
            $errorMessage= "registered!";
            $result = mysql_query($SQL);
            mysql_close($db_handle);
                
            //open sessions
            session_start();
            $_SESSION['login'] = "1";
            $_SESSION['email'] = $email;
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
<br>
<br>
    <div id="login-overlay" class="modal-dialog" style="margin-top:100px">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel">Register</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-xs-12">
                      <div class="well">
                          <h3 class="title text-center"><?PHP print $errorMessage;?> </h3>
                          <form action="register.php" method="post" class="intro text-center">
                              <div class="form-group">
                                  <label for="username" class="control-label">Name</label>
                                  <input  class="form-control" type="text" name="name" placeholder="Name" class="inputs" required><br>
                                  <span class="help-block"></span>
                              </div>
                              <div class="form-group">
                                  <label for="username" class="control-label">Email</label>
                                  <input  class="form-control" type="text" name="email" placeholder="Email" class="inputs" required><br>
                                  <span class="help-block"></span>
                              </div>
                              <div class="form-group">
                                  <label for="password" class="control-label">Password</label>
                                  <input  class="form-control" type="password" name="pass" placeholder="Password" class="inputs" required><br>
                                  <span class="help-block"></span>
                              </div>
                              <div class="form-group">
                                  <label for="password" class="control-label">Re-enter Password</label>
                                  <input class="form-control" type="password" name="pass2" placeholder="Re-enter Password" class="inputs" required><br>
                                  <span class="help-block"></span>
                              </div>
                              <button type="submit" class="btn btn-theme btn-block">Register</button>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

<?php include("assets/templates/footer.html"); ?>