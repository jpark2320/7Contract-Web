<?php
    if (!isset($_SESSION['sort'])) {
        $_SESSION['sort'] = 'asc';
    }
    if ($_SESSION['sort']=='asc') {
        echo '<div align="left"><h><a href="?st=desc">Show descending order</a></h></div>';
    } else {
        echo '<div align="left"><h><a href="?st=asc">Show ascending order</a></h></div>';
    }
    if (isset($_GET['st'])) {
        $_SESSION['sort'] = $_GET['st'];
        echo '<script>window.location.href = "worksheet.php";</script>';
    }
?>
