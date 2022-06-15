<?php
$page_title = 'Add Sale';
require_once('includes/load.php');
require_once('./includes/conn.php');
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
        <span id="error"></span>
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
        <button class="btn btn-success btn-sm add_more"><span class="glyphicon glyphicon-plus"></span></button>
      </div>
      <div class="panel-body">
        <form method="post" action="" id="form">
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
            <tfoot id="footer"></tfoot>
          </table>
        </form>
      </div>
    </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>

<script>
  $(document).on("blur", "#quantity", function(e) {
    let name = $(".name").val()
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
        console.log("data " + data)
        if (data >= m) {
          $("#addsale").removeAttr("disabled")
          $("#msg").html("")
          $("#footer").html("<input type='submit' id='addsale' name=\"add_sale\" class=\"btn btn-primary\" value='Add sale'>")
        } else {
          $("#addsale").attr("disabled", "disbaled")
          $("#msg").html("Quantity sold is greter than the available stocks")
        }
      },
      error: function(err) {
        console.error(err)
      }
    })


  })
  $(document).on("submit", "#form", function(e) {
    e.preventDefault();
    let error = '';
    $(".name").each(function() {
      var count = 1;
      if ($(this).val() == '') {
        error += "<p>Enter Item Name at " + count + " Row";
        return false;
      }
      count = count + 1;
    })

    $(".qty").each(function() {
      let count = 1;
      if ($(this).val() == '') {
        error += "<p>Enter Units at " + count + " Row";
        return false;
      }
      count = count + 1;
    })

    $(".price").each(function() {
      let count = 1;
      if ($(this).val() == '') {
        error += "<p>Enter Item Price at " + count + " Row";
        return false;
      }
      count = count + 1;
    })

    $(".date").each(function() {
      let count = 1;
      if ($(this).val() == '') {
        error += "<p>Enter Date at " + count + " Row";
        return false;
      }
      count = count + 1;
    })

    var formData = $(this).serialize();

    if (error == '') {
      // console.log(formData)
      $.ajax({
        url: "insertSale.php",
        method: "POST",
        data: formData,
        success: function(data) {
          if (data == 'ok') {
            $("#product_info").find("tr:gt(0)").remove()
            $("#error").html('<div class="alert alert-success">Sales Details Saved</div>')
          } else {
            console.log(data)
          }
        }
      })
    } else {
      $("#error").html('<div class="alert alert-danger">' + error + '</div>')
    }

  })
  $(document).on("click", ".add_more", function() {
    $.ajax({
      url: "getProduct.php",
      method: "POST",
      type: "text",
      success: function(data) {
        $("#product_info").append(data)
      }
    })
  })

  $(document).on("change", ".name", function(e) {
    e.preventDefault();
    let name = $(this).val();
    // console.log(value)
    const that = this;
    $.ajax({
      url: "fillFields.php",
      method: "POST",
      dataType: "json",
      data: {
        name: name
      },
      success: function(data) {
        // alert(data)
        // let val = JSON.stringify(data)
        // console.log(data.quantity)
        $(that)
          .closest('tr')
          .find('input[id=price]').val(data.sale_price);
        $(that)
          .closest('tr')
          .find('input[id=total]').val(data.sale_price);
        $(that)
          .closest('tr')
          .find('input[id=itemId]').val(data.id);
        // $(that).parents().find('input[id=price]').val("yes");

      }
    })

  })

  $(document).on("click", ".remove", function() {
    $(this).closest("tr").remove();
  })


  $(document).on("blur", '#quantity', function(e) {
    const that = this;
    var price = $(that)
      .closest('tr')
      .find('input[id=price]').val() || 0;
    var qty = $(that)
      .closest('tr')
      .find('input[id=quantity]').val() || 0;
      alert(price)
    // var price = $(this).val() || 0;
    // var qty = $(this).val() || 0;
    var total = qty * price;
    $('input[id=total]').val(total.toFixed(2));
  });
</script>