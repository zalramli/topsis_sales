<!doctype html>
<html lang="en">

<head>
	<?php 
	include "koneksi/koneksi.php";
	include "_partials/head.php"; 
	?>
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<?php include "_partials/header.php"; ?>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<?php include "_partials/sidebar.php" ?>
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
            <?php 
                if(!isset($_GET['halaman'])) {
                        error_reporting(0);
                    }
                    // if ($_GET['halaman'] == 'dashboard') {
                    //     include "dashboard/dashboard_admin.php";
                    // }
                    // Tutup Dashboard

                    // Parsing halaman Pegawai
                    if ($_GET['halaman'] == 'karyawan') {
                        include "system/master/karyawan/tampil.php";
					}
					if ($_GET['halaman'] == 'kriteria') {
                        include "system/master/kriteria/tampil.php";
					}
					if ($_GET['halaman'] == 'total_penjualan') {
                        include "system/transaksi/total_penjualan/tampil.php";
                    }
                ?>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
		<div class="clearfix"></div>
		<footer>
			<div class="container-fluid">
				<p class="copyright">Shared by <i class="fa fa-love"></i><a href="https://bootstrapthemes.co">BootstrapThemes</a></p>
			</div>
		</footer>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<?php include "_partials/javascript.php"; ?>
</body>

</html>
