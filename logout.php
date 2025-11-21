<?php
require 'includes/DatabaseConnection.php';
require 'includes/DataBaseFunctions.php';

startUserSession();
logoutUser();
header('Location: index.php');
exit;
?>
