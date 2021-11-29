<?php
$servername="localhost";
$username="root";
$password="";
$dbname="helpify";
$conn=new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error)
{
  die("connection error:".$conn->connect_error);
}
session_start();
if($_SESSION['merch_id'])
{
  $user_id=$_SESSION['user_idm'];
  $merch_id=$_SESSION['merch_id'];
}
else {
  header('location:who are you.php');
}
$sqlff="SELECT * FROM merchant_data WHERE PHONE_NO=$merch_id;";
$resff=$conn->query($sqlff);
if($resff->num_rows>0)
$rowff=$resff->fetch_assoc();
$sql2="SELECT * FROM products_data WHERE C_NAME=$merch_id;";
$res2=$conn->query($sql2);
if(isset($_POST["gohome"]))
{
  echo "isise";
  $sql3="UPDATE products_data SET C_NAME=NULL;";
  $res3=$conn->query($sql3);
  session_start();
  header('location:merchant_home.php');
  session_end();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>print</title>
    <meta name="description" content="this is desription">
    <link rel="stylesheet" href="styles1.css?VERSION=96">
  </head>

  <body>
    <header class="mainhead">

      <div class="prn">
        <div >
          <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ;?>" method="post">
            <input class="staw" style="background-color:pink" type="submit" name="gohome" value="go home">
          </form>
        </div>
        <div >
          <form>
            <input class="start" type="button" name="" value="print" onclick="window.print()">
          </form>
        </div>
      </div>

    </header>
    <br>
    <div class="Phead">
      <div><label class="spname" for=""><?php echo  $rowff["STORE_NAME"];?></label></div>

      <div><label for=""><?php echo  $rowff["STORE_ADDRESS"];?></label></div>
      <br>
      <div class="dateq">
        <span>
          <?php echo"DATE :", date("d/m/20y"); ?>
        </span>
        <span >
          <?php echo"MERCHANT :", $rowff["NAME"]; ?>
        </span>
      </div>
      <hr style="border-color: black;">

    </div>
    <div class="tab2">
      <table style="width:100%;">
        <tr style="border-bottom:3mm;">
          <th>PRODUCT_NAME</th>
          <th>PRICE</th>
          <th>QUANTITY</th>
          <th>TOTAL</th>
        </tr>
        <?php
        if ($res2->num_rows > 0)
        {
          while($row = $res2->fetch_assoc())
           {
            echo  "<tr><td>" .$row["P_NAME"]. "</td><td>".$row["PRICE"]. "</td><td>".$row["QUANTITY"] ."</td><td>".$row["TOTAL"] ."</td><tr>" ;
           }
        }
        $result = "SELECT SUM(TOTAL) AS value_sum FROM products_data WHERE C_NAME='$merch_id';";
        $rowz = $conn->query($result);
        $rowx = mysqli_fetch_assoc($rowz);
        $to = $rowx['value_sum'];
         ?>
      </table>

    </div>
    <div class="tf">
    TOTAL :  <label class="tFf"><?php echo $to ?></label>
    </div>

  </body>
</html>
