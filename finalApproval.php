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
    else 
   { 
   // echo "Problem, I did not think Approve or Delete were set";
    }
 header("Location: rughookingExchange.html");
       exit;
}

//***************************** above executed after submit *********************************************
//***** first part of this section should be the same as Generic_item.php **********************
$currentCode = $_GET['code'];
printf("currentCode is :%s\n", $currentCode);
$sql = "SELECT * FROM ItemsForSale WHERE userKey = '$currentCode'";
$result = mysqli_query($conn, $sql);
// old way $result = queryMysql("SELECT * FROM ItemsForSale WHERE userKey = '$currentCode';");
$row = mysqli_fetch_row($result);


//variables created for readability in html
//variables created for readability in html
$itemDateTime = formatdate($row[6]);
$itemEmail = $row[7];
$category = $row[8];
$locationString = $row[4].", ".$row[5];  //city, state
$itemPhoto1 = $row[9];
$itemPhoto2 = $row[10];
$itemPhoto3 = $row[11];

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


    <div id='content' class='container'>
      <br>
      <div class="col-sm-12">
        <h1 align = 'center'>Review and Approve Your Ad</h1>
      </div>
      <div class="col-md-8">
        <div class="imgBig">
          <h1><?php echo $titleString;?></h1>
          <h1>Price: <?php echo $itemPrice;?></h1>
          <img id="main" src="photos/<?php echo $itemPhoto1;?>">
          <div class="thumb"><a href="photos/<?php echo $itemPhoto1;?>" onclick="swap(this);
            return false;"><img src="photos/<?php echo $itemPhoto1;?>"></a></div>
          <div class="thumb"><a href="photos/<?php echo $itemPhoto2;?>" onclick="swap(this);
              return false;"><img src="photos/<?php echo $itemPhoto2;?>"></a></div>
          <div class="thumb"><a href="photos/<?php echo $itemPhoto3;?>" onclick="swap(this);
                return false;"><img src="photos/<?php echo $itemPhoto3;?>"></a></div>
          <h5><?php echo "Location:.",$locationString, "....Date Posted: ",  $itemDateTime;?></h5>
          <h5><?php echo "<br>",$itemDescription;?></h5>
        </h5>
      </div>


              <div class="col-sm-4">
               <p>Select approve below your ad will be posted within 24 hours.
                To reject or delete this posting select delete below and your posting will be deleted.<p>
                <form Method ="Post" action="finalApproval.php?code=<?php echo $currentCode; ?>">
                  <label class="block"><input type="radio" name="approve" value="Approve" checked>   Approve </label>
                  <br>
                  <label class="block"><input type="radio" name="approve" value="Delete">   Delete </label>
                  <br></br>
                  <input type="submit" value="Submit">
                </form>
              </div>

    </div> 

       <div class="col-sm-12">
      <p>For questions, comments, suggestions contact <a href="mailto:sheryl@rughookingexchange.com">Sheryl@RughookingExchange.com</a></p>
  </div>
  </body>
  </html>