<?php
include_once 'functions_rhe.php';
$alert = $_GET['alertText'];
//echo "alert is : " . $alert;
//message from viewItem.php for successful form submission from buyer to seller
//can use this page to display messages or alerts from other pages

if ($alert == "'thanks'")
    {$message = "An email on your behalf will be sent to the Seller ";
        }
    elseif ($alert == "'approvalDeleted'")
        {$message = "Your posting has been deleted";
        }
        
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rug Hooking Exchange Alert</title>

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
<?php include_once ("header.php") ?>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <br><br>
                <p style= 'text-align: center'><img src="resources/ladyHead.jpg" alt="hooked rug cleaner" style="width:250px;height:250px;"><br><br></p>
                <!-- would like to put an image here -->
                <h2 style= 'text-align: center'>Thank-you for using Rug Hooking Exchange</h2>
            </br><br>
                <h3 style= 'text-align: center'> <?php echo $message ?> </h3>
                <br><br><br><br>
               <p style= 'text-align: center'> <a href="browseItem.php" class="btn btn-sm btn-primary">Continue</a></p>

            </div>
        </div>
        <!-- /.row -->

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
