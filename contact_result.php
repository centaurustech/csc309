<!doctype html>
<html>
	<head>
		<link id="theme-style" rel="stylesheet" href="assets/css/styles.css">
	</head>
	<body>
		<div id="contact_result">
			<h1><?=$_GET['message']?></h1>
			<?php
				if ($_GET['success'] == 0){
					echo '<a href="contact.php">Back</a>';
				}
				
				else {
					echo '<a href="index.php">Home</a>';
				}
			?>
		</div>
	</body>
</html>
