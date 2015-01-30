<?php
session_start();
if (! $_SESSION['is_logged']) header("Location:index.html");
?>

<html>


<body>

Project Body<br />
<form method="post" action="savepro.php">
 <br />

NameGEO for thumb<br>
<input name="NameGEO" type="text"><br>

NameENG for thumb<br>
<input name="NameENG" type="text"><br>


Type[1..4] <br>
<input name="Type" type="number"><br>


NameGeo<br>
<input name="NameG" type="text"><br>

NameEng <br>
<input name="NameE" type="text"><br>

AddressGeo <br>
<input name="AddressGeo" type="text"><br>

AddressEng <br>
<input name="AddressEng" type="text"><br>

Date (yyyy-mm-dd) <br>
<input name="date" type="text"><br>



function eng<br>
<textarea rows = "2" name = "FunctionENG" cols = "20"> </textarea>

 <br>
function geo <br>
<textarea rows = "2" name = "FunctionGEO" cols = "20"> </textarea>


<input type = "submit" value = "save" />
<input type="reset" value="clear" />
</form>
<br />
</body>
</html>