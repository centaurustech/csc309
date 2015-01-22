<?php
include('templates/header.html');
?>

<div class="jumbotron">
    <div class="container">
        <h1>Logged in, <?=$_POST['check']?></h1>
        <p>Thank you for logg   ing in.</p>
        <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p>
    </div>
</div>

<?php
    include('templates/footer.html');
?>
