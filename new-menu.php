<?php
 session_start();
 if($_SESSION["admin-login"] != 'true'){
 ?>
 <script>
 window.location.replace("admin-login.php");
 </script>
 <?php
}
$name = $price = $info = $img = "";
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
require_once("connect-db.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $name = test_input($_POST["new-name"]);
    $price = test_input($_POST["new-price"]);
    $info = test_input($_POST["new-info"]);
    $img = test_input($_POST["new-img"]);

$sql = "insert into menu
(name, price, info, img) VALUES (:name, :price, :info, :img)";

        $statement1 = $db->prepare($sql);

        $statement1->bindValue(":name", $name);
        $statement1->bindValue(":price", $price);
        $statement1->bindValue(":info", $info);
        $statement1->bindValue(":img", $img);

            if($statement1->execute()){
                $statement1->closeCursor();
                ?>
                <script>
                    alert("Item Successfully Added");
                    setTimeout(() => {location.href="admin-manage.php"}, 0000);
                </script>
                <?php
            }else{
                echo"Error adding menu item.";
            }
}
?>