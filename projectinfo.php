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
    $id = $row['pID'];
    $desc = $row['description'];
    $creator = $row['creator'];
    $goal = $row['goal'];
    $date = $row['date'];
    $community = $row['community'];
    $funded = $row['funded'];
    $percentage = round(($funded / $goal) * 100);
?>
	<section class="about section">
		<div class="container">
                        <h1><?=$title?></h1> <!--as filled out on previous page-->
                        <h4>By: <?=$creator?></h4> <!--user's name as registered-->
                        <h3>Community: <?=$community?><h3>
                        <img src="http://upload.wikimedia.org/wikipedia/commons/2/27/ORDbot_quantum.jpg" alt="Mountain View" style="width:304px;height:228px"><br><br>
                        <p>
                        "This is a project yay. y'all should fund me hey. <br>
                        I want ur money, so fund me."<br>
                        </p><br>
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/l9ZISxSo2X0" frameborder="0" allowfullscreen></iframe><br><br>
                        <h4>Fund x to receive y.</h4><br>
                        <h2>$100/$1,000 funded<h2><br>
                        <button type="button">Fund!</button>
                        
		</div>
            


	</section>
<?php include("assets/templates/footer.html"); ?>