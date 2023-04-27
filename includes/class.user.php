<?php
class user {
	
	public $errorMessage;
	
	public function __construct($pdo){
		$this->conn = $pdo;
	}
	
	private function cleanInput($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	
	public function checkUserRegisterInput(){
		$error = 0;
		
		$cleanemail = $this->cleanInput($_POST['email-field']);
		
		if(isset($_POST['submit_register'])){
			$cleanname = $this->cleanInput($_POST['username']);
			//Bygg query som hämtar ut en rad ur databasen ifall användarnamnet finns
			$stmt_checkIfUserExists = $this->conn->prepare("SELECT * FROM table_user WHERE u_username = :uname OR u_email = :email");
			$stmt_checkIfUserExists->bindValue(":uname", $cleanname, PDO::PARAM_STR);
			$stmt_checkIfUserExists->bindValue(":email", $cleanemail, PDO::PARAM_STR);
			$stmt_checkIfUserExists->execute();
			//Skapa array av infon som hämtats
			$userNameMatch = $stmt_checkIfUserExists->fetch();
			//Kolla om arrayen innehåller värden. Om SELECT-queryn har hämtat ut något finns användarnamnet redan skapat
			
			if(!empty($userNameMatch)){
				if($userNameMatch['u_username'] == $cleanname){
					$this->errorMessage .= " | Username is already taken";
					$error=1;
					
				}
				
				if($userNameMatch['u_email'] == $cleanemail){
					$this->errorMessage .= " | Email is already taken";
					$error=1;
				
				}
			}
		}
			if(isset($_POST['submit_edit']) && $_POST['password'] == ""){
				
			}
			
			else {
				if($_POST['password'] != $_POST['password_confirm']){
						$this->errorMessage .= " | Passwords do not match";
						$error=1;
						
				}
				
				if(strlen($_POST['password']) < 8){
						$this->errorMessage .= " | Password does not meet requirements";
						$error=1;
				}
			}
			
			if (!filter_var($_POST['email-field'], FILTER_VALIDATE_EMAIL)) {
					$this->errorMessage .= "Invalid email format";
					$error=1;
			}
			
			if($error !=0){
				return $this->errorMessage;
			}
			else {
				return "success";
			}
		}
		
		public function register(){
			$cleanName = $this->cleanInput($_POST['username']);
			$cleanEmail = $this->cleanInput($_POST['email-field']);
			$cleanFname = $this->cleanInput($_POST['firstname']);
			$cleanLname = $this->cleanInput($_POST['lastname']);
			//Encrypt password with the password_hash-function
			$encryptedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
			
			$stmt_registerUser = $this->conn->prepare("INSERT INTO table_user 
			(u_username, u_firstname, u_lastname, u_email, u_password, u_role, u_status) 
			VALUES (:uname, :ufirst, :ulast, :umail, :upass, 1, 1)");
			$stmt_registerUser->bindValue(":uname", $cleanName, PDO::PARAM_STR);
			$stmt_registerUser->bindValue(":ufirst", $cleanFname, PDO::PARAM_STR);
			$stmt_registerUser->bindValue(":ulast", $cleanLname, PDO::PARAM_STR);
			$stmt_registerUser->bindValue(":umail", $cleanEmail, PDO::PARAM_STR);
			$stmt_registerUser->bindValue(":upass", $encryptedPassword, PDO::PARAM_STR);
			$check = $stmt_registerUser->execute();
			
			if($check){
				return "User created successfully!";
			}
			else{
				return "Something went wrong, try again later!";
			}	
		}
		
		public function login(){
			$usernameEmail = $this->cleanInput($_POST['username']);
			//Bygg query som hämtar ut en rad ur databasen ifall användarnamnet finns
			$stmt_checkIfUserExists = $this->conn->prepare("SELECT * FROM table_user WHERE u_username = :uname OR u_email = :email");
			$stmt_checkIfUserExists->bindValue(":uname", $usernameEmail, PDO::PARAM_STR);
			$stmt_checkIfUserExists->bindValue(":email", $usernameEmail, PDO::PARAM_STR);
			$stmt_checkIfUserExists->execute();
			//Skapa array av infon som hämtats
			$userNameMatch = $stmt_checkIfUserExists->fetch();
			
			if(!$userNameMatch){
				$this->errorMessage = "No such user or email in database.";
				return $this->errorMessage;
			}
			
			   $checkPasswordMatch = password_verify($_POST['password'], $userNameMatch['u_password']);
   
			   if($checkPasswordMatch == true) {
				  $_SESSION['uname'] = $userNameMatch['u_username'];
				  $_SESSION['urole'] = $userNameMatch['u_role'];
				  $_SESSION['uid'] = $userNameMatch['u_ID'];
				  return "success";
			   } 
			   else {
				  $this->errorMessage = "INVALID password";     
				  return $this->errorMessage;
			   }
			
		}
		
		public function checkLoginStatus(){
			if(isset($_SESSION['uid'])){
				return true;
			}
			else {
				return false;
			}
		}
		
		public function checkUserRole($req){
			$stmt_checkRoleLevel = $this->conn->prepare("SELECT * FROM table_roles WHERE r_ID = :urole");
			$stmt_checkRoleLevel->bindValue(":urole", $_SESSION['urole'], PDO::PARAM_STR);
			$stmt_checkRoleLevel->execute();
			$currentUserRoleInfo = $stmt_checkRoleLevel->fetch();
			
			if($currentUserRoleInfo["r_level"] >= $req){
				return true;
			}
			else {
				return false;
			}
			
		}
		
		public function redirect($url){
			header("Location: ".$url);
			exit();
		}
		
		public function logout(){
			session_unset();
			session_destroy();
			return true;
		}
		
		public function editUserInfo($uid){
		//	$cleanName = $this->cleanInput($_POST['username']);
			$cleanEmail = $this->cleanInput($_POST['email-field']);
			$cleanFname = $this->cleanInput($_POST['firstname']);
			$cleanLname = $this->cleanInput($_POST['lastname']);
			
			if(isset($_POST['password']) && $_POST['password'] != ""){
				$encryptedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
				$editUserInfo = $this->conn->prepare("UPDATE table_user SET u_email = :uemail, u_firstname = :ufname, u_lastname = :ulname, u_password = :upass WHERE u_ID = :uid");
				$editUserInfo->bindParam(":uemail", $cleanEmail, PDO::PARAM_STR);
				$editUserInfo->bindParam(":ufname", $cleanFname, PDO::PARAM_STR);
				$editUserInfo->bindParam(":ulname", $cleanLname, PDO::PARAM_STR);
				$editUserInfo->bindParam(":upass", $encryptedPassword, PDO::PARAM_STR);
				$editUserInfo->bindParam(":uid", $uid, PDO::PARAM_INT);
			}
			
			else{
				$editUserInfo = $this->conn->prepare("UPDATE table_user SET u_email = :uemail, u_firstname = :ufname, u_lastname = :ulname WHERE u_ID = :uid");
				$editUserInfo->bindParam(":uemail", $cleanEmail, PDO::PARAM_STR);
				$editUserInfo->bindParam(":ufname", $cleanFname, PDO::PARAM_STR);
				$editUserInfo->bindParam(":ulname", $cleanLname, PDO::PARAM_STR);
				$editUserInfo->bindParam(":uid", $uid, PDO::PARAM_INT);
			}
			
			if($editUserInfo->execute()){
				return true;
			}
		
		
		}
			
		public function getUserInfo($uid){
			$userInfoQuery = $this->conn->prepare("SELECT * FROM table_user WHERE u_ID = :uid");
			$userInfoQuery->bindParam(":uid", $uid, PDO::PARAM_INT);
			$userInfoQuery->execute();
			$userInfo = $userInfoQuery->fetch();
			return $userInfo;
		}
		
		public function searchUsers(){
			$cleanSearchParam = $this->cleanInput($_POST['search_username']);
			$cleanSearchParam = "%".$cleanSearchParam."%";
			$searchUsersQuery = $this->conn->prepare("SELECT * FROM table_user WHERE u_username LIKE :searchParam");
			$searchUsersQuery->bindParam(":searchParam", $cleanSearchParam, PDO::PARAM_STR);
			$searchUsersQuery->execute();
			return $searchUsersQuery;			
		}

		public function updateUserStatus($uid){
				$updateStatusQuery = $this->conn->prepare("UPDATE table_user SET u_status = :status WHERE u_ID = :uid");
				$updateStatusQuery->bindParam(":status", $_POST['update_status'], PDO::PARAM_INT);
				$updateStatusQuery->bindParam(":uid", $uid, PDO::PARAM_INT);
				if($updateStatusQuery->execute()){
					return "success";
				}
				else{
					$this->errorMessage = "Something went wrong, try again later or contact an administrator.";
					return $this->errorMessage;
				}
		}
				
		public function updateUserRole($uid){
				$updateRoleQuery = $this->conn->prepare("UPDATE table_user SET u_role = :role WHERE u_ID = :uid");
				$updateRoleQuery->bindParam(":role", $_POST['update_role'], PDO::PARAM_INT);
				$updateRoleQuery->bindParam(":uid", $uid, PDO::PARAM_INT);
				if($updateRoleQuery->execute()){
					return "success";
				}
				else{
					$this->errorMessage = "Something went wrong, try again later or contact an administrator.";
					return $this->errorMessage;
				}
				
		}
		public function deleteUser($uid){
				$deleteUserQuery = $this->conn->prepare("DELETE FROM table_user WHERE u_ID = :uid");
				$deleteUserQuery->bindParam(":uid", $uid, PDO::PARAM_INT);
				if($deleteUserQuery->execute()){
					return "success";
				}
				else{
					$this->errorMessage = "Something went wrong, try again later or contact an administrator.";
					return $this->errorMessage;
				}
				
		}
	}

		


?>

	