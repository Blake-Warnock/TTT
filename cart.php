<?php
session_start();
$added = "false";
if($_SESSION["user-login"] != 'true'){
?>
<script>
window.location.replace("user-login.php");
</script>
<?php
}
$customer_id = $_SESSION["user-id"];
// checks if the remove action is pressed through seeing if the action is delete. If it is decode cart_data and delete the item where the item_id
if(isset($_GET['action'])){
    if($_GET['action'] == "delete"){
      $cookie_data = stripslashes($_COOKIE['shopping_cart']);
      $cart_data = json_decode($cookie_data, true);
      foreach($cart_data as $keys => $values){
        if($cart_data[$keys]['item_id'] == $_GET["id"]){
          unset($cart_data[$keys]);
          $item_data = json_encode($cart_data);
          setcookie('shopping_cart', $item_data, time() + (86400 * 30));
          header("location:menu.php?remove=1");
        }
      }
    }
  }
 


 include("header1.html") 
 ?>
<div class="container menu">
    <section>
        <article>
        <div class="info">
            <img class="lTaco" src="images/taco.png">
            <img class="rTaco" src="images/taco.png">
            <br><br>
            <h3 class="menu-title">Order Details</h3>
            <?php// echo $customer_id ?>
            <table class="menu-table">
          <tr>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
            <th>Action</th>
          </tr>
          <?php
          //if shopping cart is set decode cart_data and display it. If not show that there is not items.
          if(isset($_COOKIE['shopping_cart'])){
            $total = 0;
              $cookie_data = stripslashes($_COOKIE["shopping_cart"]);
              $cart_data = json_decode($cookie_data, true);
              foreach($cart_data as $keys => $values){ 
              ?>
                <tr>
                  <td><?php echo $values['item_name']; ?></td>
                  <td><?php echo $values['item_quantity']; ?></td>
                  <td>$ <?php echo $values['item_price']; ?></td>
                  <td>$ <?php echo number_format($values['item_quantity'] * $values['item_price'], 2);?></td>
                  <td><a id="remove" href="menu.php?action=delete&id=<?php echo $values["item_id"]; ?>">Remove</a></td>
                </tr>

              <?php
                $total = $total + ($values['item_quantity'] * $values['item_price']);
              }
              ?>
              <tr>
                <form action="cart.php" method="post">
                <td colspan='2'><button type="submit" class="btn2" name="btnSub" value="btnSub">Confirm Purchase</button></td>
                <td>Total</td>
                <td id="total">$ <?php echo number_format($total, 2); ?></td>
                <td id="empty"><button class="btnEmpty"><a href="empty-cart.php" onclick="return confirm('Are you sure you want to delete?\nThis can not be undone')">Empty Cart</a></button></td>
                </form>
              </tr>
              <?php

              if(isset($_POST['btnSub'])){

              require_once("connect-db.php");

              $sql2 = "insert into orders
              (customer_id, total) 
              Values
              (:customer_id, :total)";

              $statement2 = $db->prepare($sql2);

              $statement2->bindValue(':customer_id', $customer_id);
              $statement2->bindValue(':total', $total);

              if($statement2->execute()){
                $statement2->closeCursor();
                $previous_id = $db->lastInsertId();
                echo 'Last Insert ID: '.$previous_id;
               

                  $cookie_data = stripslashes($_COOKIE["shopping_cart"]);
                  $cart_data = json_decode($cookie_data, true);
                  foreach($cart_data as $keys => $values){ 

                  $menu_id =  $values["item_id"];
                  $quantity = $values['item_quantity'];

                  $sql4 = "insert into menu_order
                  (order_id, menu_id, quantity)
                  VALUES
                  (:order_id, :menu_id, :quantity)";

                  $statement4 = $db->prepare($sql4);

                  $statement4->bindValue(':order_id', $previous_id);
                  $statement4->bindValue(':menu_id', $menu_id);
                  $statement4->bindValue(':quantity', $quantity);
                  
                  if($statement4->execute()){
                    $statement4->closeCursor();
                    $added = "true";
                  }else{
                    echo"Failed at final stage. Stage 2.";
                  }
                 }
              }else{
                echo"Failed at stage 1";
              }
            }
          }else{
            echo
            '<tr>
              <td colspan="4">No Item In Cart</td
            </tr>';
                }
          if($added == "true"){
            ?>
            <script>
              alert("Order Successfully Processed");
              setTimeout(function(){location.href="empty-cart.php"} , 0000);
            </script>
            <?php
            $added = "false";
          }
          ?>
          
        </table>
        <?php
                require_once("connect-db.php");

                $sql = "select * from customer where customer_id = $customer_id";

                $statement1 = $db->prepare($sql);
                
            
                if($statement1->execute()){
                    $customers = $statement1->fetchAll();
                    $statement1->closeCursor();
                }else{
                    echo"Error finding customers.";
                }

                    foreach($customers as $c){ 
                ?>
            <form method="post">
                <div class="cart-info">
                    <input type="hidden" name="hidden_id" value="<?php echo $c["customer_id"];?>">
              
                    <h1>Shipping Information</h1>
                    <div class="info-user">
                    Address: <input type="text" name="addr" value="<?php echo $c["addr"];?>">
                    <div class="info-second"> City:<input type="text" name="city" value="<?php echo $c["city"];?>"></div>
                    </div> 
                    
                    <h1>Purchasing Information</h1>
                    Credit Card Information: <input type="text" name="addr" value="<?php echo $c["credit_card"];?>">
              
          
                    <h1>Contact Information</h1>
                    Phone Number: <input type="text" name="phone" value="<?php echo $c["phone"];?>">
                    Email: <input type="email" name="email" value="<?php echo $c["email"];?>">
                    
               </div>
            </form>
                <?php
            }?>
            </table>
        </div>
        </article>
    </section>
    <?php include("footer.html") ?>  
</div>
</body>
</html>