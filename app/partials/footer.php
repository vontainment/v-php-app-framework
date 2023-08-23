<?php
/*
 * Project: Simple App Framework
 * Version: 1.0.0
 * Author: Vontainment
 * URL: https://vontainment.com
 * File: header.php
 * Description: A Simple PHP App Framework for Building Secure Apps
*/
?>

<footer>
    <p>&copy;<?php echo date("Y"); ?> Vontainment. All Rights Reserved.</p>
</footer>

<?php

if (!$isLoginView) {
    echo "<script src='/assets/js/footer-scripts.js'></script>";
    if (isset($viewJsOutput)) {
        echo $viewJsOutput;
    }
}

?>

</body>

</html>