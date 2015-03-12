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
    $user_id = $row['userid'];
    $raw_date = $row['date'];
    $reputation = $row['reputation'];
    $location = $row['location'];
    $bio = $row['bio'];
    
    $date = process_date($raw_date);
    $profile_pic_location = "user_" . $user_id . "_pic.jpg"; //Might have to add code which checks the file format.

    $SQL2 = "SELECT * FROM projects WHERE creator = '$email'";
    $result2 = mysql_query($SQL2);

?>
<br>
<br>
<br>

<div class="container jumbotron">
	<div class="row">
		<div class="col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
    	 <div >
            <div class="col-sm-12">
                <div class="col-xs-12 col-sm-8">
                    <h2><?=$name?></h2>
                    <p><strong>About: </strong> Web Designer / UI. </p>
                    <p><strong>Hobbies: </strong> Read, out with friends, listen to music, draw and learn new things. </p>
                    <p><strong>My Communities: </strong>
                        <span class="tags">html5</span> 
                        <span class="tags">css3</span>
                        <span class="tags">jquery</span>
                        <span class="tags">bootstrap3</span>
                    </p>
                </div>             
                <div class="col-xs-12 col-sm-4 text-center">
                    <figure>
                        <img src="http://www.localcrimenews.com/wp-content/uploads/2013/07/default-user-icon-profile.png" alt="" class="img-circle img-responsive">
                        <figcaption class="ratings">
                            <p>Ratings
                            <a href="#">
                                <span class="fa fa-star"></span>
                            </a>
                            <a href="#">
                                <span class="fa fa-star"></span>
                            </a>
                            <a href="#">
                                <span class="fa fa-star"></span>
                            </a>
                            <a href="#">
                                <span class="fa fa-star"></span>
                            </a>
                            <a href="#">
                                 <span class="fa fa-star-o"></span>
                            </a> 
                            </p>
                        </figcaption>
                    </figure>
                </div>
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
    	 </div>                 
		</div>
	</div>
</div>

<?php include("assets/templates/footer.html"); ?>