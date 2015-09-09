<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap Core CSS -->
    <link href="RHE_files/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="RHE_files/css/3-col-portfolio.css" rel="stylesheet">
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
<?php include_once("RHE_files/analyticstracking.php"); ?>
<?php include_once ("RHE_files/headerIndex.php") ?>

    <!-- Page Content -->
    <div class="container">

        <!-- Carousel================================================== -->
        <div id="myCarousel" class="carousel slide">
          <!-- Indicators -->
          <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner">
            <div class="item active">
              <img src="RHE_files/carouselImages/newcomposite.jpg" style="width:100%" class="img-responsive">
            </div>
            <div class="item">
              <img src="RHE_files/carouselImages/woolStack1200x500.jpg" style="width:100%" class="img-responsive">
            </div>
            <div class="item">
              <img src= "RHE_files/carouselImages/mondrian2rows1200x500.jpg" style="width:100%" class="img-responsive">     
            </div>
          </div>
          <!-- Controls -->
          <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
          </a>
          <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
          </a>  
        </div>
<!-- /.carousel -->

        <!-- Words below carousel -->
            <div class="col-lg-12">
                <h2 class="page-header text-center">Rug Hooking Exchange </h2>
                <p class = "lead text-center">Where rug hookers can buy and sell equipment, services, and supplies
                    <br>
                    <br>
                    <a href="RHE_files/browseItem.php" class="btn btn-sm btn-primary">Browse Items</a>
                    <a href="RHE_files/postItem.php" class="btn btn-sm btn-primary">Post Items</a>
                </p>
            </div>
        <!-- /words below carousel -->
 <!--
    <div class="container">
        <h2 class="visible-lg">Large</h2>
        <h2 class="visible-md">Medium</h2>
        <h2 class="visible-sm">Small</h2>
        <h2 class="visible-xs">Extra Small</h2>
        <h2 class="visible-print">Print</h2>
    </div>
        <hr>
-->
        <!-- Footer -->
        <footer>

        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="RHE_files/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="RHE_files/js/bootstrap.min.js"></script>

</body>

</html>
