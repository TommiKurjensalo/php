<!DOCTYPE html> 
<html> 
 <head> 
 <meta charset="UTF-8"> 
 <title>Esimerkki</title> 
 </head> 
<body> 
<?php
	$aika = time(); 
	$paiva= date("j.n.Y", $aika);
	print("<p>Tänään on $paiva</p>"); 
?>
</body> 
</html>
