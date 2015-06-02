 <?php
	
 ?>
 
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	Survey Name: <input type="text" name="Name" value="">
	<center>Survey Description: <textarea name="Description" value="" rows="5" cols="40"></textarea></center>
	<input type="submit" name="submit" value="Add Questions">
	<br><br><input type="submit" name="cancel" value="Cancel">
</form>