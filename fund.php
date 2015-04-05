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
    $creator = $row['creator'];
    $goal = $row['goal'];
    $date = $row['date'];
    $funded = $row['funded'];
    $percentage = round(($funded / $goal) * 100);
?>
<br>
<br>
<br>
<br>
<input type="text" style="display:none">
<input type="password" style="display:none">

<!-- Credit card form -->
<div class="container" style="margin-top:40px">
    <div class="row">
    <div class="col-sm-6 col-md-4 col-md-offset-4">
			<?php
				if(isset($_GET['input_status'])) {
					echo "<h3>Please ensure you have provided a positive donation value!</h3>";
				}
			?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><img class="pull-right" src="http://i76.imgup.net/accepted_c22e0.png">Payment Details</h3>
                </div>
                <div class="panel-body">
                    <form action="fund_success.php?id=<?=$id?>" method="post" role="form" id="payment-form">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="cardNumber">CARD NUMBER</label>
                                    <div class="input-group">
                                        <input required type="text" class="form-control" name="cardNumber" placeholder="Valid Card Number"  autofocus data-stripe="number" autocomplete="off"/>
                                        <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-7 col-md-7">
                                <div class="form-group">
                                    <label for="expMonth">EXPIRATION DATE</label>
                                    <div class="col-xs-6 col-lg-6 pl-ziro">
                                        <input required type="number" class="form-control" name="expMonth" placeholder="MM"  data-stripe="exp_month" autocomplete="off" />
                                    </div>
                                    <div class="col-xs-6 col-lg-6 pl-ziro">
                                        <input required type="number" class="form-control" name="expYear" placeholder="YY"  data-stripe="exp_year" autocomplete="off"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-5 col-md-5 pull-right">
                                <div class="form-group">
                                    <label for="cvCode">CV CODE</label>
                                    <input required type="password" class="form-control" name="cvCode" placeholder="CV"  data-stripe="cvc" autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="FundingAmount">Funding Amount</label>
                                    <input type="number" class="form-control" required name="amount" autocomplete="off" />
                                </div>
                            </div>                        
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-success btn-lg btn-block" type="submit">Fund</button>
                            </div>
                        </div>
                        <div class="row" style="display:none;">
                            <div class="col-xs-12">
                                <p class="payment-errors"></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("assets/templates/footer.html"); ?>