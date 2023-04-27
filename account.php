<?php
include_once "header.php";

if(!$user->checkLoginStatus()){
	$user->redirect("index.php");
}

if($user->checkUserRole(50) && isset($_GET['userToEdit'])){
		$userToEdit = $_GET['userToEdit'];
	}
	
else {
	$userToEdit = $_SESSION['uid'];
}

if(isset($_POST['submit_edit'])){
	
	$checkReturn = $user->checkUserRegisterInput();
		
		//If all checks are passed, run register-fuction
		if($checkReturn == "success"){
			if($user->editUserInfo($userToEdit)){
			$feedback = "user info updated successfully";
			}
		}
		//If something does not meet requirements, echo out what went wrong.
		else {
			$feedback =$checkReturn;
		}	
}

if(isset($_POST['submit_role_status'])){
	if($_POST['update_status'] != 0){
	$statusUpdateReturn = $user->updateUserStatus($userToEdit);
		if($statusUpdateReturn == "success"){
			$feedback = "User status updated successfully!";
		}
		else {
			$feedback = $statusUpdateReturn;
		}	
	}
	else {
		$feedback = "No changes where made to user status.";
	}
	if($_POST['update_role'] != 0){
	$statusUpdateReturn = $user->updateUserRole($userToEdit);
		if($statusUpdateReturn == "success"){
			$feedback .= " User role updated successfully!";
		}
		else {
			$feedback = $statusUpdateReturn;
		}	
	}
	else {
		$feedback .= " No changes where made to user role";
	}
	
}


$userInfo = $user->getUserInfo($userToEdit);
$roleInfo = $pdo->query("SELECT * FROM table_roles");
$statusInfo = $pdo->query("SELECT * FROM table_status");


?>
<div id="content">
<div class="feedback-section">
<?php
if(isset($feedback)){
	echo $feedback;
}


?>
</div>
<div class="content-inner">
	<?php 
	echo "<h2>Välkommen " . $_SESSION["uname"] . "</h2>"; 
	
	?>
	<h2> Change account info </h2>
	<form method="POST" action="">
	<label for="username">Username</label><br>
	  <input type="text" id="username" name="username" value="<?php echo $userInfo['u_username']; ?>" disabled><br>
	  <label for="username">Password</label><br>
	  <input type="password" id="password"name="password" ><br>
	  <label for="username">Password (repeat)</label><br>
	  <input type="password" id="password-repeat" name="password_confirm" ><br>
	  <label for="username">First name</label><br>
	  <input type="text" id="firstname" name="firstname" value="<?php echo $userInfo['u_firstname']; ?>"><br>
	  <label for="username">Last name</label><br>
	  <input type="text" id="lastname" name="lastname" value="<?php echo $userInfo['u_lastname']; ?>"><br>
	  <label for="username">Email</label><br>
	  <input type="text" id="email-field" name="email-field" value="<?php echo $userInfo['u_email']; ?>">
	  <br>
	  <input type="submit" name="submit_edit" value="Submit new info">
	</form>
	
	<?php 
		if($user->checkUserRole(50)){
	?>
	
	<form method="POST" action="">
		<select name="update_status">
			<option value='0'>Change user status</option>
			<?php 
			foreach ($statusInfo as $row){
			echo "<option value='{$row['s_id']}'>{$row['s_name']}</option>" ;
			}
			?>
		</select>
		<select name="update_role">
		<option value='0'>Change user role</option>
			<?php foreach ($roleInfo as $row){
			echo "<option value='{$row['r_ID']}'>{$row['r_name']}</option>" ;
			} ?>
		</select>
	  <input type="submit" name="submit_role_status" value="Update">
	</form>
	
	<form method="POST" action="confirm_delete.php?userToEdit=<?php echo $userToEdit; ?>">
	  <input type="submit" name="submit_user_delete" value="Delete this account">
	</form>
	
<?php } ?>
</div>
</div>
<?php
include_once "footer.php";
?>