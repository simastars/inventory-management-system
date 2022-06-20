<?php
require_once('./includes/conn.php');
function fill_product_details($conn)
{
    $html = '';
    $option = '';
    $sql = "SELECT * FROM products";
    $query = $conn->query($sql);
    if ($query) {
        $num_rows = $query->num_rows;
        if ($num_rows > 0) {
            while ($row = $query->fetch_assoc()) {
                $option .='<option value="'.$row['name'].'">'.$row['name'].'</option>';
                
            }
            // $html .= "<tr>";
            $html .= '<tr>';
            $html .= '<td id="s_name"><select class="form-control name" name="item_name[]"><option value="">Select Product</option>'.$option.'</select></td>';
            $html .= '<td><input type="hidden" id="itemId" name="item_id[]" value=""><input type="text" id="price" name="item_price[]" class="form-control price" /></td>';
            $html .= '<td id="s_qty"><input type="text" id="quantity" name="item_qty[]" class="form-control qty" value="0" /></td>';
            $html .= '<td><input type="text" id="total" name="total" class="form-control total" /></td>';
            $html .= '<td><input type="date" id="date" name="date[]" class="form-control datePicker date" data-date data-date-format=\"dd/mm/yyyy\"/></td>';
            $html .= '<td><button class="btn btn-danger remove"><span class="glyphicon glyphicon-minus"></span></button></td>';
            $html .= '</tr>';

        //     $html .= "<td id=\"s_name\">".$result['name']."</td>";
        //   $html .= "<input type=\"hidden\" name=\"s_id\" value=\"{$result['id']}\">";
        //   $html  .= "<td>";
        //   $html  .= "<input type=\"text\" class=\"form-control\" name=\"price\" value=\"{$result['sale_price']}\">";
        //   $html  .= "</td>";
        //   $html .= "<td id=\"s_qty\">";
        //   $html .= "<input type=\"text\" id='quantity' data-qty='".$result['quantity']."' data-name='".$result['name']."' class=\"form-control\" name=\"quantity\" value=\"1\">";
        //   $html  .= "</td>";
        //   $html  .= "<td>";
        //   $html  .= "<input type=\"text\" class=\"form-control\" name=\"total\" value=\"{$result['sale_price']}\">";
        //   $html  .= "</td>";
        //   $html  .= "<td>";
        //   $html  .= "<input type=\"date\" class=\"form-control datePicker\" name=\"date\" data-date data-date-format=\"yyyy-mm-dd\">";
        //   $html  .= "</td>";
        //   $html  .= "<td>";
        //   $html  .= "<button type=\"submit\" id='addsale' disabled name=\"add_sale\" class=\"btn btn-primary\">Add sale</button>";
        //   $html  .= "</td>";
        //   $html  .= "</tr>";
        } else {
            $html .= "<h2>There is no stocks available</h2>";
        }
    } else {
        $html .= $conn->error;
    }
    return $html;
}
echo fill_product_details($mysqli);
