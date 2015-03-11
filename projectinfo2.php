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
    $date = process_date($row['date']);
    $community = $row['community'];
    $funded = $row['funded'];
    $percentage = round(($funded / $goal) * 100);
?>

<!-- Page Content -->
    <br>
    <br>
    <br>
    <div class="container">

        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8">

                <!-- Blog Post -->

                <!-- Title -->
                <h1><?=$title?></h1>

                <!-- Author -->
                <p class="lead">
                    by <a href="#"><?=$creator?></a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Created on <?=$date?></p>

                <hr>

                <!-- Preview Image -->
                <img class="img-responsive" src="http://placehold.it/900x300" alt="">

                <hr>

                <!-- Post Content -->
                <h4> Project Description </h4>
                <p class="lead"><?=$desc?></p>

                <hr>

                <!-- Blog Comments -->

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form">
                        <div class="form-group">
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">Start Bootstrap
                            <small>August 25, 2014 at 9:30 PM</small>
                        </h4>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                    </div>
                </div>

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">Start Bootstrap
                            <small>August 25, 2014 at 9:30 PM</small>
                        </h4>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                        <!-- Nested Comment -->
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">Nested Start Bootstrap
                                    <small>August 25, 2014 at 9:30 PM</small>
                                </h4>
                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                            </div>
                        </div>
                        <!-- End Nested Comment -->
                    </div>
                </div>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <br>
            <div class="col-md-4">

                <!-- Funding Info Well -->
                <div class="well">
                    <h4>Funding</h4>
                    <!-- Project Descriptions and stuff -->
                    <div class="row">
                        <div class="col-sm-6 col-lg-6">
                            <p>
                            <span class="glyphicon glyphicon-globe"></span>
                            <?=$community?></p>
                        </div>
                        <div class="col-sm-6 col-lg-6">
                            <p><span class="glyphicon glyphicon-usd"></span>
                            <?=number_format($funded)?> funded!
                            </p>
                        </div>
                    </div>
                    <!-- Progress bar -->
                    <div class="progress">
                        <?php
                        if ($percentage == 0){ ?>
                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="100"
                            aria-valuemin="0" aria-valuemax="100" style='width:100%'>
                            Not Funded Yet!
                            </div>
                        <?php } elseif ($percentage >= 100){ ?>
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow=<?=$percentage?>
                            aria-valuemin="0" aria-valuemax="100" style='width:<?=$percentage?>%'>
                            <?=$percentage?>% of $<?=number_format($goal)?>
                            </div>
                        <?php } else { ?>
                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow=<?=$percentage?>
                            aria-valuemin="0" aria-valuemax="100" style='width:<?=$percentage?>%'>
                            <?=$percentage?>% of $<?=number_format($goal)?>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- Fund Button -->
                    <p>You can support this project by funding it. To fund, press the button below!</p>
                    <h2><a class="btn btn-cta-secondary" href="fund.php?id=<?=$id?>">Fund this project!</a></h2>

                </div>

                <!-- Side Widget Well -->
                <div class="well">
                    <h4>Side Widget Well</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
                </div>

            </div>

        </div>
        <!-- /.row -->
    </div>

<?php include("assets/templates/footer.html"); ?>