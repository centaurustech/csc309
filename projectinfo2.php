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
        
    $('#addCommentForm').submit(function(e){
        var page = "submit_comment.php?pid=";
        var pid = <?php echo $_GET['id']; ?>;
        var stringpid = pid.toString();
        var des = page.concat(stringpid);
        $.post(des,$(this).serialize(),function(msg){});
    });

        // Close button action
        $(".close").click(function()
        {
            $("#votebox").slideUp("slow");
        });   
    } 
    );
    
</script>
<?php include("assets/templates/header.php"); ?>

<?php          
    /*connect to database */
    include("sql.php");

    $id = $_GET['id'];
    $SQL = "SELECT * FROM projects WHERE pID = $id";
    $result = mysql_query($SQL);
    $row = mysql_fetch_array($result, MYSQL_ASSOC);

    //get project info
    $title = $row['title'];
    $desc = $row['description'];
    $creatoremail = $row['creator'];
    $goal = $row['goal'];
    $date = date("F j, Y", strtotime($row['date']));
    $funded = $row['funded'];
    $percentage = ceil(($funded / $goal) * 100);
    $liked = $row['likes'];
    $disliked = $row['dislikes'];
    $youtube = $row['youtube'];
	
	//get creator info
	$SQL = "SELECT * FROM users WHERE email = '$creatoremail'";
	$result = mysql_query($SQL);
    $row = mysql_fetch_array($result, MYSQL_ASSOC);
	$creator = $row['name'];
    $creatorid= $row['userid'];
    
    
    
?>

<!-- Page Content -->
    <div class="container">
        <div class="row" style="margin-top:100px">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8">

                <!-- Blog Post -->

                <!-- Title -->
                <h1><?=$title?></h1>

                <!-- Author -->
                <p class="lead">
                    by <a href="profile.php?id=<?=$creatorid?>"><?=$creator?></a>
                </p>
                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Created on <?=$date?></p>
                <hr>
                
                <?php 
                if ($youtube!=null) {
                    $youtubelead = "https://www.youtube.com/embed/";
                    $uurl = "hi" . $youtube;
                ?>
                <div class="well" style="text-align:center">
                <iframe width="700" height="577" src="https://www.youtube.com/embed/<?=$youtube?>"  frameborder="0" allowfullscreen></iframe>
                </div>
                <?php
                }
                ?>

                <!-- Post Content -->
                <h4> Project Description </h4>
                <p class="lead"><?=$desc?></p>
                <hr>
                
                
                <!-- Comments Form -->
                <div class="well">
                    <?php
                    if (isset($_SESSION['login']) AND $_SESSION['login'] == "1"){ ?>		
                        <h4>Leave a Comment:</h4>
                        <form id="addCommentForm" method="post" action="">
                            <div class="form-group">
                                <textarea class="form-control" name="body" id="body" rows="3"></textarea>
                            </div>
                            <input type="submit" class="btn btn-primary"  id="submit" value="Submit" />
                        </form>
                    <?php
                    } 
                    else {        
                    echo '<p>You must be logged on to comment</p>';                
                    }
                    ?>                
                </div>
                <hr>

                <!-- Posted Comments -->
                <?php
                
                    $SQL = "SELECT * FROM comments WHERE pID = $id ORDER BY date DESC";
                    $result = mysql_query($SQL);
                    $num_rows = mysql_num_rows($result);
                        if ($num_rows > 0 == false) {
                            echo "No comments yet. Be the first to give feedback!";
                        }
                    while(($row = mysql_fetch_assoc($result))) { 
                        $userid = $row['userid'];
                        $profile_pic_location = "user_" . $userid . "_pic.jpg";
                        $date = date("F j, Y H:i:s", strtotime($row['date']));
                        $comment = $row['comment'];                   
                        //get commenter's name
                        $SQL = "SELECT * FROM users WHERE userid = $userid";
                        $resultT = mysql_query($SQL);
                        $row = mysql_fetch_array($resultT, MYSQL_ASSOC);
                        $name = $row['name'];
                        $profile =  "profile.php?id=" . $userid;
                        ?>
                        <!-- Comment -->
                        <div class="well">
                            <a class="pull-right" href="<?=$profile?>">
                                <img class="img-rounded" src="assets/images/profile_pics/<?=$profile_pic_location?>" alt="" width=64 height=64 >
                            </a>
                            <div class="media-body">
                            
                                <h4 class="media-heading"><a href="<?=$profile?>" > <?=$name?></a>
                                <small><?=$date?></small>
                            </h4>
                            <?php echo $comment ?> <br><br>
                            </div>
                         </div>    
                    <?php }
                ?>
            </div>

            <br>
            <div class="col-md-4">

                <!-- Funding Info Well -->
                <div class="well">
                    <!-- Edit and Delete idea buttons -->
                    <?php 
                    if (isset($_SESSION['login']) AND $_SESSION['login'] == "1"){
                        $currentemail = $_SESSION['email'];
                        $currentemail = strtolower($currentemail);
                        $creatoremail = strtolower($creatoremail);
                        if ((strcmp($currentemail, $creatoremail) == 0) or ($_SESSION['admin'] == 1)){
                            ?>
                            <!-- Side Widget Well -->
                                <div class="text-center">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <a class="btn btn-success" href="editproject.php?id=<?=$id?>">Edit Project!</a>
                                        </div>
                                        <div class="col-sm-6">
                                            <a class="btn btn-danger" onclick="return confirm('Are you sure?')" href="deleteproject.php?id=<?=$id?>">Delete Project!</a>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                    <?php
                        }
                    }
                    ?>
                   
                    <h4 class="text-center">Funding</h4>
                    <!-- Project Descriptions and stuff -->

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

                    <hr>
                    <!-- Fund Button -->
                    <p>You can support this project by funding it. To fund, press the button below!</p>
                    <h2 class="text-center"><a class="btn btn-cta-secondary" href="fund.php?id=<?=$id?>">Fund this project!</a></h2>

                </div>
            </div>
        </div>
    </div>
<?php 
include("assets/templates/footer.html"); ?>