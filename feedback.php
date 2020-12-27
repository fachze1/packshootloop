<?php
if (!isset($_SESSION)) session_start();
require_once('connection/conn.php');
$orderid = $_SESSION['order_id'];

if(strlen(trim($_POST['orderrejectcomment']))) {
    print_r($_POST);
    //INDSÆTTER DATO FOR HVORNÅR ORDREN BLEV AFVIST.
    $order_rejectdate = date("Y-m-d");
    $sqlrejected = "UPDATE psv2_orders SET order_rejected = '$order_rejectdate' WHERE id = '$orderid'";
    $resultrejected = mysqli_query($dbCon,$sqlrejected);
    
    //SIKRER ORDRER IKKE ER GODKENDT SAMTIDIG.
    $sqlsettapprovednull = "UPDATE psv2_orders SET order_approved = NULL WHERE id = '$orderid'";
    $resultsetapprovednull = mysqli_query($dbCon,$sqlsettapprovednull);
    
    //INDSÆTTER KOMMENTAREN VED STYLE_1
    $orderreject_comment = $_POST['orderrejectcomment'];

    //henter hvilken styles der skal afvises, og hvor kommentaren skal placeres.
    $order_style1 = $_POST['style_1_line'];
    $sqlsetorderlinescomment = "UPDATE psv2_orders_lines SET orderrejectcomment = '$orderreject_comment' WHERE style_1 = '$order_style1'";
    $resultsetordercomment = mysqli_query($dbCon,$sqlsetorderlinescomment);

}
?>