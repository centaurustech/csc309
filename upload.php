<?php
    session_start();
    if (isset($_GET['id'])) {
        $userid = $_GET['id'];
        $SQL = "SELECT * FROM users WHERE userid = $userid";
    } else {
        $email = $_SESSION['email'];
        $SQL = "SELECT * FROM users WHERE email = $email";
    }
    

    /*connect to database */
   include("sql.php");
    
    $result = mysql_query($SQL);
    //retrieve user data from sql server
    $row = mysql_fetch_assoc($result);
    $user_id = $_SESSION['uid'];

    $profile_pic_location = "user_" . $user_id . "_pic.jpg"; 

    $username = htmlspecialchars($_POST['nameInput']);
    $pass = htmlspecialchars($_POST['passwordInput']);
    $pass2 = htmlspecialchars($_POST['passwordInput2']);
    $bio = htmlspecialchars($_POST['bioInput']);

    if ($db_found) {
        $sql_user = "UPDATE $database SET name='$username' WHERE userid='$user_id'";
        $sql_pass = "UPDATE $database SET password='$pass' WHERE userid='$user_id'";
        $sql_bio = "UPDATE $database SET bio='$bio' WHERE userid='$user_id'";
    
        mysql_query($sql_user);
        mysql_query($sql_pass);
        mysql_query($sql_bio);
	    mysql_close($db_handle);
    }else
    {
        $errorMessage = "Database Not Found";
    }
?>
<?php
$target_dir = "assets/images/profile_pics/";
$target_file = $target_dir . $profile_pic_location;
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        //echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    //echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType !="gif"){
	//$imageFileType != "png" && 
    //&& $imageFileType != "gif" ) {
    //echo "Sorry, only Jpeg files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    //echo "You need to upload the file.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}



?> 
<html>
  <body onload="document.getElementById('lnkhome').click();">
    <a href="profile.php" id="lnkhome">Go to Home Page</a>
  </body>
</html>
 