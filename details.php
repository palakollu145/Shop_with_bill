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
          <th>ADDRESS</th>
          <th>PINCODE</th>
          <th>PHONE_NO</th>
          <th>EMAIL_ID</th>
        </tr>
        <?php
        if(isset($_POST["all"]))
        {
        $sqlh="SELECT * FROM user_data WHERE PHONE_NO IN(SELECT DISTINCT USER_ID FROM products_data WHERE MERCH_ID =$merch_id);";
        $resh=$conn->query($sqlh);
        if($resh->num_rows>0)
        {
          while($row2 = $resh->fetch_assoc())
           {
             echo  "<tr><td>" .$row2["NAME"]."</td><td>".$row2["ADDRESS"]. "</td><td>".$row2["PINCODE"]."</td><td>".$row2["PHONE_NO"]."</td><td>".$row2["EMAIL_ID"]."</td><tr>" ;
           }
        }
       }
       if(isset($_POST["pending"]))
       {
         $sqlh="SELECT * FROM user_data WHERE PHONE_NO IN(SELECT DISTINCT USER_ID FROM products_data WHERE MERCH_ID =$merch_id AND STATUS='U');";
         $resh=$conn->query($sqlh);
         if($resh->num_rows>0)
         {
           while($row2 = $resh->fetch_assoc())
            {
              echo  "<tr><td>" .$row2["NAME"]."</td><td>".$row2["ADDRESS"]. "</td><td>".$row2["PINCODE"]."</td><td>".$row2["PHONE_NO"]."</td><td>".$row2["EMAIL_ID"]."</td><tr>" ;
            }
         }
       }
         ?>
      </table>
    </div>
    <br>
    <div class="" style="text-align: center;margin:auto;">
      <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ;?>" method="post">
        <span><input type="submit" style="background-color:pink;" name="all" value="all users"></span>
        <span><input type="submit" style="background-color:pink;" name="pending" value="pending users"></span>
      </form>
    </div>
  </body>
</html>
