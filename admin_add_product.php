<?php

    session_start();
    require_once 'config/db.php';
    if (!isset($_SESSION['admin_login'])) {
        header('location: index.php');
    } 

    if (isset($_POST['addproduct'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $amount = 0;
        $status = "ไม่พร้อมขาย";
        
        try {
            $stmt = $conn->prepare("INSERT INTO products(name, description, price, amount, status) 
            VALUES(:name, :description, :price, :amount, :status)");
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":price", $price);
            $stmt->bindParam(":amount", $amount);
            $stmt->bindParam(":status", $status);
            $stmt->execute();
            $_SESSION['success'] = "เพิ่มข้อมูลเรียบร้อยแล้ว";
            header("location: admin_product.php");                

        } catch (PDOException $e) {
                echo $e->getMessage();
        }
    }

?>