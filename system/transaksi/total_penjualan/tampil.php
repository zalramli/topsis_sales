<?php 
if(isset($_POST['update']))
{
    $id_detail_karyawan = $_POST['id_detail_karyawan'];
    $total_penjualan = $_POST['total_penjualan'];
    $query_update = mysqli_query($koneksi,"UPDATE detail_karyawan SET value_kriteria='$total_penjualan' WHERE id_detail_karyawan='$id_detail_karyawan'");
    if ($query_update) {
        echo "<script>window.location = 'admin.php?halaman=total_penjualan'</script>";
    }
}
?>
<div class="container-fluid">
    <h3 class="page-title">Total Penjualan Tiap Karyawan</h3>
    <div class="panel panel-headline">
        <div class="panel-body">
        <table id="example" class="table table-striped table-bordered" style="width:100%">

            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama Karyawan</th>
                    <th class="text-center">Total Barang Berhasil Terjual</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no = 1;
            $query = mysqli_query($koneksi, "SELECT * FROM detail_karyawan JOIN karyawan USING(id_karyawan) WHERE id_kriteria='C02' ORDER BY value_kriteria DESC");
            foreach ($query as $data) :
            ?>
                <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $data['nama_karyawan'] ?></td>
                    <td class="text-right"><?php echo $data['value_kriteria']." Barang" ?></td>
                    <td class="text-center">
                    <a style="cursor:pointer" class="btn btn-sm btn-warning text-white" data-toggle="modal"
                                data-target="#modal-edit<?= $data['id_detail_karyawan'] ?>">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            </table>
        </div>
    </div>
</div>


<?php foreach($query as $data):  ?>
<div id="modal-edit<?=$data['id_detail_karyawan'];?>" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Total Penjualan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="" method="POST">
			<div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="inputEmail2">Nama Karyawan </label>
                        <input type="hidden" name="id_detail_karyawan" value="<?php echo $data['id_detail_karyawan'] ?>">
                        <input type="text" name="nama_karyawan"
                            class="form-control form-control-sm" id="inputEmail2"
                            placeholder="Masukan nama karyawan" value="<?php echo $data['nama_karyawan'] ?>" readonly>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="inputEmail2">Total Penjualan </label>
                        <input type="text" name="total_penjualan"
                            class="form-control form-control-sm" id="inputEmail2"
                            placeholder="Masukan jumlah total penjualan" value="<?php echo $data['value_kriteria'] ?>" required>
                    </div>
                </div>
            </div>
			<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" name="update" class="btn btn-info">Update</button>
			</div>
			</form>
		</div>
	</div>
</div>
<?php endforeach; ?>
