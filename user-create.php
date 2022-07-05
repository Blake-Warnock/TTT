<?php
    include("header2.html")
?>
<div class="container2">
    <section>
        <article>
            <form action="user-create-confirm.php" method="post">

                <div class="create1">
                <h1>Create Login Info</h1>
                Username: <br><input type="text" name="username" required="required"/><br><br>
                Password: <br><input type="text" name="password" required="required"/><br>
                <button type="submit"  name="btn1" class="btn1" value="btn1">Submit</button>
                </div>

            </form>
        </article>
    </section> 
    <?php
        include("footer2.html")
    ?>
</div>
</body>
</html>