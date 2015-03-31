<?php

session_start();
if ($_SESSION['login'] != "1"){
    header ("Location: login_new.php");
}

//Initialize error message.
$errorMessage = "";

/*connect to database */
    $user_name = "root";
    $pass_word = "csc309";
    $database = "users";
    $server = "104.236.231.174:3306";

    $db_handle = mysql_connect($server, $user_name, $pass_word);
    $db_found = mysql_select_db($database, $db_handle);

/*if page is accessed after attempt */
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $title = $_POST['title'];
    $category = $_POST['category'];
    $desc = $_POST['desc'];
    $email = $_SESSION['email'];
    $goal = $_POST['goal'];
    $community = $_POST['community'];
           
    /* strip of any sketchy characters */
    $title = htmlspecialchars($title);
    $desc = htmlspecialchars($desc);
    $category = htmlspecialchars($category);
    $community = htmlspecialchars($community);
    $goal = htmlspecialchars($goal);
    

    if ($db_found) {
        
        /*check if project exists */
        $SQL = "SELECT * FROM projects WHERE title = '$title'";
        $result = mysql_query($SQL);
        $num_rows = mysql_num_rows($result);

        if ($num_rows > 0) {
            $errorMessage = "Project name already taken";
        }
        else {
            $SQL = "INSERT INTO projects (title, description, creator, category, goal, community) VALUES ('$title', '$desc', 
                $email, '$category', '$goal', '$community')";
            
            //execute
            $result = mysql_query($SQL);

            //$errorMessage= 'Email: ' . $email . 'Goal: ' . $goal . 'Community: ' . $community;
            
            //get pid 
            $SQL2 = "SELECT * FROM projects WHERE title = '$title'";
            $result = mysql_query($SQL2);
            $row = mysql_fetch_array($result, MYSQL_ASSOC);
            $id = $row['pID'];

            // assign new community to new project
            mysql_query("INSERT INTO communities (community, pID) VALUES ('$community', '$id')");
            mysql_close($db_handle);

            // redirect to project info
            header ("Location: projectinfo2.php?id=" . $id);
        }
    }
    else {
        $errorMessage = "Database Not Found";
    }
    
}
?>
<?php include("assets/templates/header.php"); ?>
    <div class="container well">
        <div class="row" style="margin-top:130px">
            <h2 class="title text-center"> Tell us about your Idea!</h2>
            <h3 class="title text-center"><?=$errorMessage?> </h3>
            <h3><?=$community?></h3>
            <br>
            <form action="create.php" method="post" role="form">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <div class="well well-sm"><strong><span class="glyphicon glyphicon-asterisk"></span>Required Field</strong></div>
                    <div class="form-group">
                        <label for="InputName">Project Name</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="title" id="title" placeholder="i.e. Pebble" required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="InputCategory">Choose a category</label>
                        <div class="input-group">
                            <select name="category" class="form-control" required>
                                <option>Art</option>
						       	<option>Technology</option>
						       	<option>Music</option>
						       	<option>Photography</option>
						       	<option>Food</option>
						       	<option>Film and Video</option>
						       	<option>Design</option>
						       	<option>Games</option>
                            </select>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="InputMessage">Describe your idea!</label>
                        <div class="input-group">
                            <textarea name="desc" id="desc" class="form-control" rows="5" required placeholder="i.e. An amazing smartwatch with an LCD display..."></textarea>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="InputMessage">Funding Goal</label>
                        <div class="input-group">
                            <input type="number" name="goal" id="goal" class="form-control" required placeholder="i.e. $50000"></textarea>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="InputCategory">Choose a community for your project!</label>
                        <div class="input-group">
                            <select name="community" class="form-control" required>
                                <?php
        						$result3 = mysql_query("SELECT * FROM communities");
    							while($row3 = mysql_fetch_array($result3, MYSQL_ASSOC)){
    								$community = $row3['community'];
    								echo '<option>' . $community . '</option>';
    							}
                                ?>
                            </select>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                        </div>
                    </div>
                    <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-right">
                </div>
            </form>
        </div>
    </div>
<?php include("assets/templates/footer.html"); ?>