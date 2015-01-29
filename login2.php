<?php

if (empty($_POST['email']) or empty($_POST['pass'])){
    header('Location: login.php');
}
?>
<?php include("assets/templates/header.html"); ?>
    <section id="register" class="about section">
        <div class="container" class="intro text-center">
            <br>
            <br>
            <h2 class="title text-center">Successfully logged in <?php echo $_POST['email']; ?></h2>          
        </div>
    </section>
<?php include("assets/templates/footer.html"); ?>