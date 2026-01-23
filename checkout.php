<?php

require '../../config/database.php';
require '../../config/helpers.php';
require '../../session_check.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart = json_decode($_POST['cart_data'], true);
    $promo_type = isset($_POST['promo_type']) ? $_POST['promo_type'] : null;
    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += $item['price'] * (isset($item['qty']) ? $item['qty'] : 1);
    }
    $discount = calculate_discount($cart, $promo_type);
    $final_total = $subtotal - $discount;

    // Insert Header
    $total_before = 0;
    foreach ($cart as $item) {
        $total_before += $item['price'] * (isset($item['qty']) ? $item['qty'] : 1);
    }
    
    mysqli_query($conn, "INSERT INTO orders (customer_name, total_before_discount, discount_amount, final_total, discount, promo_type) 
    VALUES ('WALK_IN_CUSTOMER', '$total_before', '$discount', '$final_total', '$discount', '$promo_type')");
    $order_id = mysqli_insert_id($conn);

    // Insert Details & Stock Update
    foreach ($cart as $item) {
        $pid = $item['id'];
        $qty = isset($item['qty']) ? $item['qty'] : 1;
        mysqli_query($conn, "INSERT INTO order_details (order_id, product_id, qty, subtotal) VALUES ('$order_id', '$pid', '$qty', '".$item['price']."')");
        mysqli_query($conn, "UPDATE products SET stock = stock - $qty WHERE id = '$pid'");
    }
    header("Location: checkout_success.php?order_id=$order_id");
}
?>
