<?php
require_once('./includes/conn.php');

function update_product_qty($qty,$p_id,$conn){
    $qty = (int) $qty;
    $id  = (int)$p_id;
    $sql = "UPDATE products SET quantity=quantity -'$qty' WHERE id = '$id'";
    $result = $conn->query($sql);
    // return($conn->affected_rows() === 1 ? true : false);

  }
  function add_receipt_details($sid, $bname, $bphone, $date, $conn){
    $bname =  $bname;
    $bphone  = $bphone;
    $sql = "INSERT INTO receipts(saleId, buyerName, buyerPhone, date) VALUES('$sid','$bname','$bphone','$date')";
    $result = $conn->query($sql);
  }
if (isset($_POST['item_name'])) {
    $result = 0;
    for ($count = 0; $count < count($_POST['item_name']); $count++) {
        $sql = "INSERT INTO sales(product_id, qty,price,date) VALUES(?,?,?,?)";
        // :item_id, :item_qty, :item_price, :date
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param(
            "ssss",
            $_POST['item_id'][$count],
            $_POST['item_qty'][$count],
            $_POST['item_price'][$count],
            $_POST['date'][$count]
        );
        $stmt->execute();
        $result = $stmt->store_result();
        $qty = $_POST['item_qty'][$count];
        $p_id = $_POST['item_id'][$count];
        update_product_qty($qty,$p_id, $mysqli);
        
        
    }
        if ($result > 0) {
            echo "ok";
        } else {
            echo $mysqli->error;
        }
} else {
    echo "kkk";
}
