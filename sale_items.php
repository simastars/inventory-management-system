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
        </div>
        <div id="result" class="list-group"></div>
        <div id="msg" class="text-danger" role="alert"></div>
        <div id="receipt"></div>
        <span id="error"></span>
        <div id="info"></div>
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
          <span>Sale Edit</span>
        </strong>
        <button class="btn btn-success btn-sm add_more"><span class="glyphicon glyphicon-plus"></span></button>
      </div>
      <div class="panel-body">
        <form method="post" action="" id="form">
          <label>Buyer Name:<input type="text" name="bname" class="form-control bname" placeholder="Name" /></label>
          <label>Buyer Phone No:<input type="text" name="bphone" class="form-control bphone" placeholder="Phone Number" /></label>
          <table class="table table-bordered" id="product_table">
            <tr>
              <th> Item </th>
              <th> Price </th>
              <th> Qty </th>
              <th> Total </th>
              <th> Date</th>
              <th> Action</th>
            </tr>
            <tbody id="product_info"> </tbody>
            <tfoot id="footer"><br><br /></tfoot>
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
      beforeSend: () => {},
      success: function(data) {
        data = Number(data)
        // console.log("data " + data)
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
    let bname = $(".bname").val();
    let bphone = $(".bphone").val();
    if (bname == '') {
      error += "Buyer name cannot be empty";
    }
    if (bphone == '') {
      error += "Buyer phone cannot be empty";
    }
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

    var formData = $(this).serializeArray();
    
    $("#info").html('<input type="hidden" id="name" value="'+formData[0]['value']+'">');
    $("#info").append('<input type="hidden" id="phone" value="'+formData[1]['value']+'">');
    $("#info").append('<input type="hidden" id="date" value="'+formData[7]['value']+'">');
    if (error == '') {
      console.log(formData)
      $.ajax({
        url: "insertSale.php",
        method: "POST",
        data: formData,
        success: function(data) {
          if (data == 'ok') {
            $("#product_table").find("tr:gt(0)").remove();
            $("#addsale").remove()
            $("#error").html('<div class="alert alert-success">Sales Details Saved</div>')
            $("#receipt").html("<button class='btn btn-success print'>Print Receipt</button>")
            console.log(formData)
          } else {
            console.log(data)
          }
        }
      })
    } else {
      $("#error").html('<div class="alert alert-danger">' + error + '</div>')
    }

  })
  $(document).on("click", ".print", function(){
    let phone = $("#phone").val();
    let name = $("#name").val();
    let date = $("#date").val();
    $.ajax({
      url: "getReceipt.php",
      method: "POST",
      type: "text",
      data:{phone:phone,date:date},
      success: function(data) {
        $("#receipt").append(data)
        var divContent = document.getElementById("receipt").innerHTML
        var oriContent = document.body.innerHTML
        document.body.style.width="150px"
        document.body.innerHTML = divContent
        window.print()
        document.body.style.width="100%"
        document.body.innerHTML = oriContent
        $("#receipt").html("")
      }
    })
    
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
    const that = this;
    $.ajax({
      url: "fillFields.php",
      method: "POST",
      dataType: "json",
      data: {
        name: name
      },
      success: function(data) {
        $(that)
          .closest('tr')
          .find('input[id=price]').val(data.sale_price);
        $(that)
          .closest('tr')
          .find('input[id=total]').val(data.sale_price);
        $(that)
          .closest('tr')
          .find('input[id=itemId]').val(data.id);
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

    var total = qty * price;
    $(that)
      .closest('tr')
      .find('input[id=total]').val(total.toFixed(2));
  });
</script>