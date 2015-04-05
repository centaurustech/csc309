<?php
	
	session_start();
    
	/*connect to database */
    include("sql.php");

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
    $funded = $row['funded'];
	
    //Check to make sure that the amount is positive, and redirect to the funding page if not.
	$amount = $_POST['amount'];
    if ($amount <= 0) {
		header("Location: fund.php?id=$id&message=Please ensure that you provide a positive donation value!");
		exit;
	}
	
	$percentage = round(($funded / $goal) * 100);
    $new_amount = $funded + $amount;

    $SQL2 = "UPDATE projects SET funded=$new_amount WHERE pID = '$id'";
    mysql_query($SQL2);
	
	//Alter the transactions table in the database.
	$funder_email = $_SESSION['email'];
	$SQL3 = "INSERT INTO transactions VALUES(DEFAULT, '$id', '$funder_email', '$amount', DEFAULT)";
	$result = mysql_query($SQL3);

    if ($new_amount >= $goal) {
        mysql_query("UPDATE projects SET datefunded=CURRENT_TIMESTAMP WHERE pID = $id");
    }

    //add user to community
    $result = mysql_query("SELECT * FROM users WHERE email='$funder_email'");
    $row = mysql_fetch_array($result, MYSQL_ASSOC);
    $userid = $row['userid'];

    mysql_query("INSERT INTO friends (pid, userid) VALUES ('$id', '$userid')");
    
	header ("Location: projectinfo2.php?id=$id");
?>
