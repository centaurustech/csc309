<?php
  //check for admin status
  session_start();
  if ($_SESSION['admin'] != "1"){
      header ("Location: index.php");
  }

  //db connect
  include("sql.php");

  // admin status changes
  if (isset($_POST['adminstatus'])) {
    $user = $_POST['user'];
    $status = $_POST['adminstatus'];
    $SQL2 = "UPDATE users SET admin='$status' WHERE email = '$user'";
    mysql_query($SQL2);
  }
  
  //number of projects
  $result=mysql_query("SELECT count(*) as total from projects");
  $data=mysql_fetch_assoc($result);
  $num_of_projects = $data['total'];

  //number of users
  $result=mysql_query("SELECT count(*) as total from users");
  $data=mysql_fetch_assoc($result);
  $num_of_users = $data['total'];
  
  //fully funded projects
  $result=mysql_query("SELECT count(*) as total from projects where funded >= goal");
  $data=mysql_fetch_assoc($result);
  $num_of_funded = $data['total']; 
  $percentage_of_funded = round(($num_of_funded / $num_of_projects) * 100);

  //partially funded
  $result2=mysql_query("SELECT count(*) as total from projects where funded > 0 and funded < goal");
  $data2=mysql_fetch_assoc($result2);
  $num_of_partially_funded = $data2['total']; 
  $percentage_of_partially_funded = round(($num_of_partially_funded / $num_of_projects) * 100);

  //not funded
  $result3=mysql_query("SELECT count(*) as total from projects where funded = 0");
  $data3=mysql_fetch_assoc($result3);
  $num_of_nonfunded = $data3['total']; 
  $percentage_of_nonfunded = round(($num_of_nonfunded / $num_of_projects) * 100);
  
?>
<?php include("assets/templates/header.php"); ?>
<!-- Main -->
<div class="container">
  
  <!-- upper section -->
  <div class="row" style="margin-top:80px">
    <div class="col-sm-12">
      <!-- column 2 -->	
       <h3><i class="glyphicon glyphicon-dashboard"></i> Statistics</h3>   
       <hr>
      
	   <div class="row">
            <!-- center left-->	
         	<div class="col-md-7">
  			    <div class="well">
              <p>Total Number of Projects: <span class="badge pull-right"><?=$num_of_projects?></span></p>
              <p>Total Number of Users: <span class="badge pull-right"><?=$num_of_users?></span></p>
            </div>
              
              <hr>
              
              <div class="panel panel-default">
                  <div class="panel-heading"><h4>Funding Stats</h4></div>
                  <div class="panel-body">
                    
                    <small>Funded</small>
                    <div class="progress">
                      <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow=<?=$percentage_of_funded?>
                        aria-valuemin="0" aria-valuemax="100" style='width:<?=$percentage_of_funded?>%'>
                        <?=$percentage_of_funded?>%
                      </div>
                    </div>

                    <small>Partially Funded</small>
                    <div class="progress">
                      <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow=<?=$percentage_of_partially_funded?>
                        aria-valuemin="0" aria-valuemax="100" style='width:<?=$percentage_of_partially_funded?>%'>
                        <?=$percentage_of_partially_funded?>%
                      </div>
                    </div>
                    <small>Not Funded</small>
                    <div class="progress">
                      <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow=<?=$percentage_of_nonfunded?>
                        aria-valuemin="0" aria-valuemax="100" style='width:<?=$percentage_of_nonfunded?>%'>
                        <?=$percentage_of_nonfunded?>%
                      </div>
                    </div>

                  </div><!--/panel-body-->
              </div><!--/panel--> 
              <hr>
              <img src="makegraph.php">                    
              
          	</div><!--/col-->
         
            <!--center-right-->
        	<div class="col-md-5">
            <p> Admin Rights </p>
            <form action="admin.php" method="post" role="form">  
              <div class="form-group">
                  <label for="InputCategory">User email</label>
                  <div class="input-group">
                      <select name="user" class="form-control" required>
                          <?php
                            $result3 = mysql_query("SELECT * FROM users");
                            while($row3 = mysql_fetch_array($result3, MYSQL_ASSOC)){
                            $email = $row3['email'];
                            echo '<option>' . $email . '</option>';
                          }
                          ?>
                      </select>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                  </div>
              </div>
              
              <div class="form-group">
                  <label for="InputCategory">Admin Status</label>
                  <div class="input-group">
                      <select name="adminstatus" class="form-control" required>
                          <option value="1">Admin</option>
                          <option value="0">Non-Admin</option>
                      </select>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                  </div>
              </div>
              <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-right">
            </form>   
			     </div><!--/col-span-6-->
       </div><!--/row-->
  	</div><!--/col-span-9-->
  </div><!--/row-->
  <!-- /upper section -->  
<?php include("assets/templates/footer.html"); ?>