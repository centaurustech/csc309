<?php
//TODO: Need to add code to check if the user logged in is viewing the profile, to determine if edit button and other stuff should be visible.  
    $email = $_SESSION['email'];
    $email = htmlspecialchars($email);

    /*connect to database */
    $user_name = "root";
    $pass_word = "csc309";
    $database = "users";
    $server = "104.236.231.174:3306";
    
    $db_handle = mysql_connect($server, $user_name, $pass_word);
    $db_found = mysql_select_db($database, $db_handle);

    $SQL = "SELECT * FROM users WHERE email = $email";
    $result = mysql_query($SQL);

    //retrieve user data from sql server
    $row = mysql_fetch_array($result, MYSQL_ASSOC);
    $name = $row['name'];
    $email = $row['email'];
    $user_id = $row['userid'];
    $raw_date = $row['date'];
    $reputation = $row['reputation'];
    $location = $row['location'];
    $bio = $row['bio'];
    
    $date = process_date($raw_date);
    $profile_pic_location = "user_" . $user_id . "_pic.jpg"; //Might have to add code which checks the file format.

    $SQL2 = "SELECT * FROM projects WHERE creator = '$email'";
    $result2 = mysql_query($SQL2);

?>
<?php
$target_dir = "assets/images/profile_pics";
$target_file = $target_dir . $profile_pic_location;
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "jpeg"){
	//$imageFileType != "png" && 
    //&& $imageFileType != "gif" ) {
    echo "Sorry, only Jpeg files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "You need to upload the file.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
} 
?>  
 