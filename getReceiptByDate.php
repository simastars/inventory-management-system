<?php
require_once("./includes/conn.php");
if (isset($_POST['phone'])) {

  $phone = mysqli_real_escape_string($mysqli,$_POST['phone']);
  $start_date = mysqli_real_escape_string($mysqli,$_POST['from']);
  $end_date = mysqli_real_escape_string($mysqli,$_POST['to']);
 
  $receipt = '';
  function get_receipt($conn, $phone, $start_date, $end_date, $receipt)
  {
    // $sql = "SELECT * FROM sales,receipts,products WHERE receipts.saleId=sales.id AND (receipts.buyerPhone='$bphone' AND receipts.date='$date')";
    $sql = "SELECT * FROM sales,receipts,products WHERE (receipts.saleId=sales.id AND products.id=sales.product_id) AND (receipts.buyerPhone='$phone' AND receipts.date BETWEEN '$start_date' AND '$end_date')
  ";
    $result = $conn->query($sql);
    if ($result) {
      $num_rows = $result->num_rows;
      $row = $result->fetch_assoc();
      $receipt .= '<div>
        <h4 style="display: inline-block;">Buyer Name: </h4><span>' . $row["buyerName"] . '</span>
        <h4 style="display: inline-block;">Phone Number:</h4><span>' . $row["buyerPhone"] . '</span>
    
        <table class="table table-stripped table-bordered"> 
          <thead>
            <div class="col-md-3">
              <th>Name</th>
              <th>Quantity</th>
              <th>Price</th>
            </div>
          </thead>
          <tbody>';
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
  function get_total($conn, $phone, $start_date, $end_date, $receipt)
  {
    $sql = "SELECT *, SUM(sales.qty*sales.price) AS total FROM sales,receipts,products WHERE (receipts.saleId=sales.id AND products.id=sales.product_id) AND (receipts.buyerPhone='$phone' AND receipts.date BETWEEN '$start_date' AND '$end_date')";
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
        echo $receipt;
      } else {
        echo "no rows";
      }
    } else {
      echo $conn->error;
    }
  }
  get_receipt($mysqli, $phone, $start_date, $end_date, $receipt);
  get_total($mysqli, $phone, $start_date, $end_date, $receipt);
}
