<?php
 session_start();
 if($_SESSION["admin-login"] != 'true'){
 ?>
 <script>
 window.location.replace("admin-login.php");
 </script>
 <?php
}
require_once("connect-db.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $menu_id = $_POST['menu_id'];
}
$sql = "delete from menu
        where menu_id = $menu_id";

        $statement1 = $db->prepare($sql);

            if($statement1->execute()){
                $statement1->closeCursor();
                header("location:admin-manage.php");
            }else{
                echo"Error deleting menu item.";
            }

?>