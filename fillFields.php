<?php
require_once('./includes/conn.php');

if(isset($_POST['name'])){
    $name = $_POST['name'];
    $sql = "SELECT * FROM products WHERE name='$name'";
    $query = $mysqli->query($sql);
    if ($query) {
        $num_rows = $query->num_rows;
        if ($num_rows > 0) {
            $result =[];
            while ($row = $query->fetch_assoc()) {
                $result = $row;
            }
            echo json_encode($result);
        }
    }
}
?>