<?php 
include_once 'functions_rhe.php';

//******************** This executed after Submit ***********************************
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $currentCode = $_GET['code'];
  $selected_radio = $_POST['approve'];
   if ($selected_radio == 'Approve')
    //change value of status to 'approved' or 'delete'
   	{ 
      $sql = "UPDATE `ItemsForSale` SET `status` = 'approved' WHERE `userKey`= '$currentCode'";
      // old way queryMysql("UPDATE `ItemsForSale` SET `status` = 'approved' WHERE `userKey`= '$currentCode';");
      mysqli_query($conn, $sql);
      //echo "I think Approve was selected";
    }
   elseif ($selected_radio == 'Delete')
   { 
      $sql = "UPDATE `ItemsForSale` SET `status` = 'delete' WHERE `userKey`= '$currentCode'";
      // old wayqueryMysql("UPDATE `ItemsForSale` SET `status` = 'delete' WHERE `userKey`= '$currentCode';");
      mysqli_query($conn, $sql);
    //echo "I think Delete was selected";
    }

 header("Location: ../index.php");
       exit;
}

//***************************** above executed after submit *********************************************
//***** first part of this section should be the same as Generic_item.php **********************
//** below this line is started from a link sent in the approval email, uses userKey *******************
$currentCode = $_GET['code'];
//printf("currentCode is :%s\n", $currentCode);
$sql = "SELECT * FROM ItemsForSale WHERE userKey = '$currentCode'";
$result = mysqli_query($conn, $sql);
// old way $result = queryMysql("SELECT * FROM ItemsForSale WHERE userKey = '$currentCode';");
$row = mysqli_fetch_row($result);


$itemDateTime = formatdate($row[6]);
$itemEmail = $row[7];
$category = $row[8];
$vendor = $row[14];
$vendorlink = $row[15];
$locationString = $row[4].", ".$row[5];  //city, state
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

    <title>Rug Hooking Exchange Approval</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/3-col-portfolio.css" rel="stylesheet">
    <link REL="StyleSheet" TYPE="text/css" HREF="css/rhe.css">
  <!-- html comment  <link href="css/RHEdefault.css" rel="stylesheet" type="text/css" media="all" />  --> 

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

<script type="text/javascript">
         function swap(image) {
             document.getElementById("main").src = image.href;
         }
     </script>
</head>
<body>
  <?php include_once("analyticstracking.php") ?>
  <?php include_once ("header.php") ?>

    <div id='content' class='container'>
      <br>
      <div class="col-sm-12">
        <h1 align = 'center'>Review and Approve Your Ad</h1>
      </div>
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
        <h4>Location: <small><?php echo $locationString?></small></h4>
              <?php if (($vendor == 'Yes') && ($vendorlink != 'Empty')){
                  echo "<p>Visit our site : <a href='http://www.$vendorlink/'>$vendorlink</a> </p>";
                 }?>
            <h4>Date Posted: <small><?php echo $itemDateTime ,"  CST";?></small></h4>
        <h4>Item Description:</h4><small><?php echo "$itemDescription";?></small>
            </div> <!--thumbCenter -->
        </div>
    </div>
</div>


              <div class="col-sm-6">
                <br><br><br>
                <div id='content' class='container'> 
                <div id='inquireForm'>
               <p>Select approve below your ad will be posted within 24 hours.
                To reject or delete this posting select delete below and your posting will be deleted.</p>
                <form Method ="Post" action="finalApproval.php?code=<?php echo $currentCode; ?>">
                  <label class="block"><input type="radio" name="approve" value="Approve" checked>   Approve </label>
                  <br>
                  <label class="block"><input type="radio" name="approve" value="Delete">   Delete </label>
                  <br></br>
                  <input type="submit" value="Submit">
                </form>
              </div>
            </div>
          </div>

    </div> 
  </body>
  </html>