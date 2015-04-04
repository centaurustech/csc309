<script type="text/javascript" src="http://ajax.googleapis.com/
ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function()
    {
        $(".like").click(function()
        {
            var id=$(this).attr("id");
            var name=$(this).attr("name");
            var dataString = 'id='+ id;
            var parent = $(this);

            if (name=='up'){
                $(this).fadeIn(100).html('<img src="/assets/images/loading.gif" height="42" width="42"/>');
                $.ajax
                ({
                    type: "POST",
                    url: "upvote.php",
                    data: dataString,
                    cache: false,
                    success: function(html)
                    {
                        parent.html(html);
                    } 
                });
            } else {
                $(this).fadeIn(10).html('<img src="/assets/images/loading.gif" height="42" width="42"/>');
                $.ajax
                ({
                    type: "POST",
                    url: "downvote.php",
                    data: dataString,
                    cache: false,
                    success: function(html)
                    {
                        parent.html(html);
                    } 
                });
            }
        });

        // Close button action
        $(".close").click(function()
        {
            $("#votebox").slideUp("slow");
        });
    });
</script>
<?php 
    include("assets/templates/header.php"); 
    include("sql.php"); 
?>
<div class="container ">
    <div class="row" style="margin-top:100px">
        <div class="col-md-2">
            <h3><font color="#E74C3C">Categories</h3>
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
            <h3>Projects</h3>
            <div class="row">
                <?php          

                    //Check if filter is set
                    if (isset($_GET['category'])) {
                        $category = $_GET['category'];
                        $SQL = "SELECT * FROM projects WHERE category = '$category'";
                    } else {
                        $SQL = "SELECT * FROM projects";
                    }

                    if (isset($_GET['community'])) {
                        $com = $_GET['community'];
                        $SQL = "SELECT * FROM projects WHERE community='$com'";
                    }

                    if (isset($_GET['search'])) {
                        $search = $_GET['search'];
                        $SQL = "SELECT * FROM projects WHERE title = '$search' OR category = '$search'";
                    }
                    //add this to add filters
                    
                    $result = mysql_query($SQL);

                    //retrieve data from sql server
                    while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
                        $title = $row['title'];
                        $id = $row['pID'];
                        $desc = $row['description'];
                        $creator = $row['creator'];
                        $category = $row['category'];
                        $goal = $row['goal'];
                        $date = $row['date'];
                        $funded = $row['funded'];
                        $percentage = ceil(($funded / $goal) * 100);
                        $liked = $row['likes'];
                        $disliked = $row['dislikes'];

                        //get the name of the owner of project
                        $SQL2 = "SELECT * FROM users WHERE email = '$creator'";
                        $result2 = mysql_query($SQL2);
                        $row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
                        $name = $row2['name'];
                        $creatorid = $row2['userid'];

                        //render project box
                        ?> 
                        <div class="col-sm-6 col-lg-6">
                            <div class="thumbnail">
                                <div class="caption">

                                    <!-- Project Descriptions and stuff -->
                                    <?php

                                    //add a checkmark if project is fully funded
                                    if ($percentage >= 100){ ?>
                                        <h4><a href="projectinfo2.php?id=<?=$id?>"><?=$title?></a>
                                        <span class="glyphicon glyphicon-ok"></span></h4>   
                                    <?php } else { ?>
                                        <h4><a href="projectinfo2.php?id=<?=$id?>"><?=$title?></a></h4>
                                    <?php } ?>         
                                    <p>Created by <a href="profile.php?id=<?=$creatorid?>"><?=$name?></a></p>

                                    <p><?=$category?> </p>                     
                                    <p class="smallaf"><?=$desc?></p>

                                    <p class="text-center"><span class="glyphicon glyphicon-usd"></span>
                                    <?=number_format($funded)?> funded of $<?=number_format($goal)?> goal!
                                    </p>
                                        

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
                                            <?=$percentage?>%
                                            </div>
                                        <?php } else { ?>
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow=<?=$percentage?>
                                            aria-valuemin="0" aria-valuemax="100" style='width:<?=$percentage?>%'>
                                            <?=$percentage?>%
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-6">
                                            <p>
                                                <div class='up text-center'>
                                                <a href="" class="like" name="up" id="<?php echo $id; ?>"><span class="glyphicon glyphicon-thumbs-up"></span> <?php echo $liked; ?> liked!</a>
                                                </div>
                                            </p>
                                        </div>
                                        <div class="col-sm-6 col-lg-6">
                                            <p>
                                                <div class='down text-center'>
                                                <a href="" class="like" name="down" id="<?php echo $id; ?>"><span class="glyphicon glyphicon-thumbs-down"></span> <?php echo $disliked; ?> disliked!</a>
                                                </div>
                                            </p>
                                        </div>
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
 
<?php include("assets/templates/footer.html"); ?>