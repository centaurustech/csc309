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

<head>
<style>
.left {
    width: 30%;
    float: left;
    text-align: right;
}
.right {
    width: 65%;
    margin-left: 10px;
    float:left;
}
.button {
    display:block;
    text-align:center;
}
</style>
</head>

<?php include("assets/templates/header.php"); ?>
    <section id="register" class="about section">
        <div class="container" class="intro text-center">
            <br>
            <br>
            <h2 class="title text-center">Tell us more about <?=$title?>!</h2> 
            <h3 class="title text-center"><?PHP print $errorMessage;?> </h3>
            <div>
                <div class="left">
                    <h4>Title:</h4>
                </div>
                <div class="right">
                    <input type="text" name="title" class="inputs" required>
                </div>
            </div>
            <div>
                <div class="left">
                    <h4>Description:</h4>
                </div>
                <div class="right">
                    <textarea name="desc" placeholder="Description" class="inputs" required></textarea>
                </div>
            </div>     
            <div>
                <div class="left">
                    Community: 
                </div>
                <div class="right">
                    <select>
                        <option value="op1">Hackers</option>
                        <option value="op2">CSC309</option>
                        <option value="op3">Toronto</option>
                        <option value="op4">Ontario</option>
                    </select><Br>
                </div>
            </div>
            <div>
                <div class="left">
                    Image: 
                </div>
                    <div class="right">
                        <input type="file" name="datafile" size="40"></p>
                    </div>
            </div>
            <div>
                <div class="left">
                    <h4>Youtube Video Embed:</h4>
                </div>
                <div class="right">
                    <input type="text" name="video" class="inputs" required>
                </div>
            </div> 
            <div>
                <div class="left">
                    <h4>Funding Goal:</h4>
                </div>
                <div class="right">
                    <input type="number" name="goal" placeholder="Funding Goal" class="inputs" required>
                </div>
            </div>     
            <div>
                <div class="left">
                    <h4>Amount:</h4>
                </div>
                <div class="right">
                    <input type="number" name="amount" placeholder="Reward Amount" class="inputs" required>
                </div>
            </div>        
            <div>
                <div class="left">
                    <h4>Reward:</h4>
                </div>
                <div class="right">
                    <textarea name="reward" placeholder="Reward" class="inputs" required></textarea>
                </div>
            </div>
        <span class="button">
    <button type="button">Create!</button>
</span>
        </div>

        
    </section>
<?php include("assets/templates/footer.html"); ?>