<?php include("assets/templates/header.php"); ?>

<?php
function process_date($raw_date) {
	$date_elements[0] = substr($raw_date, 0, 4);
	$date_elements[1] = substr($raw_date, 5, 2);
	$date_elements[2] = substr($raw_date, 8, 2);
	switch ($date_elements[1]) {
		case "01":
			$month ="January";
			break;
		case "02":
			$month ="February";
			break;
		case "03":
			$month ="March";
			break;
		case "04":
			$month ="April";
			break;
		case "05":
			$month ="May";
			break;
		case "06":
			$month ="June";
			break;
		case "07":
			$month ="July";
			break;
		case "08":
			$month ="August";
			break;
		case "09":
			$month ="September";
			break;
		case "10":
			$month ="October";
			break;
		case "11":
			$month ="November";
			break;
		case "12":
			$month ="December";
			break;
	}
	return $month . " " . $date_elements[2] . ", " . $date_elements[0];
}

?>
<?php
//TODO: Need to add code to check if the user logged in is viewing the profile, to determine if edit button and other stuff should be visible.
	if (isset($_GET['id'])) {
		$userid = $_GET['id'];
		$SQL = "SELECT * FROM users WHERE userid = $userid";
	} else {
		$email = $_SESSION['email'];
		$SQL = "SELECT * FROM users WHERE email = $email";
	}
	

	/*connect to database */
    $user_name = "root";
    $pass_word = "csc309";
    $database = "users";
    $server = "104.236.231.174:3306";
    
    $db_handle = mysql_connect($server, $user_name, $pass_word);
    $db_found = mysql_select_db($database, $db_handle);

    
    $result = mysql_query($SQL);

    //retrieve user data from sql server and web server.
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
	
	//Find projects initiated by the current user.
	$SQL2 = "SELECT * FROM projects WHERE creator = '$email'";
    $result2 = mysql_query($SQL2);
	
	//Find projects contributed to by the current user.
	$SQL3 = "CREATE OR REPLACE VIEW current_contributions AS SELECT pID, user FROM transactions WHERE user = '$email'";
	mysql_query($SQL3);
	
	//Find info for projects contributed to by the current user.
	$SQL4 = "SELECT projects.pID, title FROM projects JOIN current_contributions WHERE projects.pID = current_contributions.pID";
	$result3 = mysql_query($SQL4);
?>
    <section id="profile">
        <div class="container">
            <br>
            <br>
            <br>
			<?php
				if (!isset($_GET['id'])) {
			?>
					<a class="btn btn-cta-secondary" href="Edit.php">Edit</a>
					<h2 class="title text-center profile_headings">Welcome to your profile <?=$name?>!</h2>
			<?php
				}
				else {
			?>
					<h2 class="title text-center profile_headings"><?=$name?>!</h2>
			<?php
				}
			?>
			<img id="profile_pic" src="assets/images/profile_pics/<?=$profile_pic_location?>" alt="Profile picture" width=250 height=250>
			<div id="recent_activity">
				<h2 class="profile_headings">My Recent Activity</h2>
				<ul>
					<li>A1</li>
					<li>A2</li>
					<li>A3</li>
					<li>A4</li>
					<li>A5</li>
				</ul>
			</div>
			<div id="basic_info">
				<p id="reputation">Reputation Score: <?=$reputation?></p>
				<p id="location">Location: <?=$location?></p>
				<p id="join_date">Date Joined: <?=$date?></p>
			</div>
			<div id="bio">
				<h3 class="profile_headings">About Me</h3>
				<p><?=$bio?></p>
			</div>
			<div id="profile_projects">
				<h2 class="profile_headings">My Projects</h2>
				<ul>
				<?php
					while($row2 = mysql_fetch_array($result2, MYSQL_ASSOC)){
						$title = $row2['title'];
						$id = $row2['pID'];
				?>
					
					<li><a href="projectinfo2.php?id=<?=$id?>"><?=$title?></a></li>
				<?php 
						}
				 ?>
				</ul>
			</div>
			<div id="profile_contributions">
				<h2 class="profile_headings">My contributions</h2>
				<ul>
					<?php
					while($row3 = mysql_fetch_array($result3, MYSQL_ASSOC)){
						$title = $row3['title'];
						$id = $row3['pID'];
				?>
					
					<li><a href="projectinfo2.php?id=<?=$id?>"><?=$title?></a></li>
				<?php 
						}
				 ?>
				</ul>
			</div>
        </div>
    </section>
<?php include("assets/templates/footer.html"); ?>