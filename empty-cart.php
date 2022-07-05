<?php
    setcookie('shopping_cart', $item_data, time() - 3600);
    header('location:menu.php');
?>