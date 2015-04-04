<?php

//Initialize error message.
$errorMessage = "";
/*connect to database */
include("sql.php");

/*if page is accessed after attempt */
if (isset($_GET['d'])) {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $desc = $_POST['desc'];
    $email = $_SESSION['email'];
    $id = $_GET['id'];
    $goal = $_POST['goal'];

           
    /* strip of any sketchy characters */
    $title = htmlspecialchars($title);
    $desc = htmlspecialchars($desc);
    $email = htmlspecialchars($email);
    $category = htmlspecialchars($category);
    $goal = htmlspecialchars($goal);

    if ($db_found) {
        
        /*check if project exists */
        $SQL = "SELECT * FROM projects WHERE title = '$title''";
        $result = mysql_query($SQL);
        $num_rows = mysql_num_rows($result);

        if ($num_rows > 0) {
            $errorMessage = "Idea name already taken";
        }
        else {
            mysql_query("update projects set title='$title' where pID='$id'");
            mysql_query("update projects set description='$desc' where pID='$id'");
            mysql_query("update projects set category='$category' where pID='$id'");
            mysql_query("update projects set goal='$goal' where pID='$id'");

            $errorMessage= "Changes Saved!";
            mysql_close($db_handle);

            // redirect to project info
            header ("Location: projectinfo2.php?id=" . $id);      
        }
    }
    else {
        $errorMessage = "Database Not Found";
    }   
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $id = $_GET['id'];
    $SQL = "SELECT * FROM projects WHERE pID = $id";
    $result = mysql_query($SQL);
    $row = mysql_fetch_array($result, MYSQL_ASSOC);

    //get project info
    $title = $row['title'];
    $id = $row['pID'];
    $desc = $row['description'];
    $category = $row['category'];
    $goal = $row['goal'];
}
?>
<?php include("assets/templates/header.php"); ?>
    <div class="container well">
        <div class="row"  style="margin-top:130px">
            <h2 class="title text-center"> Edit your idea!</h2>
            <h3 class="title text-center"><?=$errorMessage?> </h3>
            <br>
            <form action="editproject.php?id=<?=$id?>&d=1" method="post" role="form">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <div class="well well-sm"><strong><span class="glyphicon glyphicon-asterisk"></span>Required Field</strong></div>
                    <div class="form-group">
                        <label for="InputName">Project Name</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="title" id="title" value="<?=$title?>" placeholder="i.e. Pebble" required>
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
                            <textarea name="desc" id="desc" class="form-control" rows="5" required placeholder="i.e. An amazing smartwatch with an LCD display..."><?=$desc?></textarea>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="InputMessage">Funding Goal</label>
                        <div class="input-group">
                            <input type="number" name="goal" id="goal" class="form-control" value="<?=$goal?>" required placeholder="i.e. $50000">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                        </div>
                    </div>
                    
                    <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-right">
                </div>
            </form>
        </div>
    </div>
<?php include("assets/templates/footer.html"); ?>
