<?php
    include("header2.html");
    require_once("connect-db.php");
    $username = $password = $added = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST["username"];
        $password = $_POST["password"];
    }
?>
<div class="container2">
    <section>
        <article>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="form">
                <div class="createsub">
                <h1>Confirm Login Info</h1>
                Username: <br><input type="text" name="username" value="<?php echo $username?>" required="required"/><br><br>
                Password: <br><input type="text" name="password" value="<?php echo $password?>" required="required"/><br>
                </div>
                <div class="create1 additional">
                <h1>Enter Additional Account Information</h1>
                First Name: <br><input type="text" name="first" required="required"/><br>
                Last Name: <br><input type="text" name="last" required="required"/><br>
                Address: <br><input type="text" name="addr" required="required"/><br>
                City: <br><input type="text" name="city" required="required"/><br>
                Credit Card Number: <br><input type="text" name="credit_card" required="required"/><br>
                Phone Number: <br><input type="tel" name="phone" required="required"/><br>
                Email Address: <br><input type="email" name="email"required="required" /><br>
                <button type="submit"  name="btn2" class="btn2" value="btn2">Submit</button>
                </div>
            </form>
        </article>
    <?php

    if(isset($_POST['btn2'])){
        function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
    require_once("connect-db.php");
    $username = $password = $first = $last = $addr = $city = $credit_card = $phone = $email = $statement1 = $added = "";
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

        $sql = "insert into customer
        (username, password, first, last, addr, city, credit_card, phone, email) VALUES (:username, :password, :first, :last, :addr, :city, :credit_card, :phone, :email)";

        $statement1 = $db->prepare($sql);
                
        $statement1->bindValue(':username', $username);
        $statement1->bindValue(':password', $password);
        $statement1->bindValue(':first', $first);
        $statement1->bindValue(':last', $last);
        $statement1->bindValue(':addr', $addr);
        $statement1->bindValue(':city', $city);
        $statement1->bindValue(':credit_card', $credit_card);
        $statement1->bindValue(':phone', $phone);
        $statement1->bindValue(':email', $email);
    }
    if($statement1->execute()){
        $statement1->closeCursor();
        $added = "true";
     }else{
        echo "<h1>Error adding customers information.</h1>";
    }
    }
    ?>
    </section>
    <?php
    if($added == "true"){
    ?>
    <form action="user-create-login.php" method="post" id="user-form">
    <input type="hidden" name="username" value="<?php echo $username?>">
    <input type="hidden" name="password" value="<?php echo $password?>">
    </form>
    <script type="text/javascript">
    document.getElementById("user-form").submit();
    </script>
   <?php }
include("footer2.html")
    ?>
</div>
</body>
</html>