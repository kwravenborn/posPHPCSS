<?php

    session_start();
    require_once 'config/db.php';
    if (!isset($_SESSION['admin_login'])) {
        header('location: index.php');
    } 

    if (isset($_POST['addproduct'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        $price = $_POST['price'];
        $amount = 0;
        $status = "ไม่พร้อมขาย";

        $image_file = $_FILES['file']['name'];
        $itype = $_FILES['file']['type'];
        $size = $_FILES['file']['size'];
        $temp = $_FILES['file']['tmp_name'];

        $path = "upload/" . $image_file;  //set upload folder path

        if ($itype == "image/jpg" || $itype == "image/jpeg" || $itype == "image/png" || $itype == "image/gif") {
            if (!file_exists($path)) {  // check file not exist in your upload folder path
                if ($size < 5000000) {  // check file size
                    move_uploaded_file($temp, 'upload/'.$image_file); //move upload file temperary to upload folder
                } else {
                    $errorMsg = "Your file too large.";
                }
            } else {
                $errorMsg = "File already exists.";
            }
        } else {
            $errorMsg = "Upload JPG, JPEG, PNG and GIF file formate.";
        }

        
        try {
            $stmt = $conn->prepare("INSERT INTO products(name, description, price, amount, status, image, type) 
            VALUES(:name, :description, :price, :amount, :status, :image, :type)");
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":price", $price);
            $stmt->bindParam(":amount", $amount);
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":type", $type);
            $stmt->bindParam(":image", $image_file);
            $stmt->execute();
            $_SESSION['success'] = "เพิ่มข้อมูลเรียบร้อยแล้ว";
            header("location: admin_product.php");                

        } catch (PDOException $e) {
                echo $e->getMessage();
        }
    }

?>