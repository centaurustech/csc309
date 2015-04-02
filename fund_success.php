<?php
	
	session_start();
    
	/*connect to database */
    $user_name = "root";
    $pass_word = "csc309";
    $database = "users";
    $server = "104.236.231.174:3306";;
    
    $db_handle = mysql_connect($server, $user_name, $pass_word);
    $db_found = mysql_select_db($database, $db_handle);

    $id = $_GET['id'];
    $SQL = "SELECT * FROM projects WHERE pID = $id";
    $result = mysql_query($SQL);
    $row = mysql_fetch_array($result, MYSQL_ASSOC);

    //get project info
    $title = $row['title'];
    $desc = $row['description'];
    $creator = $row['creator'];
    $goal = $row['goal'];
    $date = $row['date'];
    $community = $row['community'];
    $funded = $row['funded'];
    $amount = $_POST['amount'];
    $percentage = round(($funded / $goal) * 100);
    $new_amount = $funded + $amount;

    $SQL2 = "UPDATE projects SET funded=$new_amount WHERE pID = $id";
    mysql_query($SQL2);
	
	//Alter the transactions table in the database.
	$funder_email = $_SESSION['email'];
	$SQL3 = "INSERT INTO transactions VALUES(DEFAULT, $id, $funder_email, $amount, DEFAULT)";
	$result = mysql_query($SQL3);

    if ($new_amount >= $goal) {
        mysql_query("UPDATE projects SET datefunded=CURRENT_TIMESTAMP WHERE pID = $id");
    }

    //add user to community
    $result = mysql_query("SELECT * FROM users WHERE email=$funder_email");
    $row = mysql_fetch_array($result, MYSQL_ASSOC);
    $userid = $row['userid'];

    mysql_query("INSERT INTO friends (pid, userid) VALUES ('$id', '$userid')");
    
	header ("Location: projectinfo2.php?id=$id");
?>
