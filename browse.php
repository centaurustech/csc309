<?php include("assets/templates/header.php"); ?>
    <section class="about section">
        <div class="intro text-center">
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
                    //html
                    ?>
                    <div class="title text-center boxed">
                        <h3>Project name: <?=$title?></h3>
                        <p>Description: <?=$desc?> <br>
                        Description: <?=$desc?><br>
                        Creator: <?=$creator?><br>
                        Goal: <?=$goal?><br>
                        Date: <?=$date?><br>
                        </p>

                        
                    </div>
                    <br>
                    
                    <?php
                }
            ?>
        </div>
    </section>
<?php include("assets/templates/footer.html"); ?>