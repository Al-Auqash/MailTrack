<?php
//akses file koneksi database
require('koneksi.php');

//inisialisasi session
session_start();

$error = "";

if (isset($_POST['submit'])) {
    $jenis_keputusan    = $_POST['jenis_keputusan'];
    $tanggal            = $_POST['tanggal'];
    $tentang            = $_POST['tentang'];
    $yang_menetapkan    = $_POST['yang_menetapkan'];

    $username           = $_SESSION['username'];
    
    $sql    = "SELECT `name` FROM `user` WHERE `username` LIKE '%$username%'";
    $query  = mysqli_query($con, $sql);
    $name   = mysqli_fetch_row($query);

    $pengusul           = $name;

    if (empty($jenis_keputusan)) {
        $error = 'jenis keputusan belum diisi';
    } else if (empty($tanggal)) {
        $error = 'tanggal belum diisi';
    } else if (empty($tentang)) {
        $error = 'tentang belum diisi';
    } else if (empty($yang_menetapkan)) {
        $error = 'yang menetapkan belum diisi';
    } else if (empty($pengusul)) {
        $error = 'pengusul belum diisi';
    } else {
        $id = "SELECT id FROM keputusan ORDER BY id DESC LIMIT 1";
        $res = mysqli_query($con, $id);
        $data = mysqli_fetch_row($res);
        $new_id = 1;

        if ($data != null) {
            $new_id = $data[0] + 1;
        } else {
            $new_id = 1;
        }
        $nomor_surat = "SK" . Date("jmY") . $new_id;

        if ($sql = "INSERT INTO `keputusan` (`id`, `nomor_surat`, `jenis_keputusan`, `tanggal` ,`tentang`, `yang_menetapkan`, `pengusul`) VALUES ('$new_id', '$nomor_surat', '$jenis_keputusan', '$tanggal', '$tentang', '$yang_menetapkan', '$pengusul')") {
            mysqli_query($con, $sql);
            header("Location:insert.php");
        } else {
            $error = 'gagal';
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>

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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div><img src="images/ppsdm.png" width="200"></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item ">
                <a class="nav-link" href="home.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Tables -->
            <li class="nav-item active">
                <a class="nav-link" href="#blmjadi">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Create Data</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->

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

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Nyoba</span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Create Data</h1>
                    <!-- DataTales Example -->
                    <div class="card shadow p-2 ">
                        <form class="form-container" action="insert.php" method="POST">
                            <?php if ($error != '') { ?>
                                <div class="alert alert-danger" role="alert"><?= $error; ?></div>
                            <?php } ?>
                            <div class="form-group px-2">
                                <label for="jenis_keputusan">Jenis Keputusan</label>
                                <!-- <input name="jenis_keputusan" type="text" class="form-control" id="jenis_keputusan" placeholder="Jenis Keputusan"> -->
                                <div class="input-group mb-3">
                                    <select name="jenis_keputusan" class="custom-select" id="jenis_keputusan">
                                        <option hidden selected>Jenis Keputusan</option>
                                        <option value="Keputusan Kapus">Keputusan Kapus</option>
                                        <option value="Keputusan KPA/KPB">Keputusan KPA/KPB</option>
                                        <option value="Keputusan Kepala BLU">Keputusan Kepala BLU</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group px-2">
                                <label for="tanggal">tanggal</label>
                                <input name="tanggal" type="date" class="form-control" id="tanggal" placeholder="tanggal">
                            </div>
                            <div class="form-group px-2">
                                <label for="tentang">tentang</label>
                                <input name="tentang" type="text" class="form-control" id="tentang" placeholder="Tentang">
                            </div>
                            <div class="form-group px-2">
                                <label for="yang_menetapkan">Yang Menetapkan</label>
                                <!-- <input name="yang_menetapkan" type="text" class="form-control" id="yang_menetapkan" placeholder="Yang Menetapkan"> -->
                                <div class="input-group mb-3">
                                    <select name="yang_menetapkan" class="custom-select" id="yang_menetapkan">
                                        <option hidden selected>Yang menetapkan</option>
                                        <option value="Kapus">Kapus</option>
                                        <option value="KPA/KPB">KPA/KPB</option>
                                        <option value="Kepala BLU">Kepala BLU</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group px-2">
                                <button type="submit" name="submit" class="btn btn-primary btn-user btn-block">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Content Row -->


                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

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
                        <a class="btn btn-primary" href="logout.php">Logout</a>
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

</body>

</html>