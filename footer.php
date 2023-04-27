<div id="footer"><p>Footer</p>	
	 <?php 
	if($user->checkLoginStatus()){
 ?>
    <form method="POST" action="">
		<input type="submit" name="logout-button" value="log out" class="btn btn-success me-2">
	</form>

<?php } ?>	
</div>

</body>
</html> 