<?php
session_start();
unset($_SESSION['hris']);
echo'<script>localStorage.clear();</script>';

echo'<script>window.location.href="../login.php"</script>';