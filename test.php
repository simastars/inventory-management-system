<?php
require_once('./includes/conn.php');

function add_receipt_details($conn){
    // $bname =  $bname;
    // $bphone  = $bphone;
    $sql = "INSERT INTO receipts(saleId, buyerName, buyerPhone, date) VALUES(1,'name','081666','2021998')";
    $result = $conn->query($sql);
    if($result){
return mysqli_insert_id($conn);
    }else{
        return $conn->error;
    }
    
  }
  
echo add_receipt_details($mysqli);
?>