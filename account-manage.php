<?php
    session_start();
    if($_SESSION["user-login"] != 'true'){
    ?>
    <script>
    window.location.replace("user-login.php");
    </script>
<?php
}
    $customer_id = $_SESSION["user-id"];
    include("header2.html");
?>
<div class="container2">
    <section>
        <article>
          <?php
            require_once("connect-db.php");

            $sql = "select * from customer where customer_id = $customer_id";

            $statement1 = $db->prepare($sql);
                
            
            if($statement1->execute()){
                $account = $statement1->fetchAll();
                $statement1->closeCursor();
            }else{
                echo "Error finding customers.";
            }
    ?>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="create1">
                <h1>Update Account Information</h1>
                <?php foreach($account as $a) :?>
                Username: <br><input type="text" name="username" required value="<?php echo $a["username"];?>">
                <br><br>
                Password: <br><input type="text" name="password" required value="<?php echo $a["password"];?>">
                <br><br>
                First Name: <br><input type="text" name="first" required value="<?php echo $a["first"];?>">
                <br><br>
                Last Name: <br><input type="text" name="last" required value="<?php echo $a["last"];?>">
                <br><br>
                Address: <br><input type="text" name="addr" required value="<?php echo $a["addr"];?>">
                <br><br>
                City: <br><input type="text" name="city" required value="<?php echo $a["city"];?>">
                <br><br>
                Credit Card Information: <input type="text" name="credit_card" required value="<?php echo $a["credit_card"];?>">
                <br><br>
                Phone: <br><input type="tel" name="phone" required value="<?php echo $a["phone"];?>">
                <br><br>
                Email: <br><input type="email" name="email" required value="<?php echo $a["email"];?>">
                <br><br>
                 <input type="hidden" name="customer_id" value="<?php echo $a["customer_id"];?>">
                <?php endforeach;?>
                <button name="btn3" class="btn3" value="btn3">Update</button>
                <button class="btn3"><a class="logout-link" href="logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></button>
                </div>
            </form>
            <?php
            
            
            if(isset($_POST['btn3'])){
        function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
    require_once("connect-db.php");
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = test_input($_POST["username"]);
        $password = test_input($_POST["password"]);
        $first = test_input($_POST["first"]);
        $last = test_input($_POST["last"]);
        $addr = test_input($_POST["addr"]);
        $city = test_input($_POST["city"]);
        $credit_card = test_input($_POST["credit_card"]);
        $phone = test_input($_POST["phone"]);
        $email = test_input($_POST["email"]);

        $sql2 = "update customer
        set
        username = :username,
        password = :password,
        first = :first,
        last = :last,
        addr = :addr,
        city = :city,
        credit_card = :credit_card,
        phone = :phone,
        email = :email
        where customer_id = $customer_id";

        $statement2 = $db->prepare($sql2);
                
        $statement2->bindValue(':username', $username);
        $statement2->bindValue(':password', $password);
        $statement2->bindValue(':first', $first);
        $statement2->bindValue(':last', $last);
        $statement2->bindValue(':addr', $addr);
        $statement2->bindValue(':city', $city);
        $statement2->bindValue(':credit_card', $credit_card);
        $statement2->bindValue(':phone', $phone);
        $statement2->bindValue(':email', $email);
    }
        if($statement2->execute()){
            $statement2->closeCursor();
        ?>
        <script>
            alert("Account Successfully Updated");
        </script>
        <?php
        header("Refresh:0");
        }else{
        ?>
        <script>
            alert("Account Update Failed");
        </script>
        <?php
        }
    }
    require_once("connect-db.php");
    
    $sql3 = "select * from orders where customer_id = $customer_id";

    $statement3=$db->prepare($sql3);

    if($statement3->execute()){
        $order = $statement3->fetchAll();
        $statement3->closeCursor();
    }else{
        echo "Error fetching orders";
    }
    
    ?>
    <table class="order-table">
    <?php foreach($order as $o){ ?> 
    <tr>
        <th>Order Number</th>
        <th>Order Total</th>
        <th id="table-empty"></th>
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
        <th id="table-header">Item Quantity</th>
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

        </article>
    </section> 
    <?php
        include("footer2.html")
    ?>
</div>
</body>
</html>