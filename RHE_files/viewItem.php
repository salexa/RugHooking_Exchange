<?php 
include_once 'functions_rhe.php';

/* enter here from submit button on form */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  /*this age field checks for robot entry, must be empty*/
    if (empty($_POST["age"])) {
    /* don't need to do anything */
   } else {
     $fail = 'true';
     $ageErr = "you are a robot"; 
   }

    /* first check for email field blank, then check for valid email */
   if (empty($_POST["email"])) {
     $emailErr = "Email is required";
     $fail = 'true';
   } else {
     $email = test_input($_POST["email"]);
     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format"; 
        $fail = 'true';
        }
     }
   if (empty($_POST["subject"])) {
     $subjectErr = "Subject is required";
     $fail = 'true';
   } else {
     $subject = test_input($_POST["subject"]);
   }
   if (empty($_POST["message"])) {
     $messageErr = "Message is required";
     $fail = 'true';
   } else {
     $message = test_input($_POST["message"]);
   }
   
   if (!$fail) {
    extract($_POST);    
    $currentid = $_GET['cur_id'];
//    echo "</br>";
//    echo "</br>";
//    echo "</br>";
//    echo "</br>";
//    echo "your email will be: ". $email;
//    echo "</br>";
//    echo "your subject will be: ". $subject;
//    echo "</br>";
//    echo "your messaage will be: ". $message;
//    echo "</br>";
//    echo "current id is : ". $currentid;
//    echo "</br>";

    $sql = "SELECT * FROM ItemsForSale WHERE itemid = $currentid ORDER BY `postdate` DESC";  
    $result = mysqli_query($conn, $sql);

    $row_cnt = mysqli_num_rows($result);
//    printf("Result set has %d rows. <br>", $row_cnt);
    $row = mysqli_fetch_array($result, MYSQL_NUM);
    $userEmail = $row[7];
//    printf("want to send email to : %s . <br>", $userEmail);
    $reply = "Please reply to : " . $email;

    $to = "$userEmail";
    $subject = "$subject";
    $txt = $reply . "\n" . $message;
 //   $headers = "From: sheryl@sherylsdemospace.com" . "\r\n" . mail($to,$subject,$txt,$headers);

    $headers = "From: sheryl@rughookingExchange.com";
    mail($to,$subject,$txt,$headers);

//thank you message sent via alert.php page

    header("Location: alert.php?alertText='thanks'");

 exit;


   } // end if !fail

} //end if REQUEST_METHOD
?>


<!--below executed when page entered from browseItem.php ****************************  -->

<?php
include_once 'functions_rhe.php';

$currentid = $_GET['cur_id'];
//restrict to posted items to keep people from viewing hidden items by editing id in browser field
$sql = "SELECT * FROM ItemsForSale WHERE itemid = $currentid AND status = 'posted'";
//$result = queryMysql("SELECT * FROM ItemsForSale WHERE itemid = $currentid AND status = 'posted'");
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_row($result);
//variables created for readability in html
$itemDateTime = formatdate($row[6]);
$category = $row[8];
$locationString = $row[4].", ".$row[5];  //city, state
$vendor = $row[14];
$vendorlink = $row[15];
$itemPhoto1 = $row[9];
if ($itemPhoto1 == '') {
    $itemPhoto1 = "noImage.jpg";
}
$itemPhoto2 = $row[10];
if ($itemPhoto2 == '') {
    $itemPhoto2 = "noImage.jpg";
}
$itemPhoto3 = $row[11];
if ($itemPhoto3 == '') {
    $itemPhoto3 = "noImage.jpg";
}
$itemTitle = $row[1];
$itemPrice = $row[3];
$itemDescription = $row[2];

//Modify header for category
if ($category == 'wanted')
{$titleString = "Wanted: $row[1] ";}
if ($category != 'wanted')
{$titleString = $row[1];}

?>


<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rug Hooking Exchange View</title>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <!-- link href="css/3-col-portfolio.css" rel="stylesheet" -->
    <link REL="StyleSheet" TYPE="text/css" HREF="css/rhe.css">
    <!--   <link href="css/RHEdefault.css" rel="stylesheet" type="text/css" media="all" />  --> 

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<style>
.error {color: #FF0000;}
</style>
<script type="text/javascript">
         function swap(image) {
             document.getElementById("main").src = image.href;
         }
     </script>
</head>
<body>
    <?php include_once("analyticstracking.php") ?>
    <!-- Navigation -->
<?php include_once ("header.php") ?>

    <br>
    <br>
<div class ="row"</div>
<div class = "col-md-6">
    <div id='content' class='container'>
		<div class="imgBig">
			<h3 class="text-center"><?php echo $titleString;?></h3>
			<h4 class="text-center">Price: <?php echo $itemPrice;?></h4>
		    <img id="main" src="photos/<?php echo $itemPhoto1;?>">
            <div class="thumbCenter">
		    <div class="thumb"><a href="photos/<?php echo $itemPhoto1;?>" onclick="swap(this);
		            return false;"><img src="photos/<?php echo $itemPhoto1;?>"></a></div>
		    <div class="thumb"><a href="photos/<?php echo $itemPhoto2;?>" onclick="swap(this);
		            return false;"><img src="photos/<?php echo $itemPhoto2;?>"></a></div>
		    <div class="thumb"><a href="photos/<?php echo $itemPhoto3;?>" onclick="swap(this);
		            return false;"><img src="photos/<?php echo $itemPhoto3;?>"></a></div>
      <!--      </div> thumbCenter -->
		    <h5>Location: <small><?php echo $locationString?></small></h5>
            <?php if (($vendor == 'Yes') && ($vendorlink != 'Empty')){
                    echo "<p>Visit our site : <a href='http://www.$vendorlink/'>$vendorlink</a> </p>";
                         } ?>
            <h5>Date Posted: <small><?php echo $itemDateTime ,"  CST";?></small></h5>
		    <h5><?php echo "<br>",$itemDescription;?></h5>
            </div> <!--thumbCenter -->
        </div>
    </div>
</div>
    <div class = "col-md-6">
    <div id='content' class='container'> 
    <div id='inquireForm'>
      <h3>Contact Seller</h3>
      <p> Enter your email address and your message will be sent to the seller. </p>
      <p><span class="error">*** required field.</span></p>
    
        <form method="post" action = "<?php echo 'viewItem.php?cur_id='.$currentid;?>" enctype="multipart/form-data">

        Your Email: <input type="text" value="<?php echo $email;?>" name="email"> 
        <span class="error">***<?php echo $emailErr;?></span>        
        <br><br>
        Subject: <input type="text" name = "subject"  maxlength="50" size="30">
        <span class="error">***<?php echo $subjectErr;?></span> 
         <br><br>    
        Your Message to Seller:
        <span class="error">***<?php echo $messageErr;?></span> 
        <br>
        <textarea name="message" rows="10" cols="40"></textarea>
        <br><br>
        <!-- below is a field hidden in css that must stay blank, robots will fill it out humans can't see it -->
        <span class = "thepot">
        <p>
        <span class="error">***<?php echo $ageErr;?></span> 
        Age: <input type="text" name="age" value="" alt="if you fill this field out then your email will not be sent"/>
        </p></span>
        <input type="submit" name="submit" class="btn btn-default" value="Submit">
        <br><br>
      </form>
    </div>
</div>
</div>
</div>

</body>
</html>


