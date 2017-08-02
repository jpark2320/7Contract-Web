<?php
    echo '<div align="left">';
    if (!isset($_SESSION['sort'])) {
        $_SESSION['sort'] = 'asc';
    }
    if ($_SESSION['sort']=='asc') {
        echo '<button onClick="location.href=\'?st=desc\'">Show Descending Order</button>';
    } else {
        echo '<button onClick="location.href=\'?st=asc\'">Show Ascending Order</button>';
    }
    if (isset($_GET['st'])) {
        $_SESSION['sort'] = $_GET['st'];
    }
    echo '</div>';
?>
