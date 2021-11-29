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
  $merch_id=$_SESSION['merch_id'];
  $sql1="SELECT * FROM merchant_data WHERE PHONE_NO= '$merch_id';";
  $res1=$conn->query($sql1);
  $row1=$res1->fetch_assoc();
}
else {
  header('location:who are you.php');
}
if(isset($_POST["logout"]))
{
  session_start();
  unset($_SESSION['merch_id']);
  header('location:who are you.php');
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>merchant home</title>
    <meta name="description" content="this is desription">
    <link rel="stylesheet" href="styles1.css?VERSION=11">
  </head>
  <body >
    <header class="mainhead">
      <h2 class="texi"><?php  echo $row1["NAME"];?></h2>
      <h3 class="texi">you are welcome</h3>
      <nav>
        <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <input type="submit" name="logout" value="logout">
        </form>
      </nav>
    </header>
    <br>
    <div class="boxes">
      <div class="add">
        <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
          <h3 class="texta">create new bill</h3>
          <div class="">
            <span class="ui">user_id *:</span>
            <span> <input type="number" name="userid" value=""></span>
          </div>
          <br>
          <div class="ui">
            <span><input type="radio" name="pay" value="paid" required>paid </span>
            <span><input type="radio" name="pay" value="unpaid" required>unpaid </span>
          </div>
          <br>
          <div >
            <input class="start" type="submit" name="submit" value="start">
          </div>
        </form>
        <br>
        <span class="warn"><?php
        if(isset($_POST["submit"]))
        {
          $user_id=$_POST["userid"];
          $sqlp="SELECT * from user_data WHERE PHONE_NO='$user_id';";
          $resp=$conn->query($sqlp);
          $rowp=$resp->fetch_assoc();
          $type=$_POST["pay"];
          if($resp->num_rows>0)
          {
            if($type=="paid")
            {
              session_start();
              $_SESSION['user_idm']="$user_id";
              $_SESSION['merch_id']="$merch_id";
              header('location:paid.php');
            }
            else
            {
              session_start();
              $_SESSION['user_idm']="$user_id";
              $_SESSION['merch_id']="$merch_id";
              header('location:unpaid.php');
            }
          }
          else
          {
            echo "*no user exits";
          }

        }
         ?></span>
      </div>
      <div class="add">
        <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
          <h3 class="texta">view transactions</h3>
          <div class="">
            <span class="ui">user_id *:</span>
            <span> <input type="number" name="userid2" value=""></span>
          </div>
          <br>
          <div class="ui">
            <span><input type="radio" name="pay2" value="P" required>paid </span>
            <span><input type="radio" name="pay2" value="U" required>unpaid </span>
          </div>
          <br>
          <div >
            <input class="start" type="submit" name="submit2" value="view">
          </div>
          <br>
        </form>
        <br>
        <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
          <div class="texta" >
              <a  href="details.php" target="_blank"> get user details</a>
          </div>
        </form>
        <span class="warn"><?php
        if(isset($_POST["submit2"]))
        {
          $user_id2=$_POST["userid2"];
          $sqlp2="SELECT * from user_data WHERE PHONE_NO='$user_id2';";
          $resp2=$conn->query($sqlp2);
          $rowp2=$resp2->fetch_assoc();
          $type2=$_POST["pay2"];
          if($resp2->num_rows>0)
          {
            echo "12";
              session_start();
              $_SESSION['user_idd']="$user_id2";
              $_SESSION['merch_idd']="$merch_id";
              $_SESSION['status']="$type2";
              header('location:perdetails.php');

          }
          else
          {
            echo "*no user exits";
          }
        }

         ?></span>
      </div>
      <div class="add">
        <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
          <h3 class="texta">clear pendings</h3>
          <div class="">
            <span class="ui">user_id *:</span>
            <span> <input type="number" name="userid3" value=""></span>
          </div>
          <br>
          <br>
          <br>
          <div >
            <input class="start" type="submit" name="submit3" value="start">
          </div>
          <br>
        </form>
        <br>
        <span class="warn"><?php
        if(isset($_POST["submit3"]))
        {
          $user_id3=$_POST["userid3"];
          $sqlp3="SELECT * from user_data WHERE PHONE_NO='$user_id3';";
          $resp3=$conn->query($sqlp3);
          $rowp3=$resp3->fetch_assoc();
          if($resp3->num_rows>0)
          {

            session_start();
            $_SESSION['user_idc']="$user_id3";
            $_SESSION['merch_idc']="$merch_id";
            $_SESSION['status']="$type2";
            header('location:clearpending.php');

          }
          else
          {
            echo "*no user exits";
          }
        }

         ?></span>
      </div>
    </div>

    </body>
</html>
