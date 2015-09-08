<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rug Hooking Exchange Browse</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/3-col-portfolio.css" rel="stylesheet">


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
<?php include_once ("header.php") ?>
    <!-- Page Content -->
    <div class="container">

        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header text-center">Rug Hooking Exchange Browse Items
                </h2>
                <p class = "lead text-center">Click on Image to Enlarge and Send Message to Seller

            </div>
        </div>
        <!-- /.row -->


 <?php 
include_once 'functions_rhe.php';

//$result = queryMysql("SELECT * FROM ItemsForSale WHERE status = 'posted' ORDER BY `postdate` DESC");

$sql = "SELECT * FROM ItemsForSale WHERE status = 'posted' ORDER BY `postdate` DESC";  

//$result = queryMysql($sql);
$result = mysqli_query($conn, $sql);

        $row_cnt = mysqli_num_rows($result);
       // printf("Result set has %d rows.\n", $row_cnt);

echo"<br></br>"; 
//need to add container row every 4th item
echo '<div class="row"></div>';
$item = 0;
while ($row = mysqli_fetch_array($result, MYSQL_NUM)) {
    $itemDateTime = formatdate($row[6]);
    $category = $row[8];
    $locationString = $row[4].", ".$row[5];  //city, state
    $itemPhoto = $row[9];
    if ($itemPhoto == '') {
        $itemPhoto = "noImage.jpg";
    }
    $itemTitle = $row[1];
    $itemPrice = $row[3];
    $itemDescription = $row[2]; 
    $userKey = $row[13];
    $vendor = $row[14];
    $vendorlink = $row[15];

    //printf("itemid %s  itemname: %s what: %s", $row[0], $row[1], $row[9]); 
    if ($item % 4 == 0) {
       // printf("if mod 4 is true item is" . $item); 
        echo '<div class="row">';
            }  
    $item = $item + 1;
    $temp = formatdate($row[6]);
    echo "<div class = 'col-xs-6 col-sm-3 portfolio-item'>";
    echo "<a href='viewItem.php?cur_id=$row[0]'> <img class='img-responsive' src = 'photos/$itemPhoto' ></a>";

    if ($category == 'wanted')  
     {$dispString = "    (Wanted)";}  //want to display wanted instead of price for item category wanted
    else
        {$dispString = $itemPrice;} //want to display price for items that should price
    echo "<h4> $itemTitle</h4>";
    echo "<h5> $dispString</h5>";
    if (($vendor == 'Yes') && ($vendorlink != 'Empty')){
        echo "<p>Visit our site : <a href='http://www.$vendorlink/'>$vendorlink</a> </p>";
    }
    echo "<p> Location: $locationString</p>";
    echo "<p> Date Posted: $itemDateTime   CST</p>";

   /* echo "<div class='item_desc'> category: $row[8]</div>"; */
    echo "</div>";
    if (($item % 4 == 0) && ($item != 0)) {  //need to put in closing div for class = "row", needed for BootStrap
        echo '</div>';
            }  
}

 echo "</div>"; 
?>

    <div class="container">
        <h2 class="visible-lg">Large</h2>
        <h2 class="visible-md">Medium</h2>
        <h2 class="visible-sm">Small</h2>
        <h2 class="visible-xs">Extra Small</h2>
        <h2 class="visible-print">Print</h2>
    </div>
        <hr>


        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; rughookingExchange 2015</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
