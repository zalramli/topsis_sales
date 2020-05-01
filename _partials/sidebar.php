<div id="sidebar-nav" class="sidebar">
    <div class="sidebar-scroll">
        <nav>
            <ul class="nav">
                <li><a href="?halaman=perangkingan" <?php if($_GET['halaman'] == "perangkingan") {echo "class='active'";} ?>><i class="lnr lnr-chart-bars"></i> <span>Perangkingan</span></a></li>
                <li><a href="?halaman=perhitungan_topsis" <?php if($_GET['halaman'] == "perhitungan_topsis") {echo "class='active'";} ?>><i class="lnr lnr-dice"></i> <span>Perhitungan Topsis</span></a></li>
                <li><a href="?halaman=absensi" <?php if($_GET['halaman'] == "absensi") {echo "class='active'";} ?>><i class="lnr lnr-alarm"></i> <span>Absensi</span></a></li>
                <li><a href="?halaman=total_penjualan" <?php if($_GET['halaman'] == "total_penjualan") {echo "class='active'";} ?>><i class="lnr lnr-file-empty"></i> <span>Total Penjualan</span></a></li>
                <li><a href="?halaman=karyawan" <?php if($_GET['halaman'] == "karyawan") {echo "class='active'";} ?>><i class="lnr lnr-users"></i> <span>Data Karyawan</span></a></li>
                <li><a href="?halaman=kriteria" <?php if($_GET['halaman'] == "kriteria") {echo "class='active'";} ?>><i class="lnr lnr-cog"></i> <span>Data Kriteria</span></a></li>
                <li><a href="?halaman=user" <?php if($_GET['halaman'] == "user") {echo "class='active'";} ?>><i class="lnr lnr-user"></i> <span>Data User</span></a></li>
            </ul>
        </nav>
    </div>
</div>

