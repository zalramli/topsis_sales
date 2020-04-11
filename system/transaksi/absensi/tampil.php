<?php 
date_default_timezone_set('Asia/Jakarta');
$sekarang = date('Y-m-d');
$hari = date('l'); //Sunday
if(isset($_GET['aksi']))
{
    $id_karyawan = $_GET['aksi'];
    $query_insert = mysqli_query($koneksi,"INSERT INTO detail_absensi (id_detail_absensi,id_karyawan,tgl_absensi) VALUES (NULL,'$id_karyawan','$sekarang')");
    if($query_insert)
    {
        $query_detail = mysqli_query($koneksi,"SELECT * FROM detail_karyawan JOIN karyawan USING(id_karyawan) WHERE id_karyawan='$id_karyawan' AND id_kriteria='C03'");
        foreach($query_detail as $data_detail)
        {
            $id_detail_karyawan = $data_detail['id_detail_karyawan'];
            $value_kriteria = $data_detail['value_kriteria'];
        }
        $value_kriteria = $value_kriteria + 1;
        $query_update = mysqli_query($koneksi,"UPDATE detail_karyawan SET value_kriteria='$value_kriteria' WHERE id_detail_karyawan='$id_detail_karyawan'");
        if($query_update)
        {
            echo "<script>window.location = 'admin.php?halaman=absensi'</script>";
        }
    }
}
?>
<div class="container-fluid">
    <h3 class="page-title">Absensi Karyawan Tanggal <?php echo $sekarang; ?></h3>
    <div class="panel panel-headline">
        <div class="panel-body">
        <?php 
        $query = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan NOT IN (SELECT id_karyawan FROM detail_absensi WHERE tgl_absensi='$sekarang') ORDER BY nama_karyawan ASC") ;
        $count = mysqli_num_rows($query);
        if($hari == "Sunday")
        {
        ?>
            <h2 class="text-center">Hari Ini Tidak Ada Absensi</h2>
        <?php
        }
        else if($count != 0)
        {
        ?>
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama Karyawan</th>
                    <th class="text-center">No Hp</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no = 1;
            foreach ($query as $data) :
            ?>
                <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $data['nama_karyawan'] ?></td>
                    <td><?php echo $data['no_hp'] ?></td>
                    <td class="text-center">
                        <a onclick="return confirm('Yakin ingin melakukan absensi ?')" href="?halaman=absensi&aksi=<?= $data['id_karyawan'] ?>" class="btn btn-sm btn-info">Lakukan Absensi</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            </table>
            <?php
            } else {
            ?>

            <h2 class="text-center">Karyawan Sudah Melakukan Absensi Semua</h2>
            <?php
            }
            ?>
        </div>
    </div>
</div>


