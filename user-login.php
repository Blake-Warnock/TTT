<?php
    session_start();
    include("header2.html")
?>
<div class="container2">
    <section>
        <article>
            <div class="loginSub">
            <h1>Don't have an account yet?</h1>
                <a class="signUp" href="user-create.php">Sign Up Here</a>
            </div>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            
                <div class="create1">
                <h1>Enter Login Info Here</h1>
                Username: <br><input type="text" name="username" required="required"/><br><br>
                Password: <br><input type="text" name="password" required="required"/><br>
                <button type="submit"  name="btn4" class="btn1" value="btn4">Submit</button>
                </div>
            </form>
            <?php
            if(isset($_POST['btn4'])){
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

        $sql = "select * from customer";

            $statement1 = $db->prepare($sql);

            if($statement1->execute()){
                $account = $statement1->fetchAll();
                $statement1->closeCursor();
            }else{
                echo "<h4>Error finding account information</h4>";
            }
            foreach($account as $a){
                if($username == $a["username"] && $password == $a["password"]){
                    $_SESSION['user-login'] = 'true';
                    $_SESSION['user-id'] = $a['customer_id'];
                    ?>
                        <script>
                            alert("Login successful...\nRedirecting to Account Management")
                            setTimeout(function(){location.href="account-manage.php"} , 0000);
                        </script>
                    <?php
                    break;
                }
                else{
                    ?>
                    <script>
                            alert("Login successful...\nRedirecting to Account Management")
                            setTimeout(function(){location.href="account-manage.php"} , 0000);
                    </script>
                    <?php
                }
            }
            if($_SESSION['user-login'] != true){
                echo "<p>Incorrect Login Information</p>";
            }
        }
    }
        ?>
        </article>
    </section> 
    <?php
        include("footer2.html")
    ?>
</div>
</body>
</html>