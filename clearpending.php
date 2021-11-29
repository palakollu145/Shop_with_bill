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
if($_SESSION['merch_id'])
{
  $merch_id= $_SESSION['merch_idc'];
  $user_id=$_SESSION['user_idc'];
  $type="U";
  $sqlu="SELECT * FROM user_data WHERE PHONE_NO= '$user_id';";
  $resu=$conn->query($sqlu);
  $rowu=$resu->fetch_assoc();
}
else {
    header('location:who are you.php');
}
if(isset($_POST["gh"]))
{
  session_start();
  header('location:merchant_home.php');
}
$note="";
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>clear pendings</title>
     <meta name="description" content="this is desription">
     <link rel="stylesheet" href="styles1.css?VERSION=584">
   </head>
   <body>
     <header class="mainhead">
        <h3 class="texi">Here you can clear  transactions of <?php  echo $rowu["NAME"];?></h3>
        <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
          <input type="submit" name="gh" value="go_home">
        </form>

        <br>
     </header>
     <br>
     <div class="tab2">
       <table style="width:100%;">
         <tr style="border-bottom:3mm;">
           <th>DATE</th>
           <th>NO_OF_PRODUCTS</th>
           <th>AMOUNT</th>
         </tr>
         <?php
          $to=0;
          $result = "SELECT DATE,COUNT(QUANTITY) AS count_val,SUM(TOTAL) AS am_val FROM products_data WHERE MERCH_ID='$merch_id' AND USER_ID='$user_id' AND STATUS='U' GROUP BY DATE;";
         $rowz = $conn->query($result);
         if ($rowz->num_rows > 0)
         {
           while($row = $rowz->fetch_assoc())
            {
             echo  "<tr><td>" .$row["DATE"]. "</td><td>".$row["count_val"]."</td><td>".$row["am_val"] . "</td></tr>" ;
            }
         }
         $resultp = "SELECT SUM(TOTAL) AS value_sum FROM products_data WHERE MERCH_ID='$merch_id'AND USER_ID='$user_id' AND STATUS='U';";
         $rowzp = $conn->query($resultp);
         $rowxp = mysqli_fetch_assoc($rowzp);
         $to = $rowxp['value_sum'];
          ?>
       </table>

     </div>
   </div>
   <div class="tf">
   TOTAL :  <label class="tFf"><?php echo $to ?></label>
   </div>
   <br>
   <div class="filters">
     <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
       <span >
         <input class="idate" type="date" name="idate"  value="">
       </span>
       <span style="color:white;" >
         <input class="dsub" type="checkbox" name="dsub2" value="clear"> Clear
       </span>
       <span >
         <input class="dsub" type="submit" name="dsub" value="submit">
       </span>

     </form>
   </div>

   <div class="cleardetails">
     <div class="tab2">
       <table style="width:100%;">
         <tr style="border-bottom:3mm;">
           <th>PRODUCT_NAME</th>
           <th>PRICE</th>
           <th>QUANTITY</th>
           <th>TOTAL</th>
           <th>TIME</th>
         </tr>
         <?php
          $tof=0;
          $note2="";
          if(isset($_POST["dsub"]))
          {
            $idate=$_POST["idate"];
            $newDate = date("Y-m-d", strtotime($idate));
            $note= "select same date and click checkbox and click submit to clear this pending with date :";
            $note2=$newDate;
            $sql22="SELECT * FROM products_data WHERE MERCH_ID='$merch_id'AND USER_ID='$user_id' AND STATUS='U' AND DATE= '$newDate' ORDER BY TIME;";
            $res22=$conn->query($sql22);
            if ($res22->num_rows > 0)
            {

              while($row22 = $res22->fetch_assoc())
               {
                echo  "<tr><td>" .$row22["P_NAME"]. "</td><td>".$row22["PRICE"]. "</td><td>".$row22["QUANTITY"] ."</td><td>".$row22["TOTAL"] ."</td><td>".$row22["TIME"] ."</td><tr>" ;
               }
            }
            $resultpf = "SELECT SUM(TOTAL) AS val FROM products_data WHERE MERCH_ID='$merch_id'AND USER_ID='$user_id' AND STATUS='U' AND DATE= '$newDate';";
            $rowzpf = $conn->query($resultpf);
            $rowxpf = mysqli_fetch_assoc($rowzpf);
            $tof = $rowxpf['val'];
            if(isset($_POST["dsub2"]))
            {
              $sql23="UPDATE products_data SET STATUS ='P' WHERE MERCH_ID='$merch_id' AND USER_ID='$user_id' AND STATUS='U' AND DATE= '$newDate' ;";
              $res23=$conn->query($sql23);
            }
          }

          ?>
       </table>
     </div>
     <div class="tf">
     TOTAL :  <label class="tFf"><?php echo $tof ?></label>
     </div>
     <br>
     <div class="tgg">
       <h4><?php echo $note ,$note2; ?></h4>
     </div>
     <br>
   </div>

   </body>
 </html>
