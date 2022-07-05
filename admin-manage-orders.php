<?php
 session_start();
 if($_SESSION["admin-login"] != 'true'){
 ?>
 <script>
 window.location.replace("admin-login.php");
 </script>
 <?php
}
include("header3.html") 
?>
<div class="container admin">
    <section>
        <article>
        <div class="info admin">
            <img class="lTaco key" src="images/key2.png">
            <img class="rTaco key" src="images/key2.png">   

            <?php
            require_once("connect-db.php");

            $sql = "select * from orders
            inner join customer on orders.customer_id = customer.customer_id";

    $statement=$db->prepare($sql);

    if($statement->execute()){
        $order = $statement->fetchAll();
        $statement->closeCursor();
    }else{
        echo "Error fetching orders";
    }
    
    ?>
    <button class="admin-btn1"><a class="logout-link admin top" href="admin-manage-orders.php">Manage Orders</a></button>
<button class="admin-btn1"><a class="logout-link admin top" href="admin-manage.php">Manage Menus</a></button>
    <h3 class="admin-table-header">Order Table</h3>
    <table class="order-table admin">
    <?php foreach($order as $o){ ?> 
    <tr>
        <th>Order Number</th>
        <th>Order Total</th>
        <th>User Name & ID</th>
     </tr>
        <?php
            $counter = 1;
            $order_id = $o['order_id'];
            $sql4 = "select * from menu_order
            inner join menu on menu_order.menu_id = menu.menu_id
            where order_id = $order_id";

            $statement4=$db->prepare($sql4);

            if($statement4->execute()){
                $menu = $statement4->fetchAll();
                $statement4->closeCursor();
            }else{
                echo "Error fetching menu_order";
            }
            ?>
    <tr>
        <td><?php echo $o['order_id']; ?></td>
        <td>$ <?php echo $o['total']; ?></td>
        <td><?php echo $o['first'] . " " . $o['last'] . "<br>ID: " . $o['customer_id']?></td>
    </tr>
    <tr>
        <th colspan="3" id="table-header">Item Quantity</th>
    </tr>
    
    <?php
    foreach($menu as $m){ 
        
        ?>
        <tr>
            <td id="table-item"><strong>Item <?php echo $counter?></strong></td>
            <td id="table-item2"><?php echo $m['name']; ?></td>
            <td id="table-item3"><?php echo $m['quantity']; ?></td>
        </tr>
        <?php
        $counter += 1;
    }
    }
    ?>
     </table>
        </div>
        </article>
    </section>
    <?php include("footer3.html") ?>  
</div>
</body>
</html>