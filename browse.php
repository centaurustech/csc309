<?php include("assets/templates/header.php"); ?>
    <section class="about section">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <p class="lead">Categories</p>
                    <div class="list-group">
                        <a href="browse.php" class="list-group-item">All</a>
                        <a href="browse.php?category=<?='Technology'?>" class="list-group-item">Technology</a>
                        <a href="browse.php?category=<?='Music'?>" class="list-group-item">Music</a>
                        <a href="browse.php?category=<?='Art'?>" class="list-group-item">Art</a>
                        <a href="browse.php?category=<?='Photography'?>" class="list-group-item">Photography</a>
                        <a href="browse.php?category=<?='Food'?>" class="list-group-item">Food</a>
                        <a href="browse.php?category=<?='Film and Video'?>" class="list-group-item">Film and Video</a>
                        <a href="browse.php?category=<?='Design'?>" class="list-group-item">Design</a>
                        <a href="browse.php?category=<?='Games'?>" class="list-group-item">Games</a>
                    </div>
                </div>
                <div class="col-md-10">
                    <p class="lead">Projects</p>
                    <div class="row">
                        <?php          
                            /*connect to database */
                            $user_name = "root";
                            $pass_word = "csc309";
                            $database = "users";
                            $server = "104.236.231.174:3306";;
                            
                            $db_handle = mysql_connect($server, $user_name, $pass_word);
                            $db_found = mysql_select_db($database, $db_handle);

                            //Check if filter is set
                            if (isset($_GET['category'])) {
                                $category = $_GET['category'];
                                $SQL = "SELECT * FROM projects WHERE category = '$category'";
                            } else {
                                $SQL = "SELECT * FROM projects";
                            }
                            //add this to add filters
                            
                            $result = mysql_query($SQL);

                            //retrieve data from sql server
                            while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
                                $title = $row['title'];
                                $desc = $row['description'];
                                $creator = $row['creator'];
                                $goal = $row['goal'];
                                $date = $row['date'];
                                $community = $row['community'];
                                $funded = $row['funded'];
                                $percentage = round(($funded / $goal) * 100);

                                //get the name of the owner of project
                                $SQL2 = "SELECT * FROM users WHERE email = '$creator'";
                                $result2 = mysql_query($SQL2);
                                $row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
                                $name = $row2['name'];

                                //render project box
                                ?> 
                                <div class="col-sm-6 col-lg-6">
                                    <div class="thumbnail">
                                        <div class="caption">

                                            <!-- Project Descriptions and stuff -->
                                            <?php

                                            //add a checkmark if project is fully funded
                                            if ($percentage >= 100){ ?>
                                                <h4><a href="#"><?=$title?></a>
                                                <span class="glyphicon glyphicon-ok"></span></h4>   
                                            <?php } else { ?>
                                                <h4><a href="#"><?=$title?></a></h4>
                                            <?php } ?>         
                                            <p>Created by: <?=$name?></p>                      
                                            <p class="smallaf"><?=$desc?></p>
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
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                        ?> 
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php include("assets/templates/footer.html"); ?>