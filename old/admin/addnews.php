<?php
session_start();
if (! $_SESSION['is_logged']) header("Location:index.html");
?>
<html>


<body>


News Body<br />
<form method="post" action="savenew.php">
 <br />
Date (yyyy-mm-dd) <br>
<input name="date" type="text"><br>

Small English text <br>
<textarea rows = "3" name = "smalltexteng" cols = "100"> </textarea>

 <br>
Big English text <br>
<textarea rows = "5" name = "bigtexteng" cols = "100"> </textarea>

 <br>
Small Georgian text <br>
<textarea rows = "3" name = "smalltextgeo" cols = "100"> </textarea>

 <br>
Big Georgian text <br>
<textarea rows = "5" name = "bigtextgeo" cols = "100"> </textarea>
<br>

<input type = "submit" value = "save" />
<input type="reset" value="clear" />
</form>
<br />
</body>
</html>