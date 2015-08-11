<?php
if(isset($_POST))

$pass = $_POST['pass'];

if($pass == "sheryl")
{
        include("rughookingExchange.html");
}
else
{
    
    
}
?>


<!doctype html>
<html>
<head>
	<title>sherylsdemospace.com</title>
	<meta name="description" content="The owner of this domain has not yet uploaded their website." />
	<link rel="stylesheet" href="//securendn.a.ssl.fastly.net/newpanel/css/singlepage.css" />
</head>

<body>
	<?php include_once("analyticstracking.php") ?>
	<div class="page page-comingsoon">
		<h1>sherylsdemospace.com</h1>

		<p>Look at all the Great Stuff</p>

		<form action="password.php" method="post">
    		<label for="pass">Password</label>
    		<input type="password" name ="pass" placeholder="What could it be?">
  		</form>

<!-- 		<div class="button-row">
			<a href="http://sherylsdemospace.com/RHE_BootStrap/rughookingExchange.html" class="btn-simple">Rug Hooking Exchange</a>
			<a href=# class="btn-simple">No Where</a>
		</div>   -->
	</div>
</body>
</html>