<?php
include('../conn/conn.php');

if (isset($_GET['menu'])) {
    $menu = $_GET['menu'];

    try {

        $query = "DELETE FROM `tbl_menu` WHERE tbl_menu_id ='$menu'";

        $statement = $conn->prepare($query);
        $query_execute = $statement->execute();

        if ($query_execute) {
            header("location: http://localhost/food/admin.php");

            exit(0);
        } else {
            header("location: http://localhost/food/admin.php");

            exit(0);
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
