 <?php
 
 ?>
 
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	Survey Name: <input type="text" name="Name" value="">
	Survey Description: <input type="text" name="Description" value="" style="height:100px">
	<input type="button" name="cancel" value="Cancel"> <input type="submit" name="submit" value="Add Questions">
</form>