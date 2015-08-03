<html>
<body>
<?php include_once("analyticstracking.php") ?>
<?php 
include_once 'functions_rhe.php';
extract($_POST);	
$currentid = $_GET['cur_id']; ?>
<h3>An email will be sent to the seller on your behalf.  They will reply </br>
	to the email address " <?php echo $email; ?> " that you provided </br>
    Thank-you for using Rughooking Exchange.</h3>
<?php
echo "</br>";
echo "your email will be: ". $email;
echo "</br>";
echo "your subject will be: ". $subject;
echo "</br>";
echo "your messaage will be: ". $message;
echo "</br>";
echo "current id is : ". $currentid;
echo "</br>";

//$result = queryMysql("SELECT * FROM ItemsForSale WHERE status = 'posted' ORDER BY `postdate` DESC");

$result = queryMysql("SELECT * FROM ItemsForSale WHERE itemid = '21' ORDER BY `postdate` DESC");
$row_cnt = mysql_num_rows($result);
printf("Result set has %d rows. <br>", $row_cnt);
$row = mysql_fetch_array($result, MYSQL_NUM);
$userEmail = $row[7];
printf("want to send email to : %s . <br>", $userEmail);


$to = "$userEmail";
$subject = "$subject";
$txt = "message";
$headers = "From: sheryl@sherylsdemospace.com" . "\r\n" .
//"CC: alexander_sheryl@yahoo.com";

mail($to,$subject,$txt,$headers);

?>
</body>
</html> 