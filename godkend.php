<?php
if (!isset($_SESSION)) session_start();
require_once('connection/conn.php');
$orderid = $_SESSION['order_id'];
var_dump($_POST);
if(isset($_POST['orderapproved']))
{
    print_r($_POST);
    //INDSÆTTER DATO TIL HVORNÅR ORDREN BLEV GODKENDT.
     $order_approveddate = date("Y-m-d");

     $sqlapproved = "UPDATE psv2_orders SET order_approved = '$order_approveddate' WHERE id = '$orderid'";
     $resultapproved = mysqli_query($dbCon,$sqlapproved);

     $sqlsetrejectednull = "UPDATE psv2_orders SET order_rejected = NULL WHERE id = '$orderid'";
     $resultsetrejectednull = mysqli_query($dbCon,$sqlsetrejectednull);

     $statustekst = "Samtlige produktbilleder er godkendt den" . " " . date("Y-m-d");
     $farve = "success";


}

?>