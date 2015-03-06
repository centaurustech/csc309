<?php include("assets/templates/header.php"); ?>
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
	$date = $row['date'];
?>
    <section id="profile" class="about section">
        <div class="container" class="intro text-center">
            <br>
            <br>
            <h2 class="title text-center">Welcome to your profile <?=$name?>!</h2>
			<div id="basic_info">
				<img id="profile_pic" src="assets/images/profile_pics/user_5_pic.jpg" alt="Profile Picture" width=250 height=250>
				<p id="reputation">Reputation Score:</p>
				<p id="location">Location:</p>
				<p id="join date">Date Joined: <?=$date?></p>
			</div>
			<div id="recent_activity">
				<h2>My recent Activity</h2>
				<ul>
					<li>Activity 1</li>
					<li>Activity 2</li>
					<li>Activity 3</li>
				</ul>
			</div>
			<div id="bio">
				<h3>About Me</h3
				<p>This is a big splerge about my life and how it exists as a thing that requires multiple lines of blah
				blah blah blah blah blahblah blahblahblahblahblahblahblahblahblahblahblahblahblahblahblahblahblahblah
				blahblahblahblahblahblahblahblahblahblahblahblahhttp blah blah bah bahbahbahbahbahbahbahbah bahbah
				bahbahbahbahbahbahbahbahbahbahbahbahbahbahbahbahbahbahbahbahbahbahbahbahbahbahbahbahbah
				bahbahbahbahbahbahbahbahbah
				</p>
			</div>
			<div id="profile_projects">
				<h2>My recent projects</h2>
				<ul>
					<li>P1</li>
					<li>P2</li>
					<li>P3</li>
				</ul>
			</div>
			<div id="profile_contributions">
				<h2>My recent contributions<h2>
				<ul>
					<li>P1</li>
					<li>P2</li>
					<li>P3</li>
				</ul>
			</div>
        </div>
    </section>
<?php include("assets/templates/footer.html"); ?>