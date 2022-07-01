<?php
$page_title = 'Sale Report';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
     <div id="receipt" class="table table-bordered"></div>
    <div class="panel">
      <div class="panel-heading">

      </div>
      <div class="panel-body"> 
          <form class="clearfix" method="post" action="" autocomplete="off">
          <div class="form-group">
              <label class="form-label">Phone Number</label>
                <div class="input-group">
                  <input type="text" class="form-control" name="phone" placeholder="Phone Number" id="phone">
                </div>
            </div>  
          <div class="form-group">
              <label class="form-label">Date Range</label>
                <div class="input-group">
                  <input type="text" class="datepicker form-control" name="start-date" placeholder="From" id="fromDate">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                  <input type="text" class="datepicker form-control" name="end-date" placeholder="To" id="toDate">
                </div>
            </div>
            <div class="form-group">
                 <button name="submit" class="btn btn-primary" id="print">Print Receipt</button>
            </div>
          </form>
      </div>

    </div>
  </div>

</div>
<?php include_once('layouts/footer.php'); ?>
<script>
    $(document).on("click", "#print", function(e){
      e.preventDefault();
    let phone = $("#phone").val();
    let from = $("#fromDate").val();
    let to = $("#toDate").val();
    console.log(phone+" "+from)
    $.ajax({
      url: "getReceiptByDate.php",
      method: "POST",
      type: "text",
      data:{phone:phone,from:from,to:to},
      success: function(data) {
        $("#receipt").append(data)
        console.log(data)
        var divContent = document.getElementById("receipt").innerHTML
        var oriContent = document.body.innerHTML
        document.body.innerHTML = divContent
        window.print()
        document.body.innerHTML = oriContent
        $("#receipt").html("")
      }
    })
    
  })
</script>