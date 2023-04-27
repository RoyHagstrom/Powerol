<?php
	include_once "includes/class.user.php";
	include_once "includes/config.php";
	
	if(isset($_POST['logout-button'])){
		if($user->logout()){
			$user->redirect("index.php");
		}
	}
	?>
<!DOCTYPE html>
<html>
<head>
<title>Min första webbsida :D</title> <!-- Titel som syns uppe i "tabben" -->
<link rel="stylesheet" href="css/style.css"> <!-- Länka in CSS-filen -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<meta charset="UTF-8"> <!-- Välj teckenuppsättning som innehåller ÅÄÖ -->
<meta name="viewport" content="width=device-width, initial-scale=1.0"><!-- välj viewport för responsivitet i olika skärmar -->
<script src="js/script.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>

<div id="header">
  <h1 class="header-text">Powerol</h1>
</div>

<div id="navigation">
<nav class="navbar navbar-light bg-light text-dark">
  <div class="container-fluid justify-content-start">
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
	<div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="home.php">Home</a>
        </li>
		
		<?php 
		if($user->checkUserRole(50)){
			echo "
			<li class='nav-item'>
          <a class='nav-link' href='admin.php'>Admin page</a>
        </li>";
		}
	
	 ?>
        
      </ul>

	</div>
	</div>
</nav>



  
</div>
<div class="clear"></div>