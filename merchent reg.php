<?php

      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "helpify";
      $conn = new mysqli($servername, $username, $password,$dbname);
      if($conn->connect_error)
      {
        die("connection failed:" .$conn->connect_error);
      }
      $p="";
        if(isset($_POST["submitted"]))
        {
            $name=$_POST["named"];
            $storename=$_POST["snamed"];
            $storeaddress=$_POST["saddressed"];
            $pincode=$_POST["pincoded"];
            $emailid=$_POST["eided"];
            $website=$_POST["sited"];
            $phoneno=$_POST["phnod"];
            $passwordi=$_POST["passworded"];
            $sql2="SELECT * FROM merchant_data WHERE PHONE_NO='$phoneno';";
            $res2=$conn->query($sql2);
            if($res2->num_rows>0)
            {
              $p= "*already you have account please go to login";
            }
            else {

            $sql="INSERT INTO merchant_data VALUES ('$name','$storename','$storeaddress','$pincode','$phoneno','$emailid','$website','$passwordi')";
            $result=$conn->query($sql);
            $p= "*data entered please go to login";
          }

      }


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>Merchant Registration</title>
    <meta name="description" content="this is desription">
    <link rel="stylesheet" href="styles.css?VERSION=3">
  </head>
  <body class="back">
    <h1 class="head2" style="color:white;">Merchant Registration</h1>
    <div class="box">
      <div class="">
        <form class="" action="<?php echo  htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="">
            <label for="name" class="labe">Name&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:<label class="star">*</label></label>
            <input class="in" type="text" name="named" required value="">
          </div>
          <br>
          <div class="">
            <label for="name" class="labe">Store Name&nbsp&nbsp:<label class="star">*</label></label>
            <input class="in" type="text" name="snamed" value="" required>
          </div>
          <br>
          <div class="">
            <label for="name" class="labe">Store Adress:<label class="star">*</label></label>
            <input  class="in" type="text" name="saddressed" value="" required>
          </div>
          <br>
          <div class="">
            <label for="name" class="labe">Pincode&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:<label class="star">*</label></label>
            <input class="in" type="number" name="pincoded" value="" required>
          </div>
          <br>
          <div class="">
            <label for="name" class="labe">Phone no&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:<label class="star">*</label></label>
            <input class="in" type="number" name="phnod" value="" required>
          </div>
          <br>
          <div class="">
            <label for="name" class="labe">Email_ID&nbsp&nbsp&nbsp&nbsp&nbsp:<label class="star">*</label></label>
            <input class="in" type="email" name="eided" value="" required>
          </div>
          <br>
          <div class="">
            <label for="name" class="labe">Website&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp</label>
            <input class="in" type="text" name="sited" value="">
          </div>
          <br>
          <div class="">
            <label for="name" class="labe">Password&nbsp&nbsp&nbsp&nbsp&nbsp:<label class="star">*</label></label>
            <input class="in" type="password" name="passworded" value="" required>
          </div>
          <br>
          <input class="in8" type="submit" name="submitted" value="sign-up">
        </form>
        <br>
        <a href="merchent login.php">Already Registered?,sign-in</a>
      </div>
    </div>
    <div class="info">
      <h2 style="color:white;"><?php echo $p; ?></h2>
    </div>
  </body>
</html>
