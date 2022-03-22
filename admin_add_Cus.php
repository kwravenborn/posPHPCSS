<?php

    session_start();
    require_once 'config/db.php';
    if (!isset($_SESSION['admin_login'])) {
        header('location: index.php');
    } 

    if (isset($_POST['addcustomer'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $birthday = $_POST['birthday'];
        
        try {
            $stmt = $conn->prepare("INSERT INTO customers(firstname, lastname, address, phone, email, birthday) 
            VALUES(:firstname, :lastname, :address, :phone, :email, :birthday)");
            $stmt->bindParam(":firstname", $firstname);
            $stmt->bindParam(":lastname", $lastname);
            $stmt->bindParam(":address", $address);
            $stmt->bindParam(":phone", $phone);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":birthday", $birthday);
            $stmt->execute();
            $_SESSION['success'] = "เพิ่มข้อมูลเรียบร้อยแล้ว";
            header("location: admin_manageCus.php");                

        } catch (PDOException $e) {
                echo $e->getMessage();
        }
    }

?>