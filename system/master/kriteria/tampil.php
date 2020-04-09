<?php 
if(isset($_POST['simpan']))
{
    $sql = mysqli_query($koneksi, "SELECT max(id_kriteria) FROM kriteria");
    $kode_faktur = mysqli_fetch_array($sql);
    if ($kode_faktur) {
        $nilai = substr($kode_faktur[0], 1);
        $kode = (int) $nilai;
        //tambahkan sebanyak + 1
        $kode = $kode + 1;
        $id_kriteria = "C" . str_pad($kode, 2, "0",  STR_PAD_LEFT);
    } else {
        $id_kriteria = "C01";
    }
    $nama_kriteria = $_POST['nama_kriteria'];
    $atribut = $_POST['atribut'];
    $bobot = $_POST['bobot'];
    $query_insert_kriteria = mysqli_query($koneksi, "INSERT INTO kriteria (id_kriteria,nama_kriteria,atribut,bobot) VALUES ('$id_kriteria','$nama_kriteria','$atribut','$bobot') ");
    if ($query_insert_kriteria) {
        echo "<script>window.location = 'admin.php?halaman=kriteria'</script>";
    }
}
if(isset($_GET['hapus_kriteria']))
{
    $id_kriteria = $_GET['hapus_kriteria'];
    $query_delete = mysqli_query($koneksi,"DELETE FROM kriteria WHERE id_kriteria='$id_kriteria'");
    if($query_delete)
    {
        echo "<script>window.location = 'admin.php?halaman=kriteria'</script>";
    }
}

if(isset($_POST['update']))
{
    $id_kriteria = $_POST['id_kriteria'];
    $nama_kriteria = $_POST['nama_kriteria'];
    $atribut = $_POST['atribut'];
    $bobot = $_POST['bobot'];
    $query_update = mysqli_query($koneksi,"UPDATE kriteria SET nama_kriteria='$nama_kriteria',atribut='$atribut',bobot='$bobot' WHERE id_kriteria='$id_kriteria'");
    if ($query_update) {
        echo "<script>window.location = 'admin.php?halaman=kriteria'</script>";
    }
}
?>
<div class="container-fluid">
    <h3 class="page-title">Data Kriteria</h3>
    <div class="panel panel-headline">
        <div class="panel-body">
        <!-- Modal -->
        <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Data Kriteria</h4>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="inputEmail2">Nama Kriteria </label>
                                <input type="text" name="nama_kriteria"
                                class="form-control form-control-sm" id="inputEmail2"
                                placeholder="Masukan nama kriteria" required>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="inputEmail2">Atribut </label>
                                <select name="atribut" id="" class="form-control form-control-sm" required>
                                    <option value="Benefit">Benefit</option>
                                    <option value="Cost">Cost</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="inputEmail2">Bobot </label>
                                <input type="text" name="bobot"
                                class="form-control form-control-sm" id="inputEmail2"
                                placeholder="Masukan besar bobot" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" name="simpan" class="btn btn-info">Simpan</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <!-- Tutup Modal -->
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <a href="#" style="margin-bottom:10px" class="btn btn-info" data-toggle="modal" data-target="#largeModal">Tambah</a>

            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama Kriteria</th>
                    <th class="text-center">Atribut</th>
                    <th class="text-center">Bobot</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no = 1;
            $query = mysqli_query($koneksi, "SELECT * FROM kriteria ORDER BY id_kriteria ASC");
            foreach ($query as $data) :
            ?>
                <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $data['nama_kriteria'] ?></td>
                    <td><?php echo $data['atribut'] ?></td>
                    <td><?php echo $data['bobot'] ?></td>
                    <td class="text-center">
                    <?php 
                    if($data['id_kriteria'] == "C01" || $data['id_kriteria'] == "C02" || $data['id_kriteria'] == "C03")
                    {
                    ?>
                    <a style="cursor:pointer" class="btn btn-sm btn-warning text-white" data-toggle="modal"
                                data-target="#modal-edit<?= $data['id_kriteria'] ?>">Edit</a>
                    <?php
                    } else {
                    ?>
                        <a style="cursor:pointer" class="btn btn-sm btn-warning text-white" data-toggle="modal"
                                data-target="#modal-edit<?= $data['id_kriteria'] ?>">Edit</a>
                        <a onclick="return confirm('Yakin ingin menghapus data ?')" href="?halaman=kriteria&hapus_kriteria=<?= $data['id_kriteria'] ?>" class="btn btn-sm btn-danger">Hapus</a>
                    <?php
                    }
                    ?>                        
                    </td> 
                </tr>
            <?php endforeach; ?>
            </tbody>
            </table>
        </div>
    </div>
</div>

<?php foreach($query as $data):  ?>
<div id="modal-edit<?=$data['id_kriteria'];?>" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Data Kriteria</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="" method="POST">
			<div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="inputEmail2">Nama Kriteria </label>
                        <input type="hidden" name="id_kriteria" value="<?php echo $data['id_kriteria'] ?>">
                        <input type="text" name="nama_kriteria"
                            class="form-control form-control-sm" id="inputEmail2"
                            placeholder="Masukan nama kriteria" value="<?php echo $data['nama_kriteria'] ?>" required>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="inputEmail2">Atribut </label>
                        <select name="atribut" id="" class="form-control form-control-sm" required>
                            <option value="Benefit" <?php if($data['atribut'] == "Benefit") {echo "selected";} ?>>Benefit</option>
                            <option value="Cost" <?php if($data['atribut'] == "Cost") {echo "selected";} ?>>Cost</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="inputEmail2">Bobot </label>
                        <input type="text" name="bobot"
                            class="form-control form-control-sm" id="inputEmail2"
                            placeholder="Masukan besar bobot" value="<?php echo $data['bobot'] ?>" required>
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
