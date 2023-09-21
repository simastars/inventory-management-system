<?php

if(isset($_POST['name'])){
    require_once('./includes/conn.php');
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $sql = "SELECT quantity FROM products WHERE name='$name'";
    $query = $mysqli->query($sql);
    if($query){
        $num_rows = $query->num_rows;
        if($num_rows>0){
            $row = $query->fetch_assoc();
            // echo intVal($row['quantity']);
            echo (int)$row['quantity'];
        }else{
            echo -1;
        }
    }else{
        echo -1;
    }

}
?>