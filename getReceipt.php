<?php
require_once("./includes/conn.php");
if (isset($_POST['phone'])) {
$bname = $_POST['name'];
$phone = $_POST['phone'];
$date = $_POST['date'];

$receipt = '';
function get_receipt($conn, $bname, $phone, $date, $receipt)
{
  $receipt .= '<div>
        <h4 style="display: inline-block;">Buyer Name: </h4><span>'.$bname.'</span>
        <h4 style="display: inline-block;">Phone Number:</h4><span>'.$phone.'</span>
    
        <table class="table table-stripped table-bordered"> 
          <thead>
            <div class="col-md-3">
              <th>Name</th>
              <th>Quantity</th>
              <th>Price</th>
            </div>
          </thead>
          <tbody>';

  $sql = "SELECT p.name,r.buyerName,r.buyerPhone,r.date,s.price FROM sales s,receipts r,products p WHERE (r.saleId=s.id AND s.product_id=p.id) AND (r.buyerPhone='$phone' AND r.date='$date')";
  // $sql = "SELECT s.id,s.qty,s.price,r.saleId,r.buyerPhone,r.date,p.name FROM sales s LEFT JOIN receipts r ON r.saleId=s.id RIGHT JOIN products p ON p.id=s.product_id WHERE r.date='$date' AND r.buyerPhone='$bphone'";
  $result = $conn->query($sql);
  if ($result) {
    $num_rows = $result->num_rows;
    if ($num_rows > 0) {
      // $res = $result->fetch_all();
      // var_dump($res);
      for ($i = 0; $i < $num_rows; $i++) {
        $row = $result->fetch_assoc();
        $receipt .= '
                <tr>
                  <td>' . $row["name"] . '</td>
                  <td class="qty">' . $row["qty"] . '</td>
                  <td class="price">' . $row["price"] . '</td>
                </tr>';
      }
      echo $receipt;
    } else {
      echo "no products found";
    }
  } else {
    echo $conn->error;
  }
}
function get_total($conn, $phone, $date, $receipt)
{
  $sql = "SELECT *, SUM(sales.qty*sales.price) AS total FROM sales LEFT JOIN receipts ON sales.id=receipts.saleId WHERE receipts.buyerPhone='$phone' AND receipts.date='$date'";
  // $sql = "SELECT s.id,s.qty,s.price,r.saleId,r.buyerPhone,r.date,p.name FROM sales s LEFT JOIN receipts r ON r.saleId=s.id RIGHT JOIN products p ON p.id=s.product_id WHERE r.date='2022-06-13' AND r.buyerPhone='141'";
  $result = $conn->query($sql);
  if ($result) {
    $num_rows = $result->num_rows;
    if ($num_rows > 0) {
      $row = $result->fetch_assoc();
      $receipt .= '</tbody>
  <tfoot>
    <tr>
      <td colspan="2"><strong>Total</strong></td>
      <td><strong>' . $row["total"] . '</strong></td>
    </tr>
  </tfoot>
</table>
</div>';
    }else{
      echo "no rows";
    }
  }else{
    echo $conn->error;
  }
  
  echo $receipt;
  
}
get_receipt($mysqli, $bname, $phone, $date, $receipt);
get_total($mysqli, $phone, $date, $receipt);
}