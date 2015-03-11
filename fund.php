<?php include("assets/templates/header.php"); ?>
<?php          
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
    $percentage = round(($funded / $goal) * 100);
?>
<?php include("assets/templates/footer.html"); ?>