<?php include("assets/templates/header.php"); ?>
    <section class="about section">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <p class="lead">Categories</p>
                    <div class="list-group">
                        <a href="#" class="list-group-item">Art</a>
                        <a href="#" class="list-group-item">Technology</a>
                        <a href="#" class="list-group-item">Music</a>
                        <a href="#" class="list-group-item">Photography</a>
                        <a href="#" class="list-group-item">Food</a>
                        <a href="#" class="list-group-item">Film and Video</a>
                        <a href="#" class="list-group-item">Design</a>
                        <a href="#" class="list-group-item">Games</a>
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

                            //add this to add filters
                            $SQL = "SELECT * FROM projects";
                            $result = mysql_query($SQL);

                            //retrieve data from sql server
                            while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
                                $title = $row['title'];
                                $desc = $row['description'];
                                $creator = $row['creator'];
                                $goal = $row['goal'];
                                $date = $row['date'];

                                //get the name of the owner of project
                                $SQL2 = "SELECT * FROM users WHERE email = '$creator'";
                                $result2 = mysql_query($SQL2);
                                $row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
                                $name = $row2['name'];
                                //html
                                ?> 
                                <div class="col-sm-6 col-lg-6">
                                    <div class="thumbnail">
                                        <img src="http://placehold.it/320x150" alt="">
                                        <div class="caption">         
                                            <h5><a href="#"><?=$title?></a>
                                            </h5>
                                            <p>Goal: $<?=$goal?></p>
                                            <p><?=$desc?></p>
                                        </div>
                                        <div class="ratings">
                                            <p class="pull-right">15 reviews</p>
                                            <p>
                                                <span class="glyphicon glyphicon-star"></span>
                                                <span class="glyphicon glyphicon-star"></span>
                                                <span class="glyphicon glyphicon-star"></span>
                                                <span class="glyphicon glyphicon-star"></span>
                                                <span class="glyphicon glyphicon-star"></span>
                                            </p>
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