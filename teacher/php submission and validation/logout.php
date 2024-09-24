<?php
session_start();
session_destroy(); // Destroy all session data
header("Location: /public/index.php"); // Redirect to home page
exit();
