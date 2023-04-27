<?php
include_once "header.php";

if(!$user->checkLoginStatus()){
	$user->redirect("index.php");
}

if(isset($_GET['userToEdit'])){
	$userToEdit = $_GET['userToEdit'];
}
else {
	$errorMessage = "No user has been chosen";
}
if(isset($_POST['confirm_user_delete'])){
	$deleteUserReturn = $user->deleteUser($userToEdit);
	
	if($deleteUserReturn == "success"){
		$feedback = "´The account has been successfully deleted. ";
	}
	else {
		$errorMessage = $deleteUserReturn;
	}
}
?>
<div id="content">
<div class="error-section">
<?php

if(isset($errorMessage)){
			echo $errorMessage;
			}

?>
</div>
<div class="content-inner">
	<?php 
		if(isset($feedback)){
			echo $feedback;
			}
	
		if(isset($_POST['submit_user_delete']) && isset($userToEdit)){
			?>
			<h2>Are you sure you want to delete this account and all of its content?</h2>
			<form method="POST" action="">
			  <input type="submit" name="confirm_user_delete" value="Delete this account">
			</form>
			
			<?php
		}
		
		else{
			echo "Nothing more to delete, back to <a href='home.php'>Home</a>";
		}
		
		
			
			
		
	
	?>

</div>
</div>
<?php
include_once "footer.php";
?>