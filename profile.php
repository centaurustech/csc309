<?php include("assets/templates/header.php"); ?>

<?php
	if (isset($_GET['id'])) {
		$userid = $_GET['id'];
		$SQL = "SELECT * FROM users WHERE userid = $userid";
	} else {
		$email = $_SESSION['email'];
		$SQL = "SELECT * FROM users WHERE email = '$email'";
	}
	

	/*connect to database */
    include("sql.php");

    
    $result = mysql_query($SQL);

    //retrieve user data from sql server and web server.
    $row = mysql_fetch_array($result, MYSQL_ASSOC);
    $name = $row['name'];
	$email = $row['email'];
	$user_id = $row['userid'];
	$raw_date = $row['date'];
	$reputation = $row['reputation'];
	$bio = $row['bio'];
	$date = date("F j, Y", strtotime($raw_date));
	$profile_pic_location = "user_" . $user_id . "_pic.jpg"; 
	
	//Variables for profile vote status check.
	$current_logged_user_id = $_SESSION['current_user_id'];
	if (isset($_GET['id'])) {
		$votee = $_GET['id'];
	}
	
	//Find projects initiated by the current user.
	$SQL2 = "SELECT * FROM projects WHERE creator = '$email' ORDER BY date DESC";
    $result2 = mysql_query($SQL2);
	
	//Find projects contributed to by the current user.
	$SQL3 = "CREATE OR REPLACE VIEW current_contributions AS SELECT pID, user, amount_funded, date FROM transactions WHERE user = '$email'";
	mysql_query($SQL3);
	
	//Find info for projects contributed to by the current user.
	$SQL4 = "SELECT projects.pID, title, amount_funded FROM projects JOIN current_contributions WHERE projects.pID = current_contributions.pID ORDER BY current_contributions.date DESC";
	$result6 = mysql_query($SQL4);
?>

<div class="container" id="profile_container">
	<br>
	<br>
	<br>
	<?php
		if (!isset($_GET['id']) OR ($current_logged_user_id == $votee)) {
	?>
			<a class="btn btn-cta-secondary" href="Edit.php">Edit</a>
	<?php
		}
	?>
    <h1 class="title text-center profile_headings">Welcome to <?=$name?>'s Profile!</h1>
    <div class="row">
        <div class="col-md-3">
        <br>
			<img id="profile_pic" class="img-rounded" src="assets/images/profile_pics/<?=$profile_pic_location?>" alt="profile picture" width=250 height=250>
		</div>
		<div id="profile_friends" >
				<h2 class="profile_headings">My Community</h2>
				<ul>
					<?php
					$result3 = mysql_query("SELECT * FROM friends WHERE userid='$user_id'");
					$friends = array();
					while ($row3 = mysql_fetch_array($result3, MYSQL_ASSOC)) {
						$project = $row3['pid'];
						$result4 = mysql_query("SELECT * FROM friends WHERE pID='$project' AND userid != '$user_id'");
						while($row4 = mysql_fetch_array($result4, MYSQL_ASSOC)){
							$friendid = $row4['userid'];
							$result5 = mysql_query("SELECT * FROM users WHERE userid='$friendid'");
							$row5 = mysql_fetch_array($result5, MYSQL_ASSOC);
							$friend = $row5['name'];
							if (!(in_array($friend, $friends))) {
								$friends[] = $friend;
							?>
							<li><a href="profile.php?id=<?=$friendid?>"><?=$friend?></a></li>
							<?php
						}
							
						}
					}
					?>
				</ul>
		</div>
	</div>
	<br>
	<div id="bio" class="well">
		<h3 class="profile_headings">About Me</h3>
		<p><?=$bio?></p>
	</div>
        
        <div id="stat" class="well">
		<p id="reputation">Reputation Score: <?=$reputation?></p>
		<p id="join_date">Date Joined: <?=$date?></p>
	</div>
        
		


	<div id="profile_projects">
		<ul>
			<li>
				<h2 class="profile_headings">My Projects</h2>
			</li>
		<?php
			while($row6 = mysql_fetch_array($result2, MYSQL_ASSOC)){
				$title = $row6['title'];
				$id = $row6['pID'];
				$date_created = $row6['date'];
		?>
			
			<li>
				<p>Created <a href="projectinfo2.php?id=<?=$id?>"><?=$title?></a> on <?=date("F j, Y", strtotime($date_created))?></p>
			</li>
			<br>
		<?php 
				}
		 ?>
		</ul>
	</div>
	<div id="like_function">
		<?php
			//Check if the user is logged in and viewing the profile of a friend.
			if (isset($_SESSION['name']) AND isset($_GET['id']) AND in_array($_SESSION['name'], $friends)) {
			
				
				//Get current user voting data with respect to the profile being viewed.
				$find_vote_status = "SELECT * FROM profile_votes WHERE voter = $current_logged_user_id AND votee = $votee";
				$result = mysql_query($find_vote_status);
				
				//Check if the current page is a refresh of the same page after the user has just voted.
				if (isset($_GET['message'])) {
					echo "<h4>Thank you for voting!</h4>";
				}
		
				//Check if the currently logged in user has already voted.
				else if (mysql_num_rows($result) > 0) {
				
					echo "<h4>You've already voted on this profile!</h4>";

				}				
				
				//The current user has not yet voted on this friend.
				else {
		?>
					<h4>What do you think of my work?</h4>
					<form action="process_rep.php" method="post">
						<div id="like_buttons">
							<button name="like" type="submit" value="1">Like</button>
							<button name="dislike" type="submit" value="1">Dislike</button>
							<input type="hidden" name="user_id" value="<?=$user_id?>"></hidden>
						</div>
					</form>
		<?php
				}
			}
			
			//The current user is not friends with the current profile being viewed.
			else if (isset($_GET['id']) AND !($current_logged_user_id == $votee)) {
				echo "<h4>Get to know this user in order to vote!</h4>";
			}
			
			//The current user is viewing their profile.
			else {
				echo "<h4>My Recent Activity!</h4>";
			}
		?>
	</div>
		
	<div id="profile_contributions">
		<ul>
			<li>
				<h2 class="profile_headings">My contributions</h2>
			</li>
			<?php
			while($row4 = mysql_fetch_array($result6, MYSQL_ASSOC)){
				$title = $row4['title'];
				$id = $row4['pID'];
				$amount_funded = $row4['amount_funded'];
		?>
			
			<li>
				<p>Donated $<?=$amount_funded?> to:</p>
				<a href="projectinfo2.php?id=<?=$id?>"><?=$title?></a>
			</li>
			<br>
		<?php 
				}
		 ?>
		</ul>
	</div>
</div>
</div>

<?php include("assets/templates/footer.html"); ?>