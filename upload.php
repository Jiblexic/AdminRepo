<!DOCTYPE html>
<html>

<?php

include_once('includes/htmlhead.php');

?>

<body>

<form action="uploader.php" method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <input type="submit" value="upload">

</form>

</body>
</html>