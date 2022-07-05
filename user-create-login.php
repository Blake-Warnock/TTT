<?php
    session_start();
    include("header2.html");
    
?>
<div class="container2">
    <section>
        <article>
            <div class="create1">
                <h1>Account Successfully Created!</h1>
            <?php
           

            require_once("connect-db.php");

            $username = $password = "";

            if($_SERVER["REQUEST_METHOD"] == "POST"){
            $username = $_POST["username"];
            $password = $_POST["password"]; 
            

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
                    echo "<p>You will be redirected to the account management page shortly</p>";
                    ?>
                        <script>
                            setTimeout(function(){location.href="account-manage.php"} , 5000);
                        </script>
                    <?php
                    break;
                }
            }
            if($_SESSION['user-login'] != true){
                echo "<p>Error automatically logging in. Please refresh or try manually logging in</p>";
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