<?php
//TODO: Need to add code to check if the user logged in is viewing the profile, to determine if edit button and other stuff should be visible.  
    $email = $_SESSION['email'];
    $email = htmlspecialchars($email);

    /*connect to database */
    $user_name = "root";
    $pass_word = "csc309";
    $database = "users";
    $server = "104.236.231.174:3306";

    // Create connection
    
    $db_handle = mysql_connect($server, $user_name, $pass_word, $database);
    if (!$db_handle) {
    die("Connection failed: " . mysqli_connect_error());
	}

    $SQL = "SELECT * FROM users WHERE email = $email";
    $result = mysql_query($SQL);

    //retrieve user data from sql server
    $row = mysql_fetch_array($result, MYSQL_ASSOC);
    $user_id = $row['userid'];
    
    $profile_pic_location = "user_" . $user_id . "_pic.jpg"; //Might have to add code which checks the file format.

    $username = htmlspecialchars($_POST['nameInput']);
    $pass = htmlspecialchars($_POST['passwordInput']);
    $pass2 = htmlspecialchars($_POST['passwordInput2']);
    $location = htmlspecialchars($_POST['cityInput']. $_POST['stateInput']. $_POST['CountryInput'] );
    $bio = htmlspecialchars($_POST['bioInput']);
    $email = htmlspecialchars($_POST['emailInput']);

    $sql3 = "UPDATE $database SET name=$username, password=$pass, location=$location, bio=$bio, email=$email WHERE id=$user_id";
    if (mysqli_query($db_handle, $sql3)) {
    	echo "Record updated successfully";
	} else {
    echo "Error updating record: " . mysqli_error($sql3);
	}

	mysqli_close($conn);
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
if($imageFileType != "jpg" && $imageFileType != "jpeg"){
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
      //  echo "Sorry, there was an error uploading your file.";
    }
}



?>  
 