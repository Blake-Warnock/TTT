<?php
session_start();
session_unset();
session_destroy();
?>
<script>
    setTimeout(() => {location.href="index.php"}, 0000);
</script>