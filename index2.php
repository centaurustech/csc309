<?php include("assets/templates/header.php"); ?>
    <!-- ******PROMO****** -->
    <section id="promo" class="promo section offset-header">
        <div class="container text-left">
            <h2 class="title">StartUp<span class="highlight">Up</span></h2>
            <p class="intro">Create or browse ideas </p>
            <div class="btns">
				<?php
					if (isset($_SESSION['login']) AND $_SESSION['login'] == "1"){
						$create_permission = "create.php";
					}
					else {
						$create_permission = "login_new.php";
					}
				?>
                <a class="btn btn-cta-secondary" href=<?=$create_permission?>>Create</a>
                <a class="btn btn-cta-primary" href="browse.php">Browse</a>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
        </div><!--//container-->
    </section><!--//promo-->
    
  