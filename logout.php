<<<<<<< Updated upstream
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION = [];
session_destroy();
header('Location: index.php');
=======
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION = [];
session_destroy();
header('Location: index.php');
>>>>>>> Stashed changes
exit;