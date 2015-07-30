<?php 
include_once 'functions_rhe.php';
$currentid = $_GET['cur_id'];
//restrict to posted items to keep people from viewing hidden items by editing id in browser field
$result = queryMysql("SELECT * FROM ItemsForSale WHERE itemid = $currentid AND status = 'posted'");
$row = mysql_fetch_row($result);
//variables created for readability in html
$itemDateTime = formatdate($row[6]);
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

    <title>Rug Hooking Exchange View</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <!-- link href="css/3-col-portfolio.css" rel="stylesheet" -->
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
    <br>
    <br>
<div class ="row"</div>
<div class = "col-md-6">
    <div id='content' class='container'>
		<div class="imgBig">
			<h2 class="text-center"><?php echo $titleString;?></h2>
			<h2 class="text-center">Price: <?php echo $itemPrice;?></h2>
		    <img id="main" src="photos/<?php echo $itemPhoto1;?>">
		    <div class="thumb"><a href="photos/<?php echo $itemPhoto1;?>" onclick="swap(this);
		            return false;"><img src="photos/<?php echo $itemPhoto1;?>"></a></div>
		    <div class="thumb"><a href="photos/<?php echo $itemPhoto2;?>" onclick="swap(this);
		            return false;"><img src="photos/<?php echo $itemPhoto2;?>"></a></div>
		    <div class="thumb"><a href="photos/<?php echo $itemPhoto3;?>" onclick="swap(this);
		            return false;"><img src="photos/<?php echo $itemPhoto3;?>"></a></div>
		    <h5><?php echo "Location:.",$locationString, "....Date Posted: ",  $itemDateTime;?></h5>
		    <h5><?php echo "<br>",$itemDescription;?></h5>
        </div>
    </div>
</div>
<div class = "col-md-6">

    <div id='content' class='container'> 
    <div id='postForm'>
      <h2>Contact Seller</h2>
            <h5><?php echo "current id:.",$currentid;?></h5>

      <p> Enter your email address and your message will be sent to the seller. </p>
      <p><span class="error">* required field.</span></p>
      <form method="post" action = "<?php echo 'process_email.php?cur_id='.$currentid;?>" enctype="multipart/form-data">

<h5><?php echo "in the form current id:.",$currentid;?></h5>
        Your Email: <input type="text" value="<?php echo $email;?>" name="email"> 
        <span class="error">* <?php echo $emailErr;?></span>        
        <br><br>
        Subject: <input type="text" name = "subject"  maxlength="50" size="50" placeholder = "The ... you listed on RugHooking Exchange">
       <!---  use php echo $titleString with other text to form placeholder message for
       email subject  I am interesed in your $titleString ;  --> 
         <br>
         <br>      
        Your Message to Seller:
        <br>
        <textarea name="message" placeholder="My name is ... I am interested in your ..." rows="10" cols="60"><?php echo $message;?></textarea>
        <br><br>
        <input type="submit" name="submit" class="btn btn-default" value="Submit">*

        <br><br>
      </form>
    </div>
</div>
</div>
</div>

</body>
</html>


