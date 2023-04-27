<?php
include_once "header.php";

if($user->checkLoginStatus()){
	if(!$user->checkUserRole(50)){
		$user->redirect("home.php");
	}
}

else{
	$user->redirect("index.php");
}

if(isset($_POST['searchuser_submit'])){
	$userList = $user->searchUsers();
}


?>
<div id="content">
<div class="error-section">
<?php


?>
</div>
<div class="content-inner">
	<?php 
	echo "<h2>Välkommen " . $_SESSION["uname"] . "</h2>"; 
	echo "<h3>Du har användarroll " . $_SESSION["urole"] . " och din id är " .$_SESSION["uid"]."</h3>"; 
	
	?>

	<form method="POST" action="">
		<label for="searchinput">Search for user to edit</label><br>
		  <input type="text" id="search_username" name="search_username" placeholder="Enter username here"><br>
		  <br>
		  <input type="submit" name="searchuser_submit" value="Search">
	</form>

	<div class="userlist">
		<?php 
		if(isset($userList)){
			foreach ($userList as $row){
				echo "<p>{$row['u_username']} <a href='account.php?userToEdit={$row['u_ID']}'>Edit user</a></p>";
			}
		}
			?>
	</div>

</div>




</div>
<?php
include_once "footer.php";
?>