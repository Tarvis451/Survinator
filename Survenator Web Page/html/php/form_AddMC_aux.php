<?php
/**
 * Created by PhpStorm.
 * User: sammy_000
 * Date: 6/13/2015
 * Time: 9:39 PM
 */
 
 
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    
    <br><input type="submit" name="submit" value="Finish">
    <input type="hidden" name="surveyid" value="<?php echo $surveyid; ?>">
    <br><input type="submit" name="cancel" value="Cancel">

</form>

