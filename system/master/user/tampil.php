<?php
if(isset($_POST['simpan']))
{
	$nama_user = addslashes($_POST['nama_user']);
	$username = $_POST['username'];
	$password = $_POST['password'];
    $konfirmasi_password = $_POST['konfirmasi_password'];
    if($password == $konfirmasi_password)
    {
        $password = password_hash($password, PASSWORD_DEFAULT); // fungsi mengenkripsi data
        $query_insert = mysqli_query($koneksi, "INSERT INTO user (id_user,nama_user,username,password) VALUES (NULL,'$nama_user','$username','$password') ");
        if ($query_insert) {
            echo "<script>window.location = 'admin.php?halaman=user'</script>";
        }
    }
    else
    {
        echo "<script>alert('Password dan konfirmasi tidak sama');</script>";
    }
	
}

if(isset($_POST['update']))
{
	$id_user = $_POST['id_user'];
    $nama_user = addslashes($_POST['nama_user']);
    $username = $_POST['username'];
    $password = $_POST['password'];
    $konfirmasi_password = $_POST['konfirmasi_password'];
    if($password == $konfirmasi_password)
    {
        $password = password_hash($password, PASSWORD_DEFAULT); // fungsi mengenkripsi data
        $query_update = mysqli_query($koneksi,"UPDATE user SET nama_user='$nama_user',username='$username',password='$password' WHERE id_user='$id_user'");
        if ($query_update) {
            echo "<script>window.location = 'admin.php?halaman=user'</script>";
        }
    }
    else
    {
        echo "<script>alert('Password dan konfirmasi tidak sama');</script>";
    }
	
}
if (isset($_GET['hapus_user'])) {
    $id = $_GET['hapus_user'];
    $query_hapus_user = mysqli_query($koneksi, "DELETE FROM user WHERE id_user='$id'");
    if ($query_hapus_user) {
		echo "<script>window.location = 'admin.php?halaman=user'</script>";
    }
}
?>
<div class="container-fluid">
    <h3 class="page-title">Data User</h3>
    <div class="panel panel-headline">
        <div class="panel-body">
        <!-- Modal -->
        <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Data User</h4>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="inputEmail2">Nama User </label>
                            <input type="text" name="nama_user"
                                class="form-control form-control-sm" id="inputEmail2"
                                placeholder="Masukan nama kriteria" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="inputEmail2">Username </label>
                            <input type="text" name="username"
                                class="form-control form-control-sm" id="inputEmail2"
                                placeholder="Masukan besar bobot" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="inputEmail2">Password </label>
                            <input type="password" name="password"
                                class="form-control form-control-sm" id="inputEmail2"
                                placeholder="Masukan password" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="inputEmail2">Konfirmasi Password </label>
                            <input type="password" name="konfirmasi_password"
                                class="form-control form-control-sm" id="inputEmail2"
                                placeholder="Masukan konfirmasi password" required>
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
                    <th class="text-center">Nomor</th>
                    <th class="text-center">Nama User</th>
                    <th class="text-center">Username</th>
                    <th class="text-center">Password</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no = 1;
            $query2 = mysqli_query($koneksi, "SELECT * FROM user ORDER BY id_user ASC");
            foreach ($query2 as $data2) :
                ?>
                <tr>
                    <td class="text-center"><?php echo $no++ ?></td>
                    <td><?php echo $data2['nama_user'] ?></td>
                    <td><?php echo $data2['username'] ?></td>
                    <td>xxxxx</td>
                    <td class="text-center">
                        <a style="cursor:pointer" class="btn btn-sm btn-warning text-white" data-toggle="modal"
                                data-target="#modal-edit<?= $data2['id_user'] ?>">Edit</a>
                        <a onclick="return confirm('Yakin ingin menghapus data ?')" href="?halaman=user&hapus_user=<?= $data2['id_user'] ?>" class="btn btn-sm btn-danger">Hapus</a>
                    </td> 
                </tr>
            <?php endforeach; ?>
            </tbody>
            </table>
        </div>
    </div>
</div>

<?php foreach($query2 as $data):  ?>
<div id="modal-edit<?=$data2['id_user'];?>" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Data User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="" method="POST">
			<div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="inputEmail2">Nama User </label>
                        <input type="hidden" name="id_user" value="<?php echo $data2['id_user'] ?>">
                        <input type="text" name="nama_user"
                            class="form-control form-control-sm" value="<?php echo $data2['nama_user'] ?>" id="inputEmail2"
                            placeholder="Masukan nama kriteria" required>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="inputEmail2">Username </label>
                        <input type="text" name="username"
                            class="form-control form-control-sm" value="<?php echo $data2['username'] ?>" id="inputEmail2"
                            placeholder="Masukan besar bobot" required>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="inputEmail2">Password </label>
                        <input type="password" name="password"
                            class="form-control form-control-sm" id="inputEmail2"
                            placeholder="Masukan password" required>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="inputEmail2">Konfirmasi Password </label>
                        <input type="password" name="konfirmasi_password"
                            class="form-control form-control-sm" id="inputEmail2"
                            placeholder="Masukan konfirmasi password" required>
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
