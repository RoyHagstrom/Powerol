<?php
include_once "includes/class.user.php";
include_once "includes/config.php";

//Kolla ifall användaren sökt efter en användare i sökformuläret
if(isset($_POST['chose-user-submit'])){
	$userSearch = $user->searchUsers($_POST['searchuser']);
}
//Kolla ifall userID get-variabeln existerar i adressfältet
if(isset($_GET['userID'])){
	$userInfo = $user->selectUserInfo($_GET['userID']);
	$chosenUserToEdit = $_GET['userID'];
	
}
//om ingen get-variabel finns, sök med den inloggade användarens info
else {
	$userInfo = $user->selectUserInfo($_SESSION['uid']);
	$chosenUserToEdit = $_SESSION['uid'];
}
//Hämta ut all info från roles-tabellen
$stmt_selectRolesInfo = $pdo->query("SELECT * FROM table_roles");

//Kolla ifall användaren har tryckt på uppdatera-knappen
if(isset($_POST['user-update-submit'])){
	
	if($user->checkUserRole($_SESSION['urole'], 50)){
		$urole = $_POST['role'];
	}
	else {
		$urole = $_SESSION['urole'];
	}
		
		if($user->checkUserRegisterInput($_POST['username'], $_POST['password'], $_POST['password_confirm'],$_POST['firstname'],$_POST['lastname'], $_POST['email-field'],1)){
			
			if($user->userUpdate($_POST['username'], $_POST['password'], $_POST['password_confirm'],$_POST['firstname'],$_POST['lastname'], $_POST['email-field'],$urole, $chosenUserToEdit)){
				echo "update successful";
			}
			else {
				echo $user->getErrorMessage();
			}
			
		}
		else {
			echo $user->getErrorMessage();
		}
		
		
	}


include_once "header.php";
?>
<div id="content">
	<h1 class="text-center"> Uppdatera användarinfo</h1>
	<div class="content-inner">
	
	<?php if($user->checkUserRole($_SESSION['urole'], 99)){ ?>
		<form method="post" action="">
		<input id="searchuser" placeholder="Input username" name="searchuser" type="text" value="">
		<input type="submit" name="chose-user-submit" value="Sök användare">
		</form>
	<?php } 
	
	if(isset($userSearch)){
		echo "<table class='table'>";
		foreach($userSearch as $row){	
		echo "<tr>";
		echo "<td>" . $row['u_username'] . "</td>";
		echo "<td><a href='edituser.php?userID=" . $row['u_ID'] . "'>Editera användaren</a></td>";
		echo "</tr>";
	}
	echo "</table>";
	}
	
	?> 
	
		<div class="wrapper fadeInDown">
			<div id="formContent">
				<form method="post" action="">
					<input type="text" name="username" value="<?php echo $userInfo['u_username']; ?>" readonly="readonly">
					<label for="fname">Förnamn:</label><br>
					<input id="fname" name="firstname" type="text" value="<?php echo $userInfo['u_firstname'] ?>"><br>
					<label for="lname">Efternamn:</label><br>
					<input id="lname" name="lastname" type="text" value="<?php echo $userInfo['u_lastname'] ?>"><br>
					<label for="email">E-post:</label><br>
					<input id="email" name="email-field" type="text" value="<?php echo $userInfo['u_email'] ?>"><br>
					<label for="password">Lösenord:</label><br>
					<input id="password" name="password" type="text" value=""><br>
					<label for="password-repeat">Repetera lösenord:</label><br>
					<input id="password-repeat" name="password_confirm" type="text" value=""><br>
					<?php 
						if($user->checkUserRole($_SESSION['urole'], 50)){
							echo '<label for="role">Roll:</label><br>';
							echo '<select name="role" id="role" class="user-role">';
							
							foreach($stmt_selectRolesInfo as $row){
									echo '<option'; 
									if($userInfo["u_role"] == $row['r_ID']){echo ' selected="selected" ';}
									echo ' value="'.$row["r_ID"].'">'.$row['r_name'].'</option>';		
						}
						
						echo '</select><br>';
						}
					?>
					<input type="submit" name="user-update-submit" value="Uppdatera info">
				</form>
			</div>
		</div>
	</div>
</div>
<?php
include_once "footer.php";
?>