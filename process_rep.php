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
	
	mysql_query("INSERT INTO profile_votes VALUES($current_logged_user, $user_id)");
	mysql_query("UPDATE users SET reputation=reputation" . $like_dislike . "1 WHERE userid=$user_id");
	header("Location:profile.php?id=$user_id&message=Thank you for voting!");
?>