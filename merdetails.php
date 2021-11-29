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
session_start();
if($_SESSION['user_id'])
{
    $user_id=$_SESSION['user_id'];

}
else {
    header('location:who are you.php');
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>details of users</title>
    <meta name="description" content="this is desription">
    <link rel="stylesheet" href="styles1.css?VERSION=1">
  </head>
  <body>
    <br>
    <div class="tab2" style="max-width:25cm;">
      <table style="width:100%;">
        <tr style="background-color:	rgba(144,238,144,0.7);">
          <th>NAME</th>
          <th>STORE_NAME</th>
          <th>ADDRESS</th>
          <th>PINCODE</th>
          <th>PHONE_NO</th>
          <th>EMAIL_ID</th>
        </tr>
        <?php
        if(isset($_POST["all"]))
        {
        $sqlh="SELECT * FROM merchant_data ;";
        $resh=$conn->query($sqlh);
        if($resh->num_rows>0)
        {
          while($row2 = $resh->fetch_assoc())
           {
             echo  "<tr><td>" .$row2["NAME"]."</td><td>".$row2["STORE_NAME"]. "</td><td>".$row2["STORE_ADDRESS"]. "</td><td>".$row2["PINCODE"]."</td><td>".$row2["PHONE_NO"]."</td><td>".$row2["EMAIL_ID"]."</td><tr>" ;
           }
        }
       }
       if(isset($_POST["your"]))
       {
       $sqlh="SELECT * FROM merchant_data WHERE PHONE_NO IN (SELECT DISTINCT MERCH_ID FROM products_data WHERE USER_ID='$user_id');";
         $resh=$conn->query($sqlh);
         if($resh->num_rows>0)
         {
           while($row2 = $resh->fetch_assoc())
            {
              echo  "<tr><td>" .$row2["NAME"]."</td><td>".$row2["STORE_NAME"]. "</td><td>".$row2["STORE_ADDRESS"]. "</td><td>".$row2["PINCODE"]."</td><td>".$row2["PHONE_NO"]."</td><td>".$row2["EMAIL_ID"]."</td><tr>" ;
            }
         }
       }
       if(isset($_POST["nearby"]))
       {
       $sqlh="SELECT * FROM merchant_data WHERE PINCODE=(SELECT PINCODE FROM user_data WHERE PHONE_NO=$user_id) ;";
       $resh=$conn->query($sqlh);
       if($resh->num_rows>0)
       {
         while($row2 = $resh->fetch_assoc())
          {
            echo  "<tr><td>" .$row2["NAME"]."</td><td>".$row2["STORE_NAME"]. "</td><td>".$row2["STORE_ADDRESS"]. "</td><td>".$row2["PINCODE"]."</td><td>".$row2["PHONE_NO"]."</td><td>".$row2["EMAIL_ID"]."</td><tr>" ;
          }
       }
      }
      if(isset($_POST["pins"]))
      {
        $pins=$_POST["pin"];
      $sqlh="SELECT * FROM merchant_data WHERE PINCODE='$pins' ;";
      $resh=$conn->query($sqlh);
      if($resh->num_rows>0)
      {
        while($row2 = $resh->fetch_assoc())
         {
           echo  "<tr><td>" .$row2["NAME"]."</td><td>".$row2["STORE_NAME"]. "</td><td>".$row2["STORE_ADDRESS"]. "</td><td>".$row2["PINCODE"]."</td><td>".$row2["PHONE_NO"]."</td><td>".$row2["EMAIL_ID"]."</td><tr>" ;
         }
      }
     }
         ?>
      </table>
    </div>
    <br>
    <div class="" style="text-align: center;margin:auto;">
      <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ;?>" method="post">
        <span><input type="submit" style="background-color:pink;" name="all" value="all"></span>
        <span><input type="submit" style="background-color:pink;" name="your" value="your merchants"></span>
        <span><input type="submit" style="background-color:pink;" name="nearby" value="nearby merchants"></span>
      </form>
    </div>
    <br>
    <div class="" style="text-align: center;margin:auto;">
      <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ;?>" method="post">
        <span><input type="number" style="background-color:lightyellow;" name="pin" value="" required></span>
        <span><input type="submit" style="background-color:lightgreen;" name="pins" value="get merchants through pin code"></span>
      </form>
    </div>
  </body>
</html>
