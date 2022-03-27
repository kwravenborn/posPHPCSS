<?php 

    session_start();
    require_once 'config/db.php';
    if (!isset($_SESSION['employee_login'])) {
        header('location: index.php');
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
                                <?php
                                $check_data = $conn->prepare("SELECT * FROM customers");
                                $check_data->execute();

                                while ($row = $check_data->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <!-- <tr>
                                    <th scope="row"><?php echo $row['id']; ?></th>
                                    <td><?php echo $row['firstname']; ?></td>
                                    <td><?php echo $row['lastname']; ?></td>
                                    <td><?php echo $row['address']; ?></td>
                                    <td><?php echo $row['phone']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['birthday']; ?></td>
                                    <td><a href="#" class="btn btn-sm btn-primary">View</a></td>
                                </tr> -->
                                <?php } ?>
                            </tbody>
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <tbody>
                                    <?php
                                    $check_data = $conn->prepare("SELECT * FROM users");
                                    $check_data->execute();

                                    while ($row = $check_data->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                        <form action="" method="POST">
                                            <tr>
                                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $row['firstname']; ?> <?php echo $row['lastname']; ?></span>
                                            </tr>
                                        </form>
                                    <?php } ?>
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


                            <div class="js-products d-flex" style="flex-wrap: wrap;height:90%;">
                            <?php
                                if (isset($_POST['search'])) {
                                    $srh = $_POST['srh'];
                                    $check_data = $conn->prepare("SELECT * FROM products WHERE name = '$srh' OR description = '$srh' 
                                    OR type = '$srh' OR price = '$srh' OR id = '$srh' AND status = 'พร้อมขาย'");
                                    $check_data->execute();
                                } else {
                                    $check_data = $conn->prepare("SELECT * FROM products WHERE status='พร้อมขาย'");
                                    $check_data->execute();
                                }                                    

                                    while ($row = $check_data->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <div class="card m-2 border-0" style="min-width: 250px;max-width: 250px;">
                                    <a href="">
                                        <img src="upload/<?php echo $row['image']; ?>" alt="" class="w-100 rounded border">
                                    </a> 
                                    <div class="p-4" >
                                        <div class="text-muted"><?php echo $row['name']; ?></div>
                                        <div class="" style="font-size:20px"><b><?php echo number_format($row['price']); ?> ฿</b></div>
                                    </div>
                                </div>
                                <?php } ?> 
                            </div>                                

    

                        </div>
                    </div>
                    <div class="col-6 bg-light p-4 pt-2">
                        <div><center><h4>ตะกร้าสินค้า <div class="badge bg-primary">3</div></h4></center></div>
                        
                            <table class="table table-striped">
                                <tr>
                                    <th></th>
                                    <th>ชื่อสินค้า</th>
                                    <th>จำนวนสินค้า</th>
                                    <th>ราคา</th>
                                </tr>
                            </table>
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