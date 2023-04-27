<?php
	include_once "header.php";
	
	//check if form has been sent
	if(isset($_POST['submit_register'])){
		//Function returns success or error message that is saved in $checkReturn.
		$checkReturn = $user->checkUserRegisterInput();
		
		//If all checks are passed, run register-fuction
		if($checkReturn == "success"){
			$registerResult = $user->register();
			echo "<p class='bg-info text-white text-center'>{$registerResult} <a href='index.php'>Log in</a></p></p>";
		}
		//If something does not meet requirements, echo out what went wrong.
		else {
			echo "<p class='text-white bg-danger text-center'>{$checkReturn}";
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
				  <h2> Register </h2>
				</div>

				<!-- Login Form -->
				<form method="POST" action="">
				  <input type="text" id="username" class="fadeIn second" name="username" placeholder="Enter desired user name">
				  <input type="password" id="password" class="fadeIn third" name="password" placeholder="Enter password - minimum 8 characters long">
				  <input type="password" id="password-repeat" class="fadeIn third" name="password_confirm" placeholder="Confirm password">
				  <input type="text" id="firstname" class="fadeIn second" name="firstname" placeholder="First name">
				  <input type="text" id="lastname" class="fadeIn second" name="lastname" placeholder="Last name">
				  <input type="text" id="email-field" class="fadeIn second" name="email-field" placeholder="Email address">
				  <input type="submit" class="fadeIn fourth" name="submit_register" value="Register">
				</form>

			
				<div id="formFooter">
				  <span>Already a user? </span><a class="underlineHover" href="index.php">Login here!</a>
				</div>

			</div>
		</div>
	</div>
</div>

<?php
include_once "footer.php";
?> 