<?php

    session_start();
    require_once 'config/db.php';
    if (!isset($_SESSION['admin_login'])) {
        header('location: index.php');
    }

    if (isset($_POST['adduser'])) {
        $username = $_POST['username'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $birthday = $_POST['birthday'];
        $password = MD5($_POST['password']);
        $c_password = MD5($_POST['password']);
        $urole = $_POST['urole'];
        
        if (empty($username)) {
            $_SESSION['error'] = 'กรุณากรอก username';
            header("location: admin_manageEmp.php");
        } else if (empty($firstname)) {
            $_SESSION['error'] = 'กรุณากรอกชื่อ';
            header("location: admin_manageEmp.php");
        } else if (empty($lastname)) {
            $_SESSION['error'] = 'กรุณากรอกนามสกุล';
            header("location: admin_manageEmp.php");
        } else if (empty($address)) {
            $_SESSION['error'] = 'กรุณากรอกที่อยู่';
            header("location: admin_manageEmp.php");
        } else if (empty($phone)) {
            $_SESSION['error'] = 'กรุณากรอกเบอร์โทรศัพท์';
            header("location: admin_manageEmp.php");
        } else if (strlen($_POST['phone']) != 10) {
            $_SESSION['error'] = 'เบอร์โทรศัพท์ต้องมีความยาว 10 ตัวอักษร';
            header("location: admin_manageEmp.php");
        } else if (empty($email)) {
            $_SESSION['error'] = 'กรุณากรอกอีเมล';
            header("location: admin_manageEmp.php");
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'รูปแบบอีเมลไม่ถูกต้อง';
            header("location: admin_manageEmp.php");
        } else if (empty($birthday)) {
            $_SESSION['error'] = 'กรุณากรอกวันเกิด';
            header("location: admin_manageEmp.php");
        } else if (empty($password)) {
            $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
            header("location: admin_manageEmp.php");
        } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
            $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร';
            header("location: admin_manageEmp.php");
        } else if (empty($c_password)) {
            $_SESSION['error'] = 'กรุณายืนยันรหัสผ่านอีกครั้ง';
            header("location: admin_manageEmp.php");
        } else if ($password != $c_password) {
            $_SESSION['error'] = 'รหัสผ่านไม่ตรงกัน';
            header("location: admin_manageEmp.php");
        } else {
            try {

                $check_username = $conn->prepare("SELECT username FROM users WHERE username = :username");
                $check_username->bindParam(":username", $username);
                $check_username->execute();
                $row = $check_username->fetch(PDO::FETCH_ASSOC);

                if ($row['username'] == $username) {
                    $_SESSION['warning'] = 'มี username นี้อยู่ในระบบแล้ว';
                    header("location: admin_manageEmp.php");
                } else if (!isset($_SESSION['error'])) {
                    $stmt = $conn->prepare("INSERT INTO users(username, firstname, lastname, address, phone, email, birthday, password , urole) 
                    VALUES(:username, :firstname, :lastname, :address, :phone, :email, :birthday, :password, :urole)");
                    $stmt->bindParam(":username", $username);
                    $stmt->bindParam(":firstname", $firstname);
                    $stmt->bindParam(":lastname", $lastname);
                    $stmt->bindParam(":address", $address);
                    $stmt->bindParam(":phone", $phone);
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":birthday", $birthday);
                    $stmt->bindParam(":password", $password);
                    $stmt->bindParam(":urole", $urole);
                    $stmt->execute();
                    $_SESSION['success'] = "เพิ่มข้อมูลเรียบร้อยแล้ว";
                    header("location: admin_manageEmp.php");

                } else {
                    $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                    header("location: admin_manageEmp.php");
                }

            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
?>