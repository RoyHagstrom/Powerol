<?php
include_once "header.php";

if(!$user->checkLoginStatus()){
	$user->redirect("index.php");
}


?>
<div id="content">
<div class="error-section">
<?php


?>
</div>
<div class="row">
	<?php 
	echo "<h2>Välkommen " . $_SESSION["uname"] . "</h2>"; 
	echo "<h3>Du har användarroll " . $_SESSION["urole"] . " och din id är " .$_SESSION["uid"]."</h3>"; 
	
	?>

</div>
</div>
<?php
include_once "footer.php";
?>