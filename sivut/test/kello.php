<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>


    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Kello testi</title>
    

</head>
<body>

 <label>Kello</label>
<br><br>


	
<script type="text/javascript">
function GetClock(){
var d=new Date();
var nmonth=d.getMonth(),ndate=d.getDate(),nyear=d.getYear();
if(nyear<1000) nyear+=1900;
var nhour=d.getHours(),nmin=d.getMinutes(),nsec=d.getSeconds();
if(nmin<=9) nmin="0"+nmin
if(nsec<=9) nsec="0"+nsec;

document.getElementById('clockbox').innerHTML=""+ndate+"."+(nmonth+1)+"."+nyear+" "+nhour+":"+nmin+":"+nsec+"";
}

window.onload=function(){
GetClock();
setInterval(GetClock,1000);
}
// http://www.webestools.com/scripts_tutorials-code-source-7-display-date-and-time-in-javascript-real-time-clock-javascript-date-time.html

</script>
<div id="clockbox" style="font:14pt Arial; color:#FF0000;"></div>

</body>
</html>
