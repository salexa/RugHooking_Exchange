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
                        <a href="#">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Rug Hooking Exchange Browse
                </h1>
            </div>
        </div>
        <!-- /.row -->


 <?php 
include_once 'functions_rhe.php';
    
echo "<div id='content' class='container'>";  
//echo "<h3>Browse Rug Hooking Items</h3>";  
   
$result = queryMysql("SELECT * FROM ItemsForSale WHERE status = 'posted' ORDER BY `postdate` DESC");
        $row_cnt = mysql_num_rows($result);
        printf("Result set has %d rows.\n", $row_cnt);
//variables created for readability in html
$itemDateTime = formatdate($row[6]);
$category = $row[8];
$locationString = $row[4].", ".$row[5];  //city, state
$itemPhoto = $row[9];
$itemTitle = $row[1];
$itemPrice = $row[3];
$itemDescription = $row[2];      
echo"<br></br>"; 
//need to add container row every 4th item
echo '<div class="row"></div>';
$item = 0;
while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
   // printf("itemid %s  itemname: %s what: %s", $row[0], $row[1], $row[9]); 
    $item = $item + 1;
    if ($item % 4 == 0) {
        echo '<div class="row">';
            }  
    $temp = formatdate($row[6]);
    echo "<div class = 'col-xs-6 col-sm-3 portfolio-item'>";
    echo "<a href='viewItem.php?cur_id=$row[0]'> <img class='img-responsive' src = 'photos/$row[9]' ></a>";
    if ($row[8] == 'wanted')  
     {$dispString = "    (Wanted)";}  //want to display wanted for item category wanted
    if ($row[8] == 'equipment')
        {$dispString = $row[3];} //want to display price for items that should price
    echo "<h3> $row[1]    $dispString</h3>";
    echo "<p> Location: $row[4],$row[5]</p>";
    echo "<p> Date Posted: $temp</p>";


   /* echo "<div class='item_desc'> category: $row[8]</div>"; */
    echo "</div>";
    if ($item % 4 == 0) {  //need to put in closing div for class = "row", needed for BootStrap
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
                    <p>Copyright &copy; Your Website 2014</p>
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
