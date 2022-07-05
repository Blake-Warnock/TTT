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

            $sql = "select * from menu";

            $statement1 = $db->prepare($sql);

            if($statement1->execute()){
                $menu = $statement1->fetchAll();
                $statement1->closeCursor();
            }else{
                echo"Error finding menu.";
            }
                ?>

<button class="admin-btn1"><a class="logout-link admin top" href="admin-manage-orders.php">Manage Orders</a></button>
<button class="admin-btn1"><a class="logout-link admin top" href="admin-manage.php">Manage Menus</a></button>
                <h3 class="admin-table-header">Menu Table</h1>
                <table class="admin-table">
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Info</th>
                    <th>Img</th>
                </tr>
            <?php
            foreach($menu as $m){    
            ?>
            <form action="update-menu.php" method="post">
                <tr>
                    <td><?php echo $m['name']; ?></td>
                    <td class="admin-item1"><?php echo $m['price']; ?></td>
                    <td><?php echo $m['info']; ?></td>
                    <td class="admin-item2"><?php echo $m['img']; ?></td>
                    <input type="hidden" name="menu_id" value="<?php echo $m['menu_id']; ?>">
                    <td class="admin-item1"><button class="admin-btn1" type="submit">Update</button></td>
                </form>
                <form action="delete-menu.php" method="post">
                    <input type="hidden" name="menu_id" value="<?php echo $m['menu_id']; ?>">
                    <td class="admin-item1"><button type="submit" class="admin-btn1"><a class="logout-link admin" onclick="return confirm('Are you sure you want to delete?\nThis can not be undone')">Remove</a></button></td>
                </form>
            </tr>
            <?php
            }
            ?>
            </table>
            <table class="admin-table">
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Info</th>
                    <th>Img</th>
                </tr>
                <form action="new-menu.php" method="post">
                <tr>
                    <td class="admin-item4"><input type="text" name="new-name" required="required"></td>
                    <td class="admin-item4"><input type="text" name="new-price" required="required"></td>
                    <td><textarea name="new-info" required="required"></textarea></td>
                    <td class="admin-item4"><input type="text" name="new-img" required="required"></td>
                </tr>
                <tr>
                <td colspan="4" class="admin-item1"><button class="admin-btn1" value="admin-btn1" name="admin-btn1"  type="submit">Add</button></td>
                </tr>
                </form>
            </table>
        </div>
        </article>
    </section>
    <?php include("footer3.html") ?>  
</div>
</body>
</html>