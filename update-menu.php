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
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $menu_id = $_POST['menu_id'];
            }
            require_once("connect-db.php");

            $sql = "select * from menu where menu_id = $menu_id";

            $statement1 = $db->prepare($sql);

            if($statement1->execute()){
                $menu = $statement1->fetchAll();
                $statement1->closeCursor();
            }else{
                echo"Error finding menu.";
            }
                ?>

                <h3 class="admin-table-header">Menu Table Update</h1>  
                <table class="admin-table update">
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Info</th>
                    <th>Img</th>
                </tr>
            <?php
            foreach($menu as $m){    
            ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <tr>
                    <td class="admin-item2"><input type="text" name="name" value="<?php echo $m['name']; ?>"></td>
                    <td class="admin-item3"><input type="text" name="price" value="<?php echo $m['price']; ?>"></td>
                    <td><textarea name="info" value="<?php echo $m['info']; ?>"><?php echo $m['info']; ?></textarea></td>
                    <td class="admin-item2"><input type="text" name="img" value="<?php echo $m['img']; ?>"></td>
                    <input type="hidden" name="menu_id" value="<?php echo $m['menu_id']; ?>">
                    <td class="admin-item1"><button class="admin-btn1" value="admin-btn1" name="admin-btn1"  type="submit">Update</button></td>
                </tr>
            </form>
            <?php
            }
            if(isset($_POST['admin-btn1'])){
                if($_SERVER['REQUEST_METHOD'] == "POST"){
                    $name = $_POST['name'];
                    $price = $_POST['price'];
                    $info = $_POST['info'];
                    $img = $_POST['img'];
    
                    require_once("connect-db.php");

                    $sql2 = "update menu set
                    name = :name,
                    price = :price,
                    info = :info,
                    img = :img
                    where menu_id = $menu_id";

                    $statement2 = $db->prepare($sql2);

                    $statement2->bindValue(':name', $name);
                    $statement2->bindValue(':price', $price);
                    $statement2->bindValue(':info', $info);
                    $statement2->bindValue(':img', $img);
                }
                    if($statement2->execute()){?>
                    <script>
                        alert("Menu Updated");
                        setTimeout(() => {location.href="admin-manage.php"}, 0000);
                    </script>
                    <?php
                        $statement1->closeCursor();
                    }else{
                        echo"Error updating menu.";
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