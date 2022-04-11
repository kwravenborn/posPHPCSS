<?php

    session_start();
    require_once 'config/db.php';
    if (!isset($_SESSION['admin_login'])) {
        header('location: index.php');
    } 

    if (isset($_POST['addstock'])) {
        $product_num = $_POST['id'];
        $amount = $_POST['amount'];
        
        $select_stmt = $conn->prepare('SELECT * FROM products WHERE product_num = :product_num');
        $select_stmt->bindParam(':product_num', $product_num);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        
        $name = $row['name'];
        $stmt = $conn->prepare("INSERT INTO stockpd(name, amount) 
        VALUES(:name, :amount)");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":amount", $amount);
        $stmt->execute();

        $amount = ($_POST['amount'] + $row['amount']);
        $status = "พร้อมขาย";

        $up_stmt = $conn->prepare("UPDATE products SET amount = :amount, status = :status WHERE product_num = :product_num");
        $up_stmt->bindParam(":amount", $amount);
        $up_stmt->bindParam(":status", $status);
        $up_stmt->bindParam(":product_num", $product_num);
        $up_stmt->execute();
        header("location: admin_product.php"); 

    }
