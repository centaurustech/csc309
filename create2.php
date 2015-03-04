<?php

//Initialize error message.
$errorMessage = "";
/*if page is accessed after attempt */
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $title = $_POST['title'];
    $type = $_POST['type'];
    $desc = $_POST['desc'];
    $community = $_POST['community'];
    $goal = $_POST['goal'];
    $email = $_POST['email'];
    
    //make sure all fields are set
    if (!empty($desc) && !empty($goal) && !empty($community)){
        
    /* strip of any sketchy characters */
    $title = htmlspecialchars($title);
    $desc = htmlspecialchars($desc);
    $community = htmlspecialchars($community);
    $email = htmlspecialchars($email);
    $type = htmlspecialchars($type);

    /*connect to database */
    $user_name = "root";
    $pass_word = "csc309";
    $database = "users";
    $server = "104.236.231.174:3306";

    $db_handle = mysql_connect($server, $user_name, $pass_word);
    $db_found = mysql_select_db($database, $db_handle);

    if ($db_found) {
        /*check if project exists */
        $SQL = "SELECT * FROM projects WHERE title = $title";
        $result = mysql_query($SQL);
        $num_rows = mysql_num_rows($result);

        if ($num_rows > 0) {
            $errorMessage = "Project Title already taken";
        }
        else {
            $SQL = "INSERT INTO projects (title, description, creator, goal, community, category) VALUES ('$title', '$desc', 
                '$email', '$goal', '$community', '$type')";
            
            //execute
            $result = mysql_query($SQL);
            $errorMessage= "Created!";
            mysql_close($db_handle);

            //store current project
            session_start();
            $_SESSION['project'] = "$title";
            header ("Location: projectinfo.php");
        }
    }
    else {
        $errorMessage = "Database Not Found";
    }
}
    
}
?>
<?php include("assets/templates/header.php"); ?>
    <section id="register" class="about section">
        <div class="container" class="intro text-center">
            <br>
            <br>
            <h2 class="title text-center">Tell us more about <?=$title?>!</h2> 
            <h3 class="title text-center"><?PHP print $errorMessage;?> </h3>
            <form action="#" method="post" class="intro text-center">
                Project Title: <input type="text" name="title" value=<?=$title?> class="inputs" required><br>
                Project Description: <textarea name="desc" placeholder="Description" class="inputs" required></textarea><br>
                Community: <input type="text" name="community" placeholder="Community" class="inputs" required><br>
                Funding Goal: <input type="number" name="goal" placeholder="Funding Goal" class="inputs" required><br>
                Your Email: <input type="text" name="email" value=<?=$_SESSION['email']?> class="inputs" required><br>
                Category: <input type="text" name="type" value=<?=$_POST['type']?> class="inputs" required><br>
                <input type="submit" class="btn btn-cta-primary">
            </form>
        </div>
    </section>
<?php include("assets/templates/footer.html"); ?>