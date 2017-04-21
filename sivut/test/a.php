<?php
/*
$required = FALSE;

// Onko painettu tallenna-painiketta
if (isset($_POST["tallenna"])) {
   // Viedään muodostimelle kenttien arvot

        if ($required !== FALSE) {
        // Jos kentät on tyhjiä
          if ((strpos($_POST["pvm"], 'none') !==FALSE) || (strpos($_POST["kk"], 'none') !==FALSE) || (strpos($_POST["vuosi"])) {
                return $virhe="kentät on tyhjiä";
          }
        }
}
*/
?>
<!DOCTYPE html>

<head>

    <meta charset="utf-8">

    <title>strposTest</title>

</head>
<body>
<h1>testi</h1>
<p>jeejee</p>

<form role="form" action=""<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" " method="post">
<input name="pvm" type="text" value="none"/><input name="kk" type="text" value="none"/><input name="vuosi" type="text" value="none"/>

<input name="tallenna" type="submit" value="Tallenna"/>
</form>

<br><br>
<p>Required: <?php ($required !== FALSE) ? 'true';'false'; ?></p>
<br><br>

<p>virhe: <?php if (isset($virhe) return $virhe ?> </p>


</body>
</html>

