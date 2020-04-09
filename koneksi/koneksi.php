<!-- koneksi -->
<?php

$koneksi = mysqli_connect("localhost", "root", "", "topsis_sales");
if (!$koneksi) {
	echo "koneksi data base gagal = " . mysqli_connect_error();
}
?>