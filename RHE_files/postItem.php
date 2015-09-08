<?php
include_once 'functions_rhe.php';

// define variables and set to empty values
$nameErr = $emailErr = $categoryErr = $descriptionErr = $priceErr = $cityErr= $stateErr = "";
$itemname = $category = $description = $price = $email = $city = $state = "";
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
   if (empty($_POST["vendor"])) {
     $vendor = "";
   } else {
     $vendor = test_input($_POST["vendor"]);
   }
   if (empty($_POST["vendorlink"])) {
     $vendorlink = "";
   } else {
     $vendorlink = test_input($_POST["vendorlink"]);
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
     
    if ($_FILES["fileToUpload1"]["size"] == 0) {
     $fileToUpload1 = "empty";
   //  echo "I think fileToUpload1 is empty";
   } else {
     $fileToUpload1 = test_input($_POST["fileToUpload1"]);
     $photoCnt = $photoCnt + 1; 
   }
    if ($_FILES["fileToUpload2"]["size"] == 0) {
     $fileToUpload2 = "empty";
  //   echo "I think fileToUpload2 is empty";
   } else {
     $fileToUpload2 = test_input($_POST["fileToUpload2"]);
     $photoCnt = $photoCnt + 1;
   }
    if ($_FILES["fileToUpload3"]["size"] == 0) {
     $fileToUpload3 = "empty";
 //    echo "I think fileToUpload3 is empty";

   } else {
     $fileToUpload3 = test_input($_POST["fileToUpload3"]);
     $photoCnt = $photoCnt + 1;
   }

/***overview of how image uploading is done
    1. before uploading files are checked for < 500K and jpeg format only 
    2. get the name of the image $imageName1 = basename($_FILES["fileToUpload1"]["name"]); 
    3. $target_file1 string is created to be "photos/$imageName1"
    4. files are uploaded to photos directory using 'move_uploaded_file'
    5. photos are resized using resize image if they exist
    6. all values from form are inserted into db, using poster provided image names
    7. now an item_id is created in the db for this record
    8. the item_id is retreived and used to create a name for the image of format
        'imageA10.jpg, imageB10.jpg, and imageC11.jpg' and the customer image names
         in the photos directory are overwritten with these new names.  The customer
         provided photo names inthe db are overwritten with the new format names.
         I was concerned about having an easy way to tie together images in the photos 
         directory with the record inthe db they belong to.  ***/

 //     if ($_FILES["fileToUpload1"]["size"] > 500000) {
  //      echo "I think the file is tooooo big";
   //   }

   //check each potential upload file for size < 500K and only jpg accepted
   $photoErr1 = checkSizeType("fileToUpload1");
   $photoErr2 = checkSizeType("fileToUpload2");
   $photoErr3 = checkSizeType("fileToUpload3");
  
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
   //check for "image.jpg" fix for ipad,iphone problem with image names always being image.jpg
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

// only go to resizeImage if file exists
      if ($fileToUpload1 != "empty") {
          resizeImage(1000, 1000, $target_file1);
      }
      if ($fileToUpload2 != "empty") {
          resizeImage(1000, 1000, $target_file2);
      }
      if ($fileToUpload3 != "empty") {
          resizeImage(1000, 1000, $target_file3);
      }
 

  // This is where you would enter the posted fields into a database
    $tempKey = createRandom(10);
    $userKey = test_input($tempKey);
    //printf("UserKey is : %s.\n", $userKey);
    //status field defaults to "waiting"
    //$sql = "INSERT INTO ItemsForSale (itemname) VALUES ('$itemname')";

  $sql = "INSERT INTO ItemsForSale (itemname, description, price, city, state, category, 
     useremail, salephoto, salephotoB, salephotoC, userKey, vendor, vendorlink) VALUES ('$itemname', '$description', '$price', '$city', '$state', 
      '$category', '$email', '$imageName1', '$imageName2', '$imageName3', '$userKey', '$vendor', '$vendorlink')";  

      mysqli_query($conn, $sql);

    // old way  queryMysql("INSERT INTO ItemsForSale (itemname, description, price, city, state, category, 
    //  useremail, salephoto, salephotoB, salephotoC, userKey) VALUES ('$itemname', '$description', '$price', '$city', '$state', 
    //  '$category', '$email', '$imageName1', '$imageName2', '$imageName3', '$userKey')");
    //need to get itemid to make image name with format itemid.jpg (itemid not available until INSERT done)
    //use the $userKey to get the itemid that was created when record was inserted

    $sql = "SELECT `itemid` FROM `ItemsForSale` WHERE `userKey` = '$userKey'";
    $result = mysqli_query($conn, $sql);
    // old way $result =  queryMysql("SELECT `itemid` FROM `ItemsForSale` WHERE `userKey` = '$userKey'");
    $row = mysqli_fetch_row($result);
    $itemid = $row[0]; 

/**** change photo name from user provided name to name of format imageA + idnum + .jpg **/
/*** and rename the photo file that is in ../photos/  **************/
// want to be able to clean out photo directory of photos no longer used, need naming convention
    if ($imageName1 != "") {
      $savetoA = "imageA$itemid.jpg";  //make new variable $saveto that is imageitemid.jpg,  ex image87.jpg
      rename("$target_file1", "photos/$savetoA");
      $sql = "UPDATE ItemsForSale SET salephoto = '$savetoA' WHERE itemid = $itemid";
      $result = mysqli_query($conn, $sql);
      // old way queryMysql("UPDATE ItemsForSale SET salephoto = '$savetoA' WHERE itemid = $itemid");

      }
      else {
        $savetoA = "";
     //   echo "imageName1 doesn't exist but is : $imageName1";

      }
      if ($imageName2 != "")  {
      $savetoB = "imageB$itemid.jpg";
      rename("$target_file2", "photos/$savetoB");
      $sql = "UPDATE ItemsForSale SET salephotoB = '$savetoB' WHERE itemid = $itemid";
      $result = mysqli_query($conn, $sql);
      // old way queryMysql("UPDATE ItemsForSale SET salephotoB = '$savetoB' WHERE itemid = $itemid");

      }
      else {
        $savetoB = "";
  //      echo "imageName2 doesn't exist but is : $imageName2";
      }
      if ($imageName3 != "")  {
      $savetoC = "imageC$itemid.jpg";
      rename("$target_file3", "photos/$savetoC");
      $sql = "UPDATE ItemsForSale SET salephotoC = '$savetoC' WHERE itemid = $itemid";
      $result = mysqli_query($conn, $sql);
      // old way queryMysql("UPDATE ItemsForSale SET salephotoC = '$savetoC' WHERE itemid = $itemid");

      }
      else {
        $savetoC = "";
  //      echo "imageName3 doesn't exist but is : $imageName3";

      }

    
    //TODO change header below to use itemid instead of $userKey, need to hide $userKey
    //$result = queryMysql("SELECT * FROM ItemsForSale WHERE itemid = '$userKey'");
    //$row = mysql_fetch_row($result);
    //$itemid = $row[0];
     header("Location: approval.php?code=$itemid");
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

    <title>Rug Hooking Exchange Post Item</title>


    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>


    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/3-col-portfolio.css" rel="stylesheet">
    <link href="css/rhe.css" rel="stylesheet">


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
<?php include_once("analyticstracking.php") ?>
    <!-- Navigation -->
<?php include_once ("header.php") ?>
<div class ="row">
<div class = "col-md-6">

    <div id='postForm'>
      <h2>Post Item</h2>
      <p><span class="error">*** required field.</span></p>
      <form method="post" action="postItem.php" enctype="multipart/form-data">
        Item Name: <input type="text" value="<?php echo $itemname;?>" name="itemname">
        <span class="error">*** <?php echo $nameErr;?></span>
        <br><br>
        Category: <select name="category" value="$category">
        <option value="equipment">Equipment</option>
        <option value="service">Service</option>
        <option value="supplies">Supplies</option>
        <option value="wanted">Wanted</option>
        </select>
        <br><br>
        Are you a vendor?: <select name="vendor" value="$vendor">
        <option value="No">No</option>
        <option value="Yes">Yes</option>
        </select>
        <br><br>
        (For Vendors) Enter link to your vendor site:<br>
         <input type="text" value="<?php echo $vendorlink;?>" name="vendorlink">
        <br><br>
        Description:
        <br>
        <textarea name="description" rows="10" cols="40"><?php echo $description;?></textarea>
        <br>
        <span class="error">*** <?php echo $descriptionErr;?></span>
        <br><br>
        Price: <input type="text" maxlength="32" value="<?php echo $price;?>" name="price">
        <span class="error">*** <?php echo $priceErr;?></span>
        <br></br>
        E-mail: <input type="text" value="<?php echo $email;?>" name="email"> 
        <span class="error">*** <?php echo $emailErr;?></span>
        <br>
        E-mail will not be displayed in the posting
        <br><br>
        City: <input type="text" maxlength="32" value="<?php echo $city;?>" name="city" >
        <span class="error">*** <?php echo $cityErr;?></span>
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
        You can upload up to three images, images are not required.<br>
        <span class="error">NOTE: Images must not be larger than 500KB.</span>  
        <br></br>
        Select image to upload:
        <input type="file" name="fileToUpload1" id="fileToUpload1">
        <br>
        Select image to upload:
        <input type="file" name="fileToUpload2" id="fileToUpload2">
        <br>
        Select image to upload:
        <input type="file" name="fileToUpload3" id="fileToUpload3">
        <br></br>
        <input type="submit" name="submit" value="Submit">
        <br><br>
        <b>When you press 'submit', your ad will be displayed for your<br>
        approval.  If you approve the posting you receive an email with </br>
        instructions to finalize your posting.</b><br>
      </form>
    </div> <!--  postform  -->

   </div> <!--  "col-lg-6"  -->
  <div class = "col-md-6">
    <div id="postformInstr">
      <h2> Instructions </h2><br>
      1. Enter item name<br>
      <br>
      2. Select category<br>
      <br>
      3. Enter a detailed description of the item.  You might want to inlude
      information such as condition, weight, perferred shipping method, shipping cost
      (if you know it), payment methods.  Anything entered here will be displayed,
      do not enter any personal information (address, phone number, etc.) unless
      you want it displayed in the  posting.<br>
      <br>
      4. Enter the price with $ in front, or negotiable, best offer, etc. If you are
      posting in the wanted category, you can leave price blank<br>
      <br>
      5. Enter the email address where you want the buyers to contact you.  
      <b>To protect your privacy, your email will not be displayed
      in the posting.</b>  Potential buyers will fillout a form with their
      contact information and message and an email will be sent to you
      with the buyers information.<br>
      <br>
      6. The city where the item is located.<br>
      <br>
      7. The state where the item is located.<br>
      <br>
      8. Browse your computer for a photo of the item.  The file size must
      be less than 500KB and only jpeg images are accepted.  You do not have
      to upload a photo, but if you are selling an item a good photo is very important.<br>
    </div>
    </div> <!--  "col-lg-6"  -->
    </div> <!--  row  -->
  <div id="footer" class="container">
  </div>

</body></html>