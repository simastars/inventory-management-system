<?php
$page_title = 'Add Sale';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3);
?>
<?php

if (isset($_POST['add_sale'])) {
  $req_fields = array('s_id', 'quantity', 'price', 'total', 'date');
  validate_fields($req_fields);
  if (empty($errors)) {
    $p_id      = $db->escape((int)$_POST['s_id']);
    $s_qty     = $db->escape((int)$_POST['quantity']);
    $s_total   = $db->escape($_POST['total']);
    $date      = $db->escape($_POST['date']);
    $s_date    = make_date();

    $sql  = "INSERT INTO sales (";
    $sql .= " product_id,qty,price,date";
    $sql .= ") VALUES (";
    $sql .= "'{$p_id}','{$s_qty}','{$s_total}','{$s_date}'";
    $sql .= ")";

    if ($db->query($sql)) {
      update_product_qty($s_qty, $p_id);
      $session->msg('s', "Sale added. ");
      redirect('add_sale.php', false);
    } else {
      $session->msg('d', ' Sorry failed to add!');
      redirect('add_sale.php', false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('add_sale.php', false);
  }
}

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
    <form method="post" action="ajax.php" autocomplete="off" id="sug-form">
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-btn">
            <button type="submit" class="btn btn-primary">Find It</button>
          </span>
          <input type="text" id="sug_input" class="form-control" name="title" placeholder="Search for product name">
        </div>
        <div id="result" class="list-group"></div>
        <div id="msg" class="text-danger" role="alert"></div>

      </div>
    </form>
  </div>
</div>
<div class="row">

  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Sale Eidt</span>
        </strong>
        <button class="btn btn-success">Add More</button>
      </div>
      <div class="panel-body">
        <form method="post" action="add_sale.php">
          <table class="table table-bordered">
            <thead>
              <th> Item </th>
              <th> Price </th>
              <th> Qty </th>
              <th> Total </th>
              <th> Date</th>
              <th> Action</th>
            </thead>
            <tbody id="product_info"> </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>

<script>
  $(document).on("blur", "#quantity", function(e) {
    // let qty = e.target.value;
    let name = e.target.getAttribute("data-name")
    // let qauntity = e.target.getAttribute("data-qty")
    let m = Number($(this).val())
  
    $.ajax({
      url: "checkPQty.php",
      type: "text",
      method: "post",
      data: {
        name: name
      },
      beforeSend: () => {

      },
      success: function(data) {
        data = Number(data)
        if(data>=m){
          $("#addsale").removeAttr("disabled")
          $("#msg").html("")
        }else{
          $("#addsale").attr("disabled", "disbaled")
          $("#msg").html("Quantity sold is greter than the available stocks")
        }
      },
      error: function(err) {
        console.error(err)
      }
    })


  })
</script>