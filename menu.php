<?php
//when item is added to cart, check is cart is already set. If not make cart_data an array and establish the item id column
if(isset($_POST['btn6'])){
    if(isset($_COOKIE["shopping_cart"])){
      $cookie_data = stripslashes($_COOKIE["shopping_cart"]);
      $cart_data = json_decode($cookie_data, true);
    }else{
      $cart_data = array();
    }
    $item_id_item = array_column($cart_data, 'item_id');

//checks if item is already in array. If it is add the quantity's together. If not add that item to the item array
    if(in_array($_POST["hidden_id"], $item_id_item))
  {
    foreach($cart_data as $keys => $values){
      if($cart_data[$keys]["item_id"] == $_POST["hidden_id"]){
        $cart_data[$keys]["item_quantity"] = $cart_data[$keys]["item_quantity"] + $_POST["quantity"];
      }
    }
  }
  else{
  
    $item_array = array(
      'item_id' => $_POST['hidden_id'],
      'item_name' => $_POST['name'],
      'item_price' => $_POST['price'],
      'item_quantity' => $_POST['quantity']
  );
  //put the item array in the cart_data array which then gets encoded
  $cart_data[] = $item_array;
  }
  //card data is encoded and stored in a cookie variable.
  $item_data = json_encode($cart_data);
  setcookie('shopping_cart', $item_data, time() + (86400 * 30));
  header('location:menu.php?success=1');
}

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
            
            <h2 id="menu-page">Check out our extensive menu!</h2>
            <?php
                require_once("connect-db.php");

                $sql = "select * from menu";

                $statement1 = $db->prepare($sql);
                
            
                if($statement1->execute()){
                    $menu = $statement1->fetchAll();
                    $statement1->closeCursor();
                }else{
                    echo"Error finding customers.";
                }

            ?>
            <table class="menu-table">
                <tr>
                    <th>Item Name</th>
                    <th>Item Price</th>
                    <th>Item Description</th>
                    <th>Item Image</th>
                </tr>
                <?php
                    foreach($menu as $m){ 
                ?>
            <form method="post">
                <tr>
                    <input type="hidden" name="hidden_id" value="<?php echo $m["menu_id"];?>">
                    <td><?php echo $m["name"];?>
                    <input type="hidden" name="name" value="<?php echo $m["name"];?>">
                    </td>
                    <td><?php echo $m["price"];?>
                    <input type="hidden" name="price" value="<?php echo $m["price"];?>">
                    </td>
                    <td><?php echo $m["info"];?></td>
                    <td><img class="item-img" src="<?php echo $m["img"];?>"></td>
                </tr>
                <tr id="table-second-row">
                    <td>
                    Quantity: <input type="quantity" name="quantity" value="1">
                    </td>
                    <td>
                    <button type="submit" class="btn6" name="btn6" value="btn6">Click to Add to Cart</button>
                    </td>
                </tr>
            </form>
                <?php
            }?>
            </table>
            <h3 class="menu-title">Order Details</h3>
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
                <td colspan='2'><button type="submit" class="btn2" name="btn7" value="btn7">Check Out</button></td>
                <td>Total</td>
                <td id="total">$ <?php echo number_format($total, 2); ?></td>
                <td id="empty"><button class="btnEmpty"><a href="empty-cart.php" onclick="return confirm('Are you sure you want to delete?\nThis can not be undone')">Empty Cart</a></button></td>
                </form>
                
              </tr>
              <?php
          }else{
            echo'
            <tr>
              <td colspan="4">No Item In Cart</td
            </tr>';
          }
          ?>
        </table>
        </div>
        </article>
    </section>
    <?php include("footer.html") ?>  
</div>
</body>
</html>