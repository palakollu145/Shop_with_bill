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
  header('location:merchent login.php');
}


if (isset($_POST["comp"]))
{
  session_start();
  $_SESSION['user_idm']="$user_id";
  $_SESSION['merch_id']="$merch_id";
  header('location:printpaid.php');
}
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>paid</title>
    <meta name="description" content="this is desription">
    <link rel="stylesheet" href="styles1.css?VERSION=71">
  </head>
  <body >
    <header class="mainhead">
      <h3>Start Adding Products</h3>
    </header>
    <br>
    <div class="boxes">
      <div class="add1">
        <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ;?>" method="post">
            <div class="pn">
              <label for=""  >Product name *: </label> <input type="text" name="p_n" value="" required>
            </div>
            <br>
            <div class="">
              <label for="" class="q" >Price *&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:  </label><input  type="number" name="price" value="" required>
            </div>
            <br>
            <div class="">
              <label for="" class="q">quantity *&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: </label><input type="number" name="qt" value="" required>
            </div>
            <br>
            <div class="">
            <input class="start" type="submit" name="add" value="add">
            </div>
            <br>
        </form>
        <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ;?>" method="post">
            <div class="">
              <input class="start" type="submit" name="comp" value="finish">
            </div>
        </form>
      </div>
    </div>
    <br>
    <div class="delll">
      <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ;?>" method="post">
          <span class="pn">
            <label for=""  >Product name *: </label> <input type="text" name="pdel" value="" required>
          </span>
          <span class="">
          <input style="background-color:pink" type="submit" name="del" value="delete">
          </span>
      </form>
    </div>
    <br>
    <div class="heading">
      <h2 class="al">Product in transaction are shown below</h2>
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
        $to=0;
        if(isset($_POST["add"]))
        {
          $p_n=$_POST["p_n"];
          $p_r=$_POST["price"];
          $q_t=$_POST["qt"];
          $dt=date("y-m-d");
          $st="P";
          $tot=$q_t*$p_r;
          $ts=date("H:i:s");
          $sqla="SELECT P_NAME FROM products_data WHERE P_NAME='$p_n' AND C_NAME=$merch_id;";
          $resa=$conn->query($sqla);
          if($resa->num_rows<=0)
          {
            $sql1="INSERT INTO products_data VALUES ('$merch_id','$user_id','$p_n','$p_r','$q_t','$tot','$st','$merch_id','$dt','$ts');";
            $res1=$conn->query($sql1);
            $sql2="SELECT * FROM products_data WHERE C_NAME=$merch_id;";
            $res2=$conn->query($sql2);
            if ($res2->num_rows > 0)
            {
              while($row = $res2->fetch_assoc())
               {
                echo  "<tr><td>" .$row["P_NAME"]. "</td><td>".$row["PRICE"]. "</td><td>".$row["QUANTITY"] ."</td><td>".$row["TOTAL"] ."</td><tr>" ;
               }
            }
          }
          else
          {
            $sql2="SELECT * FROM products_data WHERE C_NAME=$merch_id;";
            $res2=$conn->query($sql2);
            if ($res2->num_rows > 0)
            {
              while($row = $res2->fetch_assoc())
               {
                echo  "<tr><td>" .$row["P_NAME"]. "</td><td>".$row["PRICE"]. "</td><td>".$row["QUANTITY"] ."</td><td>".$row["TOTAL"] ."</td><tr>" ;
               }
            }

          }
              $result = "SELECT SUM(TOTAL) AS value_sum FROM products_data WHERE C_NAME='$merch_id';";
          $rowz = $conn->query($result);
          $rowx = mysqli_fetch_assoc($rowz);
          $to = $rowx['value_sum'];

        }
        if(isset($_POST["del"]))
        {
          $p_del=$_POST["pdel"];
          $sqla="SELECT P_NAME FROM products_data WHERE P_NAME='$p_del' AND C_NAME=$merch_id;";
          $resa=$conn->query($sqla);
          if($resa->num_rows>0)
          {
            $sqld="DELETE FROM products_data WHERE P_NAME='$p_del';";
            $resd=$conn->query($sqld);
          }
          $sql2="SELECT * FROM products_data WHERE C_NAME=$merch_id;";
          $res2=$conn->query($sql2);
          if ($res2->num_rows > 0)
          {
            while($row = $res2->fetch_assoc())
             {
              echo  "<tr><td>" .$row["P_NAME"]. "</td><td>".$row["PRICE"]. "</td><td>".$row["QUANTITY"] ."</td><td>".$row["TOTAL"] ."</td><tr>" ;
             }
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
