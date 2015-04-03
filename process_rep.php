<?php
	session_start();
	/*connect to database */
    include("sql.php");
	
	$user_id = $_POST['user_id'];
	$current_logged_user = $_SESSION['current_user_id'];
	

	if (isset($_POST['like'])) {
		$like_dislike = '+';
	}
	else {
		$like_dislike = "-";
	}
	
	//Check if the currently logged in user has already voted, and act accordingly.
	$SQL1 = "SELECT * FROM profile_votes WHERE voter = $current_logged_user AND votee = $user_id";
	$result = mysql_query($SQL1);
	//echo var_dump($result);
	
	if (mysql_num_rows($result) == 0) {
		mysql_query("INSERT INTO profile_votes VALUES($current_logged_user, $user_id)");
		mysql_query("UPDATE users SET reputation=reputation" . $like_dislike . "1 WHERE userid=$user_id");
		header("Location:profile.php?id=$user_id");
	}
	
	else {
		header("Location:profile.php?id=$user_id&message=Sorry, but you've already voted on this profile!");
	}
?>