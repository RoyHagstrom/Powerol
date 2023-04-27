<?php
	include_once "header.php";
	
	if(isset($_POST['submit_login'])){
		$loginReturn = $user->login();
		
		if($loginReturn == "success"){
			$user->redirect("home.php");
		}
	}
?>



<div id="content">
	<div class="content-inner">
		<div class="wrapper fadeInDown">
			<div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
				<div class="fadeIn first">
				  <i class="fas fa-house-user login-icon"></i>
				  <h2>Log in</h2>
				</div>

				<!-- Login Form -->
				<form method="POST">
				  <input type="text" id="username" class="fadeIn second" name="username" placeholder="User name or e-mail">
				  <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password">
				  <input type="submit" name="submit_login" class="fadeIn fourth" value="Log In">
				</form>

				<!-- Remind Passowrd -->
				<div id="formFooter">
				  <span>Not a user? </span><a class="underlineHover" href="register.php">Register here!</a>
				</div>

			</div>
		</div>
	</div>
</div>
<?php
include_once "footer.php";
?>