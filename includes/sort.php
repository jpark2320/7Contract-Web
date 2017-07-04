<?php
    if (!isset($_SESSION['sort'])) {
        $_SESSION['sort'] = 'asc';
    }
    if ($_SESSION['sort']=='asc') {
        echo '<div align="left" style="float:left; text-decoration:none; color:#ff0000;"><a href="?st=desc">Show descending order</a></div>';
    } else {
        echo '<div align="left" style="float:left; text-decoration:none; color:#ff0000;"><a href="?st=asc">Show ascending order</a></div>';
    }
    if (isset($_GET['st'])) {
        $_SESSION['sort'] = $_GET['st'];
        echo '<script>window.location.href = "worksheet.php";</script>';
    }
?>
