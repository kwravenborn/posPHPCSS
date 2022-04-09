<?php

session_start();
require_once 'config/db.php';
if (!isset($_SESSION['admin_login'])) {
    header('location: index.php');
}

if (isset($_REQUEST['delete_id'])) {
    $id = $_REQUEST['delete_id'];

    $select_stmt = $conn->prepare('SELECT * FROM customers WHERE id = :id');
    $select_stmt->bindParam(':id', $id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

    $delete_stmt = $conn->prepare('DELETE FROM customers WHERE id = :id');
    $delete_stmt->bindParam(':id', $id);
    $delete_stmt->execute();

    header("location: admin_manageCus.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home Page</title>
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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">POS <sup>Admin</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="admin.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Employess and Customer -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-user"></i>
                    <span>ข้อมูลพนักงานและลูกค้า</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">จัดการข้อมูล</h6>
                        <a class="collapse-item" href="admin_manageEmp.php">พนักงาน</a>
                        <a class="collapse-item" href="admin_manageCus.php">ลูกค้า</a>
                    </div>
                </div>
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
                        <a class="collapse-item" href="admin_product.php">ข้อมูลสินค้า</a>
                        <a class="collapse-item" href="admin_stock.php">ข้อมูลสต็อกสินค้า</a>
                        <a class="collapse-item" href="admin_order.php">ข้อมูลการขาย</a>
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

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
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
                    <form method="POST" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="">
                        <div>
                            <input type="text" name="srh" class="form-control bg-light border-0 small" placeholder="Search for...">.
                            <input type="submit" name="search" class="btn btn-primary">
                        </div>
                    </form>

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
                <!-- The Modal เพิ่มข้อมูล -->
                <div class="modal" id="addModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">เพิ่มข้อมูลลูกค้า</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form action="admin_add_Cus.php" method="POST">
                                    <?php if (isset($_SESSION['error'])) { ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php
                                            echo $_SESSION['error'];
                                            unset($_SESSION['error']);
                                            ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($_SESSION['success'])) { ?>
                                        <div class="alert alert-success" role="alert">
                                            <?php
                                            echo $_SESSION['success'];
                                            unset($_SESSION['success']);
                                            ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($_SESSION['warning'])) { ?>
                                        <div class="alert alert-warning" role="alert">
                                            <?php
                                            echo $_SESSION['warning'];
                                            unset($_SESSION['warning']);
                                            ?>
                                        </div>
                                    <?php } ?>
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">ชื่อ</label>
                                        <input type="text" class="form-control" name="firstname" aria-describebdy="firstname">
                                    </div>
                                    <div class="mb-3">
                                        <label for="lastname" class="form-label">นามสกุล</label>
                                        <input type="text" class="form-control" name="lastname" aria-describebdy="lastname">
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">ที่อยู่</label>
                                        <input type="text" class="form-control" name="address" aria-describebdy="address">
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">เบอร์โทรศัพท์</label>
                                        <input type="text" class="form-control" name="phone" aria-describebdy="phone">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">อีเมล</label>
                                        <input type="text" class="form-control" name="email" aria-describebdy="email">
                                    </div>
                                    <div class="mb-3">
                                        <label for="birthday" class="form-label">วันเกิด</label>
                                        <input type="date" class="form-control" name="birthday" aria-describebdy="birthday">
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <input type="submit" name="addcustomer" class="btn btn-success" value="เพิ่มข้อมูล">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Customers</li>
                            <li class="breadcrumb-item active" aria-current="page">Overview</li>
                        </ol>
                    </nav>
                    <h1 class="h2">รายชื่อลูกค้า
                        <a href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">เพิ่มข้อมูล <i data-feather="plus"></i></a>
                    </h1>
                    <div class="row">
                        <div class="col-12 col-xl-20 mb-4 mb-lg-0">
                            <div class="card">
                                <h5 class="card-header">Customers List</h5>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" style="text-align: center">ID</th>
                                                    <th scope="col" style="text-align: center">ชื่อ</th>
                                                    <th scope="col" style="text-align: center">นามสกุล</th>
                                                    <th scope="col" style="text-align: center">ที่อยู่</th>
                                                    <th scope="col" style="text-align: center">เบอร์โทรศัพท์</th>
                                                    <th scope="col" style="text-align: center">อีเมล</th>
                                                    <th scope="col" style="text-align: center">วันเกิด</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                if (isset($_POST['search'])) {

                                                    $srh = $_POST['srh'];
                                                    $check_data = $conn->prepare("SELECT * FROM customers WHERE firstname = '$srh' OR lastname = '$srh' OR address = '$srh'
                                                    OR phone = '$srh' OR email = '$srh' OR birthday = '$srh' OR id = '$srh'");
                                                    $check_data->execute();

                                                } else {                                   
                                                    $check_data = $conn->prepare("SELECT * FROM customers");
                                                    $check_data->execute();
                                                }

                                                while ($row = $check_data->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                    <tr>
                                                        <th scope="row" style="text-align: center"><?php echo $row['id']; ?></th>
                                                        <td style="text-align: center"><?php echo $row['firstname']; ?></td>
                                                        <td style="text-align: center"><?php echo $row['lastname']; ?></td>
                                                        <td style="text-align: center"><?php echo $row['address']; ?></td>
                                                        <td style="text-align: center"><?php echo $row['phone']; ?></td>
                                                        <td style="text-align: center"><?php echo $row['email']; ?></td>
                                                        <td style="text-align: center"><?php echo $row['birthday']; ?></td>
                                                        <td><a href="admin_edit_Cus.php?update_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Edit</a></td>
                                                        <td><a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Delete</a></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <a href="" class="btn btn-block btn-light">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
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