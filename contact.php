<?php 
include("assets/templates/header.php"); 
?>
		<div class="container">
				<div id="contact">
					<h2 class="title  text-center">Contact Us</h2>
					<p class="intro  text-center"> Feel free to contact us if you have any questions or suggestions.</p>
					<form action="contact_process.php" method="post" class="intro text-center">
						<input type="text" name="sender_name" class="inputs" placeholder="Name" required>
						<br>
						<input type="text" name="sender_email" class="inputs" placeholder="Email" required>
						<br>
						<textarea name="sender_message" class="inputs" placeholder="Comments" required></textarea>
						<br>
						<input type="text" name="spam_honeypot" class="spam_honeypot" placeholder="LEAVE BLANK" style="display: none">
						<input type="submit" value="Send!" class="btn btn-cta-primary">
					</form>
				</div>
			</div>
<?php 
include("assets/templates/footer.html");
?>