<?php
require_once('./includes/conn.php');

function update_product_qty($qty, $p_id, $conn)
{
  $qty = (int) $qty;
  $id  = (int)$p_id;
  $sql = "UPDATE products SET quantity=quantity -'$qty' WHERE id = '$id'";
  $result = $conn->query($sql);
  // return($conn->affected_rows() === 1 ? true : false);
}

function delete_product($conn)
{

  $sql = "DELETE FROM products WHERE quantity=0";
  $result = $conn->query($sql);
}

function add_receipt_details($sid, $bname, $bphone, $date, $conn)
{
  $sql = "INSERT INTO receipts(saleId, buyerName, buyerPhone, date) VALUES($sid,'$bname','$bphone','$date')";
  $result = $conn->query($sql);
}
if (isset($_POST['item_name'])) {

  $bname = $_POST['bname'];
  $bphone = $_POST['bphone'];
  $result = 0;
  for ($count = 0; $count < count($_POST['item_name']); $count++) {
    $sql = "INSERT INTO sales(product_id, qty,price,date) VALUES(?,?,?,?)";
  
    $item_name = $_POST['item_name'][$count];
    $item_id = $_POST['item_id'][$count];
    $item_qty = $_POST['item_qty'][$count];
    $item_price = $_POST['item_price'][$count];
    $item_date = $_POST['date'][$count];
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param(
      "ssss",
      $item_id,
      $item_qty,
      $item_price,
      $item_date
    );
    $stmt->execute();
    $i_id = mysqli_insert_id($mysqli);
    $date = $_POST['date'][$count];
    add_receipt_details($i_id, $bname, $bphone, $date, $mysqli);

    $result = $stmt->store_result();
    $qty = $_POST['item_qty'][$count];
    $p_id = $_POST['item_id'][$count];
    update_product_qty($qty, $p_id, $mysqli);
    delete_product($mysqli);
  }
  

  if ($result > 0) {
    echo "ok";
  } else {
    echo $mysqli->error;
  }
} else {
  echo "kkk";
}
