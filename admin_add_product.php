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
        $product_num = rand(0,9999)."1111".rand(0,99999);
        
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
            $check_productnum = $conn->prepare("SELECT product_num FROM products WHERE product_num = :product_num");
            $check_productnum->bindParam(":product_num", $product_num);
            $check_productnum->execute();
            $row = $check_productnum->fetch(PDO::FETCH_ASSOC);

            if($row['product_num'] == $product_num){
                $product_num = rand(0,9999).rand(1000,9999).rand(0,99999);
                $stmt = $conn->prepare("INSERT INTO products(name, description, price, amount, status, image, type, product_num) 
                VALUES(:name, :description, :price, :amount, :status, :image, :type ,:product_num)");
                $stmt->bindParam(":name", $name);
                $stmt->bindParam(":description", $description);
                $stmt->bindParam(":price", $price);
                $stmt->bindParam(":amount", $amount);
                $stmt->bindParam(":status", $status);
                $stmt->bindParam(":type", $type);
                $stmt->bindParam(":product_num", $product_num);
                $stmt->bindParam(":image", $image_file);
                $stmt->execute();
                $_SESSION['success'] = "เพิ่มข้อมูลเรียบร้อยแล้ว";
                header("location: admin_product.php"); 
            } else {
                $stmt = $conn->prepare("INSERT INTO products(name, description, price, amount, status, image, type, product_num) 
                VALUES(:name, :description, :price, :amount, :status, :image, :type ,:product_num)");
                $stmt->bindParam(":name", $name);
                $stmt->bindParam(":description", $description);
                $stmt->bindParam(":price", $price);
                $stmt->bindParam(":amount", $amount);
                $stmt->bindParam(":status", $status);
                $stmt->bindParam(":type", $type);
                $stmt->bindParam(":product_num", $product_num);
                $stmt->bindParam(":image", $image_file);
                $stmt->execute();
                $_SESSION['success'] = "เพิ่มข้อมูลเรียบร้อยแล้ว";
                header("location: admin_product.php"); 
            }
               

        } catch (PDOException $e) {
                echo $e->getMessage();
        }
    }

?>