<?php 

    session_start();
    require_once 'config/db2.php';
    $db_handle = new DBcontroller();

    if (!isset($_SESSION['employee_login'])) {
        header('location: index.php');
    }

    if(!empty($_GET["action"])) {
        switch($_GET["action"]) {
            case "add";
                if(!empty($_POST["quantity"])) {
                    $productById = $db_handle->runQuery("SELECT * FROM products WHERE id ='" . $_GET["id"]. "'");
                    $itemArray = array($productById[0]["id"]=>(array('name'=>$productById[0]["name"],
                                                                        'id'=>$productById[0]["id"],
                                                                        'quantity'=>$_POST["quantity"],
                                                                        'price'=>$productById[0]["price"],
                                                                        'image'=>$productById[0]["image"])));
                }

                if(!empty($_SESSION["cart_item"])) {
                    if(in_array($productById[0]["id"],array_keys($_SESSION["cart_item"]))) {
                        foreach($_SESSION["cart_item"] as $k => $v) {
                            if($productById[0]["id"] == $k) {
                                if(empty($_SESSION["cart_item"][$k]["quantity"])) {
                                    $_SESSION["cart_item"][$k]["quantity"] = 0;
                                }
                                $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                            }
                        }
                    } else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                    }
                } else {
                    $_SESSION["cart_item"] = $itemArray;
                }
            break;
            case "remove";
                if(!empty($_SESSION["cart_item"])) {
                    foreach($_SESSION["cart_item"] as $k => $v) {
                        if($_GET["id"] == $k) {
                            unset($_SESSION["cart_item"][$k]);
                        }
                        if(empty($_SESSION["cart_item"])) {
                            unset($_SESSION["cart_item"]);
                        }
                    }
                }
            break;
            case "empty";
                unset($_SESSION["cart_item"]);
            break;
        }
    }

    

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="employee.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">POS <sup>Employee</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="Employee.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Order -->
            <li class="nav-item">
                <a class="nav-link" href="employee_create_order.php">
                    <i class="fas fa-fw fa-dollar-sign"></i>
                    <span>ทำรายการสั่งซื้อ</span></a>
            </li>             

            <!-- Nav Item - Employess and Customer -->
            <li class="nav-item">
                <a class="nav-link" href="employee_manageCus.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>ข้อมูลลูกค้า</span></a>
            </li>    

            <!-- Nav Item - Product -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-box"></i>
                    <span>ข้อมูลสินค้า</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">จัดการข้อมูลสินค้า</h6>
                        <a class="collapse-item" href="employee_product.php">ข้อมูลสินค้า</a>
                        <a class="collapse-item" href="employee_stock.php">ข้อมูลสต็อกสินค้า</a>
                        <a class="collapse-item" href="">ข้อมูลการขาย</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Addons
            </div>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="charts.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Charts</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>


                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->

                        <li class="nav-item dropdown no-arrow">
                            <tbody>

                            </tbody>
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <tbody>

                                        <form action="" method="POST">
                                            <tr>
                                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
                                            </tr>
                                        </form>
 
                                </tbody>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">

                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="index.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <div class="container-fluid shadow p-2">
                    <center><h2>รายการสั่งซื้อสินค้า</h2></center>
                </div>
                <div class="d-flex">
                    <div style="height:600px;overflow-y: scroll;" class="shadow-sm col-6 p-4">
                        <div><center><h4>รายการสินค้า</h4></center>
                            <form action="" method="POST">
                                <div class="input-group mb-3">
                                    <input type="text" name="srh" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1" autofocus>
                                    <input type="submit" name="search" class="btn btn-info">
                                    <a href="" class="btn btn-secondary">View All</a>
                                </div>
                            </form>


                            <div onlick="" class="js-products d-flex" style="flex-wrap: wrap;height:90%;">
                            <?php


                                $product_array = $db_handle->runQuery("SELECT * FROM products WHERE status ='พร้อมขาย' ");
                                if (!empty($product_array)) {
                                    foreach ($product_array as $key => $value) { ?>
                                        <form action="employee_create_order.php?action=add&id=<?php echo $product_array[$key]["id"];?>" method="POST">
                                            <div class="card m-2 border-0" style="min-width: 250px;max-width: 250px;">
                                                <div class="product-image">
                                                    <img src="upload/<?php echo $product_array[$key]["image"]; ?>" alt="" class="w-100 rounded border">
                                                </div>                                      
                                                <div class="p-4" >
                                                    <div class="text-muted"><?php echo $product_array[$key]["name"]; ?></div>
                                                    <div class="" style="font-size:20px"><b><?php echo number_format($product_array[$key]["price"],2)." ฿"; ?></b></div>
                                                    <div class="cart-action">
                                                        <input type="text" class="product-quantity" name="quantity" value="1" size="2">
                                                        <input type="submit" value="เพิ่มสินค้า" class="btnAddAction btn-success">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    <?php
                                    }
                                }
                                ?>
                            </div>                                

    

                        </div>
                    </div>
                    <div style="height:600px;overflow-y: scroll;" class="col-6 bg-light p-4 pt-2">
                        <div><center><h4>ตะกร้าสินค้า <a href="employee_create_order.php?action=empty" id="btnEmpty">Empty</a></h4></center></div>
                    
                        <?php
                            if(isset($_SESSION["cart_item"])) {
                                $total_quantity = 0;
                                $total_price = 0;
                            
                        ?>

                        
                            <table class="table table-striped">
                                <tr>
                                    <th></th>
                                    <th style="text-align: center">ชื่อสินค้า</th>
                                    <th style="text-align: center">จำนวนสินค้า (ชิ้น)</th>
                                    <th style="text-align: center">ราคา (บาท)</th>
                                    <th style="text-align: center">ลบ</th>
                                    <th></th>
                                </tr>
                            
                                <?php

                                   foreach($_SESSION["cart_item"] as $item) {
                                       $item_price = $item["quantity"] * $item["price"];
                                    

                                ?>

                                <tr>
                                    <td style="width:110px"><img src="upload/<?php echo $item["image"]; ?>" alt="" class="w-100 rounded border"></td>
                                    <td style="text-align: center"><?php echo $item["name"]; ?></td>
                                    <td style="text-align: center"><?php echo $item["quantity"]; ?></td>
                                    <td style="text-align: center"><?php echo number_format($item["price"],2); ?></td>
                                    <td style="text-align: center"><a href="employee_create_order.php?action=remove&id=<?php echo $item["id"];?>" class="btnRemoveAction" alt="Remove Item"><i data-feather="trash"></a></td>
                                </tr>
                                
                                <?php
                                    $total_quantity += $item["quantity"];
                                    $total_price += ($item["price"] * $item["quantity"]);

                                   }
                                ?>

                                <tr>
                                    <td colspan="2" style="text-align: right">รวม :</td>
                                    <td style="text-align: right"><?php echo $total_quantity; ?> ชิ้น</td>
                                    <td colspan="2" style="text-align: right"><?php echo number_format($total_price,2)." ฿"; ?></td>
                                    <td>
                                    <div>
                                        <button>สั่ง</button>
                                    </div>
                                    </td>
                                </tr>
                                



                            </table>
                            <?php
                                    
                                   } else {
                            ?>
                                <div class="no-records">ยังไม่มีรายการสินค้า</div>
                            <?php 
                            } 
                            ?>
                    </div>
                </div>

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Your Website 2021</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="index.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>  

 
        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="js/demo/chart-area-demo.js"></script>
        <script src="js/demo/chart-pie-demo.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script>
            feather.replace()
        </script>
</body>

</html>