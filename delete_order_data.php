<!-- reset sesion order_data -->
<?php
session_start();
unset($_SESSION['order_data']);
http_response_code(200);
