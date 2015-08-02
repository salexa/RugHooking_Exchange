<?php
include_once 'functions_rhe.php';
// define variables and set to empty values
$nameErr = $emailErr = $categoryErr = "";
//$itemname = $email = $category = "";
$fail = "false"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["itemname"])) {
     $nameErr = "Name is required";
     $fail = 'true';
   } else {
     $itemname = test_input($_POST["itemname"]);
   }
   if (empty($_POST["category"])) {
     $category = "";
   } else {
     $category = test_input($_POST["category"]);
   }
   if (empty($_POST["description"])) {
     $descriptionErr = "Description is required";
     $fail = 'true';
   } else {
     $description = test_input($_POST["description"]);
   }
   if (empty($_POST["price"])) {
     $priceErr = "Price is required";
     $fail = 'true';
   } else {
     $price = test_input($_POST["price"]);
   }
  
   if (empty($_POST["email"])) {
     $emailErr = "Email is required";
     $fail = 'true';
   } else {
     $email = test_input($_POST["email"]);
   }
   if (empty($_POST["city"])) {
     $cityErr = "City is required";
     $fail = 'true';
   } else {
     $city = test_input($_POST["city"]);
   }
    if (empty($_POST["state"])) {
     $stateErr = "State is required";
     $fail = 'true';
   } else {
     $state = test_input($_POST["state"]);
   }
   
   ///this is not doing anything something is wrong with this
  //if (empty($_POST["fileToUpload1"])) 
    if ($_FILES["fileToUpload1"]["size"] == 0) {
     $fileToUpload1 = "empty";
   } else {
     $fileToUpload1 = test_input($_POST["fileToUpload1"]);
     $photoCnt = $photoCnt + 1; 
   }
  if (empty($_POST["fileToUpload2"])) {
     $fileToUpload2 = "empty";
   } else {
     $fileToUpload2 = test_input($_POST["fileToUpload2"]);
     $photoCnt = $photoCnt + 1;
   }
   if (empty($_POST["fileToUpload3"])) {
     $fileToUpload3 = "empty";
   } else {
     $fileToUpload3 = test_input($_POST["fileToUpload3"]);
     $photoCnt = $photoCnt + 1;
   }
   
   //check each potential upload file for size < 500KB
   //check for != 'empty' here (need to fix code above to set 'empty')
   $string1 = "fileToUpload1";

   $photoErr1 = checkSizeType($string1); 
   $string1 = "fileToUpload2";
   $photoErr2 = checkSizeType($string1);
   $string1 = "fileToUpload3";
   $photoErr3 = checkSizeType($string1); 
  
      // list($width, $height, $type, $attr) = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
   // printf("width is: %d height is :%d\n", $width, $height);
   //printf("type is : %s.\n", $type);
   //printf("attribute is : %s.\n", $attr);
  //below gets array of info from the file temporarily stored on server

//*****************problem with photo, size type, reject & error message**
// Check if $fail is set to true (too big or not jpeg), if not upload the file
if ($fail == 'true') {
  //should default to form here and display error message for field that failed
} else {  //need to move into section below for if $fail = 'false'
  //this is where the file is moved from special area to real file
   //$imageName is file name provided by the user: userfilename.jpg
   //$target_file file name provided by user with path added:  photos/userfilename.jpg


  //the if statements below are a fix for the ios (ipad, iphone) problem of calling all
// files image.jpg.  Files were getting overwritten when copied to server.  Had to
//rename them if they were named 'image.jpg',  better fix would be to to
//change name if $imageName2 == $imageName1,  not expect name to be 'image.jpg'
   $imageName1 = basename($_FILES["fileToUpload1"]["name"]); //this is inserted into db
   $imageName2 = basename($_FILES["fileToUpload2"]["name"]);
     if ($imageName2 == "image.jpg") {
     $imageName2 = "image2.jpg"; 
    }

   $imageName3 = basename($_FILES["fileToUpload3"]["name"]);
  if ($imageName3 == "image.jpg") {
     $imageName3 = "image3.jpg"; 
    }

  $target_dir = "photos/";
  $target_file1 = $target_dir . $imageName1;
  $target_file2 = $target_dir . $imageName2;
  $target_file3 = $target_dir . $imageName3;

   //$imageName is file name provided by the user: userfilename.jpg
   //$target_file file name provided by user with path added:  photos/userfilename.jpg

   move_uploaded_file($_FILES["fileToUpload1"]["tmp_name"], $target_file1);
   move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_file2);
   move_uploaded_file($_FILES["fileToUpload3"]["tmp_name"], $target_file3);
/*

    if (move_uploaded_file($_FILES["fileToUpload1"]["tmp_name"], $target_file1)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
        //keep from crapping out completely
    } 
    */
} 
   if ($fail == "false") {
    resizeImage(1000, 1000, $target_file1);
    resizeImage(1000, 1000, $target_file2);
    resizeImage(1000, 1000, $target_file3);

  // This is where you would enter the posted fields into a database
    $tempKey = createRandom(10);
    $userKey = test_input($tempKey);
    //printf("UserKey is : %s.\n", $userKey);
    //status field defaults to "waiting"
    queryMysql("INSERT INTO ItemsForSale (itemname, description, price, city, state, category, 
      useremail, salephoto, salephotoB, salephotoC, userKey) VALUES ('$itemname', '$description', '$price', '$city', '$state', 
      '$category', '$email', '$imageName1', '$imageName2', '$imageName3', '$userKey')");
    //need to get itemid to make image name with format itemid.jpg (itemid not available until INSERT done)
    //use the $userKey to get the itemid that was created when record was inserted
    $result =  queryMysql("SELECT `itemid` FROM `ItemsForSale` WHERE `userKey` = '$userKey'");
    $row = mysql_fetch_row($result);
    $itemid = $row[0]; 
/**** change photo name from user provided name to name of format imageA + idnum + .jpg **/
/*** and rename the photo file that is in ../photos/  **************/
    if ($imageName1 != "") {
      $savetoA = "imageA$itemid.jpg";  //make new variable $saveto that is imageitemid.jpg,  ex image87.jpg
      rename("$target_file1", "photos/$savetoA");
      }
      else {
        $savetoA = "";
        echo "imageName1 doesn't exist but is : $imageName1";

      }
      if ($imageName2 != "")  {
      $savetoB = "imageB$itemid.jpg";
      rename("$target_file2", "photos/$savetoB");
      }
      else {
        $savetoB = "";
        echo "imageName2 doesn't exist but is : $imageName2";
      }
      if ($imageName3 != "")  {
      $savetoC = "imageC$itemid.jpg";
      rename("$target_file3", "photos/$savetoC");
      }
      else {
        $savetoC = "";
        echo "imageName3 doesn't exist but is : $imageName3";

      }

    //update record with image names using idnum format
    queryMysql("UPDATE ItemsForSale SET salephoto = '$savetoA', salephotoB = '$savetoB', salephotoC = '$savetoC' WHERE itemid = $itemid");


    //TODO change header below to use itemid instead of $userKey, need to hide $userKey
    //$result = queryMysql("SELECT * FROM ItemsForSale WHERE itemid = '$userKey'");
    //$row = mysql_fetch_row($result);
    //$itemid = $row[0];
     header("Location: approval.php?code=$userKey");
       exit;
       }
}

?>
 <!DOCTYPE HTML>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rug Hooking Exchange View Item</title>

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
  <title>Rug Hooking Exchange Post</title>

<style>
.error {color: #FF0000;}
</style>
<!-- <link href="RHEdefault.css" rel="stylesheet" type="text/css" media="all" />   -->

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

  <div id='content' class='container'> 
    <div id='postForm'>
      <h1>Post Item</h1>
      <p><span class="error">* required field.</span></p>
      <form method="post" action="postItem.php" enctype="multipart/form-data">
        Item Name: <input type="text" value="<?php echo $itemname;?>" name="itemname">
        <span class="error">* <?php echo $nameErr;?></span>
        <br><br>
        Category: <select name="category" value="$category">
        <option value="equipment">Equipment</option>
        <option value="service">Service</option>
        <option value="supplies">Supplies</option>
        <option value="wanted">Wanted</option>
        </select>
        <br><br>
        Description:
        <br>
        <textarea name="description" rows="10" cols="50"><?php echo $description;?></textarea>
        <br><br>
        Price: <input type="text" maxlength="32" value="<?php echo $price;?>" name="price">
        <span class="error">* <?php echo $priceErr;?></span>
        <br></br>
        E-mail: <input type="text" value="<?php echo $email;?>" name="email"> 
        <span class="error">* <?php echo $emailErr;?></span>
        <br>
        E-mail will not be displayed in the posting
        <br><br>
        City: <input type="text" maxlength="32" value="<?php echo $city;?>" name="city" >
        <span class="error">* <?php echo $cityErr;?></span>
        <br></br>
        State <select name="state" value="$state">
        <option value="AL">Alabama</option>
        <option value="AK">Alaska</option>
        <option value="AZ">Arizona</option>
        <option value="AR">Arkansas</option>
        <option value="CA">California</option>
        <option value="CO">Colorado</option>
        <option value="CT">Connecticut</option>
        <option value="DE">Delaware</option>
        <option value="DC">District Of Columbia</option>
        <option value="FL">Florida</option>
        <option value="GA">Georgia</option>
        <option value="HI">Hawaii</option>
        <option value="ID">Idaho</option>
        <option value="IL">Illinois</option>
        <option value="IN">Indiana</option>
        <option value="IA">Iowa</option>
        <option value="KS">Kansas</option>
        <option value="KY">Kentucky</option>
        <option value="LA">Louisiana</option>
        <option value="ME">Maine</option>
        <option value="MD">Maryland</option>
        <option value="MA">Massachusetts</option>
        <option value="MI">Michigan</option>
        <option value="MN">Minnesota</option>
        <option value="MS">Mississippi</option>
        <option value="MO">Missouri</option>
        <option value="MT">Montana</option>
        <option value="NE">Nebraska</option>
        <option value="NV">Nevada</option>
        <option value="NH">New Hampshire</option>
        <option value="NJ">New Jersey</option>
        <option value="NM">New Mexico</option>
        <option value="NY">New York</option>
        <option value="NC">North Carolina</option>
        <option value="ND">North Dakota</option>
        <option value="OH">Ohio</option>
        <option value="OK">Oklahoma</option>
        <option value="OR">Oregon</option>
        <option value="PA">Pennsylvania</option>
        <option value="RI">Rhode Island</option>
        <option value="SC">South Carolina</option>
        <option value="SD">South Dakota</option>
        <option value="TN">Tennessee</option>
        <option value="TX">Texas</option>
        <option value="UT">Utah</option>
        <option value="VT">Vermont</option>
        <option value="VA">Virginia</option>
        <option value="WA">Washington</option>
        <option value="WV">West Virginia</option>
        <option value="WI">Wisconsin</option>
        <option value="WY">Wyoming</option>
        </select>
        <br></br>
        You can upload up to three images, images are not required
        Select image to upload:
        <input type="file" name="fileToUpload1" id="fileToUpload1">
        <span class="error">*** <?php echo $photoErr1;?></span>
        <br>
        Select image to upload:
        <input type="file" name="fileToUpload2" id="fileToUpload2">
        <span class="error">*** <?php echo $photoErr2;?></span>
        <br>
        Select image to upload:
        <input type="file" name="fileToUpload3" id="fileToUpload3">
        <span class="error">*** <?php echo $photoErr3;?></span>
        <br></br>
        <input type="submit" name="submit" value="Submit">*
        <br><br>
        *When you press 'submit', your ad will be displayed for your<br>
        approval.  If you approve you will be sent an email with </br>
        instructions to finalize your posting.<br>
      </form>
    </div>
    <div id="postformInstr">
      <h1> Instructions </h1><br>
      1. Enter item name<br>
      2. Select category<br>
      3. Enter a detailed description of the item.  You might want to inlude
      information such as condition, weight, perferred shipping method, shipping cost
      (if you know it), payment methods.  Anything entered here will be displayed,
      do not enter any personal information (address, phone number, etc.) unless
      you want it displayed in your ad.<br>
      4. Enter the price with $ in front, or negotionable, best offer, etc. If you are
      posting in the wanted category, you can leave price blank<br>
      5. Your email, this will not be displayed.  A pseudo-email will be displayed and
      any email sent to this pseudo email will be forwarded to the email you enter in 
      this field.<br>
      6. The city where the item is located.<br>
      7. The state where the item is located.<br>
      8. Browse your computer for a photo of the item.  The file size must be < 500KB
      and only jpeg images are accepted.  You do not have to upload a photo, but if you
      are selling an item a good photo is very important.<br>
    </div>
  </div>

  <div id="footer" class="container">
      <p>For questions, comments, suggestions contact <a href="mailto:sheryl@rughookingexchange.com">Sheryl@RughookingExchange.com</a></p>
  </div>

</body></html>