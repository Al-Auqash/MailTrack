<?php
//akses file koneksi database
require('koneksi.php');

//inisialisasi session
session_start();

if (isset($_POST["katakunci"])) {
    $katakunci = $_POST["katakunci"];
}

if (isset($_POST["katakunci_tanggal"])) {
    $katakunci_tanggal = $_POST["katakunci_tanggal"];
}

?>

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
            <li class="nav-item active">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="insert.php">
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
                    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
                    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    <br><br>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data</h6>
                        </div>
                        <div class="card-body">
                            <!-- fitur pencarian -->
                            <form action="home.php" method="post">
                                <div class="row">
                                    <div class="col-5 bottom-10">
                                        <input type="text" class="form-control" id="kata_kunci" name="katakunci" placeholder="Pencarian">
                                    </div>
                                    <div class="col-5 bottom-10">
                                        <input type="date" class="form-control" id="kata_kunci_tanggal" name="katakunci_tanggal">
                                    </div>
                                    <div class="col-2 bottom-10">
                                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i>&nbsp; Search</button>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nomor Surat</th>
                                            <th>Jenis Keputusan</th>
                                            <th>Tanggal</th>
                                            <th>Tentang</th>
                                            <th>Yang Menetapkan</th>
                                            <th>Pengusul</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nomor Surat</th>
                                            <th>Jenis Keputusan</th>
                                            <th>Tanggal</th>
                                            <th>Tentang</th>
                                            <th>Yang Menetapkan</th>
                                            <th>Pengusul</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM `keputusan`";
                                        if (!empty($katakunci) && !empty($katakunci_tanggal)) {
                                            $sql .= " where (`nomor_surat` LIKE '%$katakunci%' or `jenis_keputusan` LIKE '%$katakunci%' or `tentang` LIKE '%$katakunci%' or `yang_menetapkan` LIKE '%$katakunci%' or `pengusul` LIKE '%$katakunci%') AND `tanggal` LIKE '%$katakunci_tanggal%'";
                                        }else if (!empty($katakunci_tanggal)) {
                                            $sql .= " where `tanggal` LIKE '%$katakunci_tanggal%'";
                                        }else if(!empty($katakunci)){
                                            $sql .= " where `nomor_surat` LIKE '%$katakunci%' or `jenis_keputusan` LIKE '%$katakunci%' or `tentang` LIKE '%$katakunci%' or `yang_menetapkan` LIKE '%$katakunci%' or `pengusul` LIKE '%$katakunci%'";
                                        }

                                        $sql .= " ORDER BY `id`";
                                        $query = mysqli_query($con, $sql);
                                        // $no = 1;
                                        // if (empty($data = mysqli_fetch_row($query))) {
                                        // 
                                        ?>
                                        <!-- <tr>
                                        //         <td colspan="7" class="text-center">Tidak Ada Data</td>
                                        //     </tr> -->
                                        <?php
                                        // } else {
                                        while ($data = mysqli_fetch_row($query)) {
                                            $id = $data[0];
                                            $nomor_surat = $data[1];
                                            $jenis_keputusan = $data[2];
                                            $tanggal = $data[3];
                                            $tentang = $data[4];
                                            $yang_menetapkan = $data[5];
                                            $pengusul = $data[6];
                                        ?>
                                            <tr>
                                                <td><?php echo $id ?></td>
                                                <td><?php echo $nomor_surat ?></td>
                                                <td><?php echo $jenis_keputusan ?></td>
                                                <td><?php echo $tanggal ?></td>
                                                <td><?php echo $tentang ?></td>
                                                <td><?php echo $yang_menetapkan ?></td>
                                                <td><?php echo $pengusul ?></td>
                                            </tr>
                                        <?php }
                                        // } 
                                        ?>
                                        <!-- <tr>
                                            <td>1</td>
                                            <td>Keputusan Kapus</td>
                                            <td>2022/08/17</td>
                                            <td>Tentang a</td>
                                            <td>Kapus</td>
                                            <td>Daffa</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Keputusan KPA</td>
                                            <td>2022/08/18</td>
                                            <td>Tentang b</td>
                                            <td>KPA</td>
                                            <td>Daffa</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Keputusan Kepala BLU</td>
                                            <td>2022/08/31</td>
                                            <td>Tentang c</td>
                                            <td>Kepala BLU</td>
                                            <td>Daffa</td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
                    <a class="btn btn-primary" href="login.php">Logout</a>
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