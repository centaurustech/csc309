<?php include("assets/templates/header.php"); ?>
	<section class="about section">
		<div class="container">
                        <h1>"project title"</h1> <!--as filled out on previous page-->
                        <h2>By: "name"</h2><br> <!--user's name as registered-->
                        <h4>Community: <!--communities the user belongs to-->
                            <select>
                                <option value="To">Toronto</option>
                                <option value="309">CSC309</option>
                                <option value="stud">Students</option>
                                <option value="hack">Hackers</option>
                            </select></h4><br>
                        <h4>Description:</h4>
                                <textarea rows="10" cols="70"></textarea><br><br>
                        <h4>Image: 
                            <form><input type="file" name="uploadField" />
                            </form></h4><br>
                        <h4>Website:</h4>
                            <form>
                                <input type="text" name="website" size="70">
                            </form><br>
                        <h4>Video URL:</h4>
                            <form>
                                <input type="text" name="website" size="70">
                            </form><br>
                        <h4><form>Goal: $ <input type="text" name="website" size="10"></form></h4><br>
                        <h3>Tier 1</h3>
                        <h4><form>Donation: $ <input type="text" name="teir1" size="10"></form></h4>
                        <h4>Reward:</h4>
                        <textarea rows="6" cols="50"></textarea><br><br>  
                        <h3>Tier 2</h3>
                        <h4><form>Donation: $ <input type="text" name="teir2" size="10"></form></h4>
                        <h4>Reward:</h4>
                        <textarea rows="6" cols="50"></textarea><br><br> 
                        <h3>Tier 3</h3>
                        <h4><form>Donation: $ <input type="text" name="teir3" size="10"></form></h4>
                        <h4>Reward:</h4>
                        <textarea rows="6" cols="50"></textarea><br><br> 
                        <button type="button">Create Project!</button>
		</div>
	</section>
<?php include("assets/templates/footer.html"); ?>