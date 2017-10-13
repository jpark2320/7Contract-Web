<?php
    // connection with mysql database
    include('./includes/connection.php');
    $id = $_GET['id'];
    $sql = "DELETE FROM estimate WHERE id='$id'";
    $conn->query($sql);
    $sql = "DELETE FROM estimate_description WHERE estimate_id='$id'";
    $conn->query($sql);
    $conn->close();
    echo '<script>window.location.href="view_estimate.php";</script>';
?>
