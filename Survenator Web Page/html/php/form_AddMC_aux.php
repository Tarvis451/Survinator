<?php
/**
 * Created by PhpStorm.
 * User: sammy_000
 * Date: 6/13/2015
 * Time: 9:39 PM
 */
?>

<form action="<?php echo $_SERVER['form_AddMC.php']; ?>" method="post">

    <input type="submit" name="addresponse" value="Add Response">
    <input type="submit" name="submit" value="Finish">
    <input type="hidden" name="surveyid" value="<?php echo $surveyid; ?>">
    <br><br><input type="submit" name="cancel" value="Cancel">

</form>

