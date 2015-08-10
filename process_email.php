<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/3-col-portfolio.css" rel="stylesheet">
 <!--  <link href="css/RHEdefault.css" rel="stylesheet">
    <link href="css/rhe.css" rel="stylesheet">  html comment -->  

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<?php include_once("analyticstracking.php") ?>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="rughookingExchange.html">Rug Hooking Exchange</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="browseItem.php">Browse Items</a>
                    </li>
                    <li>
                        <a href="postItem.php">Post Items</a>
                    </li>
                    <li>
                        <a href="contact.php">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

<?php 

include_once 'functions_rhe.php';
extract($_POST);	
$currentid = $_GET['cur_id']; ?>
<div class="col-lg-12">
	<h3 class = "page-header text-center">An email will be sent to the seller on your behalf.  </br> 

	They will reply to the email address " <?php echo $email; ?> " that you provided </br>
	</br>
	</br>
    Thank-you for using Rughooking Exchange.</h3>
</div>
	<?php
	echo "</br>";
	echo "Buyers email will be: ". $email;
	echo "</br>";
	echo "your subject will be: ". $subject;
	echo "</br>";
	echo "your message will be: ". $message;
	echo "</br>";
	echo "id of the item is : ". $currentid;
	echo "</br>";

//$result = queryMysql("SELECT * FROM ItemsForSale WHERE status = 'posted' ORDER BY `postdate` DESC");

$result =  queryMysql("SELECT * FROM `ItemsForSale` WHERE `itemid` =  '$currentid'");
//example $result =  queryMysql("SELECT * FROM `ItemsForSale` WHERE `userKey` = '$userKey'");

$row_cnt = mysql_num_rows($result);
printf("Result set has %d rows. <br>", $row_cnt);
$row = mysql_fetch_array($result, MYSQL_NUM);
$userEmail = $row[7];
printf("want to send email to sellers email: %s . <br>", $userEmail);
printf("the sender is sheryl@sherylsdemospace.com, but reply should be to %s <br>", $email);
$reply = "Please reply to : " . $email;

$to = "$userEmail";
$subject = "$subject";
$txt = $reply . "\n" . $message;
$headers = "From: sheryl@sherylsdemospace.com" . "\r\n" .
"CC: sheryla3003@gmail.com";

mail($to,$subject,$txt,$headers);

?>
</body>
</html> 