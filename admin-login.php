<?php
session_start();
include("header3.html") 
?>
<div class="container admin">
    <section>
        <article>
        <div class="info admin">
            <img class="lTaco" src="images/key2.png">
            <img class="rTaco" src="images/key2.png">

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="create1 admin">
            <h1>Enter Admin Info Here</h1>
            Username: <br><input type="text" name="admin_username" required="required"/><br><br>
            Password: <br><input type="text" name="admin_password" required="required"/><br>
            <button type="submit"  name="btn5" class="btn1 admin" value="btn5">Submit</button>
            </div>
        </form>
        </div>
        </article>
        <?php
        if(isset($_POST['btn5'])){
            function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
          }
        $admin_username = $admin_password = "";
            if($_SERVER["REQUEST_METHOD"] == 'POST'){
                $admin_username = test_input($_POST["admin_username"]);
                $admin_password = test_input($_POST["admin_password"]);
            }    
            if($admin_username == "admin" && $admin_password == "admin"){
                $_SESSION['admin-login'] = 'true';
                ?>
                <script>
                    alert("Login successful...\nRedirecting to Admin Management")
                    setTimeout(function(){location.href="admin-manage.php"} , 0000);
                </script>
                <?php
            }else{
                ?>
                <script>
                    alert("Login Failed...\nPlease try again")
                    setTimeout(function(){location.href="admin-login.php"} , 0000);
                </script>
                <?php
            }
        }
        ?>
    </section>
    <?php include("footer3.html") ?>  
</div>
</body>
</html>