<?php 

if(isset($_POST['simpan']))
{

    $sql = mysqli_query($koneksi, "SELECT max(id_karyawan) FROM karyawan");
    $kode_faktur = mysqli_fetch_array($sql);
    if ($kode_faktur) {
        $nilai = substr($kode_faktur[0], 1);
        $kode = (int) $nilai;
        //tambahkan sebanyak + 1
        $kode = $kode + 1;
        $id_karyawan = "K" . str_pad($kode, 4, "0",  STR_PAD_LEFT);
    } else {
        $id_karyawan = "K0001";
    }
    $nama_karyawan = addslashes($_POST['nama_karyawan']);
    $tgl_diterima = $_POST['tahun']."-".$_POST['bulan']."-".$_POST['tanggal'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $query_insert = mysqli_query($koneksi, "INSERT INTO karyawan (id_karyawan,nama_karyawan,tgl_diterima,alamat,no_hp) VALUES ('$id_karyawan','$nama_karyawan','$tgl_diterima','$alamat','$no_hp') ");
    if ($query_insert) {
        date_default_timezone_set('Asia/Jakarta');
        $value_kriteria = [];
        $tampil_kriteria = mysqli_query($koneksi,"SELECT * FROM kriteria");
        $sekarang = date("Y-m-d");
        $selisih = ((strtotime ($sekarang) - strtotime ($tgl_diterima))/(60*60*24));
        $lama_kerja = (int) $selisih;
        $absensi_temp = $lama_kerja / 7;
        $absensi = round($absensi_temp);
        $total_absensi = $lama_kerja - $absensi;
        $value_kriteria = [$tgl_diterima,0,$total_absensi];
        $nama_karyawan_detail_temp = $_POST['nama_karyawan'].",".$no_hp.",".$id_karyawan;
        $nama_karyawan_detail = addslashes($nama_karyawan_detail_temp);
            for($i=0;$i<3;$i++)
            {
                $data_kriteria = mysqli_fetch_array($tampil_kriteria);
                $id_kriteria = $data_kriteria['id_kriteria'];
                $query_insert_detail = mysqli_query($koneksi, "INSERT INTO detail_karyawan (id_detail_karyawan,id_karyawan,id_kriteria,nama_karyawan_detail,value_kriteria) VALUES (NULL,'$id_karyawan','$id_kriteria','$nama_karyawan_detail','$value_kriteria[$i]') ");
                if($query_insert_detail)
                {
                    echo "<script>window.location = 'admin.php?halaman=karyawan'</script>";
                }
            }
        
        }
        
    }

if(isset($_GET['hapus_karyawan']))
{
    $id_karyawan = $_GET['hapus_karyawan'];
    $query_delete = mysqli_query($koneksi,"DELETE FROM karyawan WHERE id_karyawan='$id_karyawan'");
    if($query_delete)
    {
        $query_delete2 = mysqli_query($koneksi,"DELETE FROM detail_karyawan WHERE id_karyawan='$id_karyawan'");
        if($query_delete2)
        {
            echo "<script>window.location = 'admin.php?halaman=karyawan'</script>";
        }
    }
}

if(isset($_POST['update']))
{
    $id_karyawan = $_POST['id_karyawan'];
    $nama_karyawan = addslashes($_POST['nama_karyawan']);
    $tgl_diterima = $_POST['tahun']."-".$_POST['bulan']."-".$_POST['tanggal'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $query_update = mysqli_query($koneksi,"UPDATE karyawan SET nama_karyawan='$nama_karyawan',tgl_diterima='$tgl_diterima',alamat='$alamat',no_hp='$no_hp' WHERE id_karyawan='$id_karyawan'");
    if ($query_update) {
        // berisi implode
        $nama_karyawan_detail_temp = $_POST['nama_karyawan'].",".$no_hp.",".$id_karyawan;
        $nama_karyawan_detail = addslashes($nama_karyawan_detail_temp);
        $query_update2 = mysqli_query($koneksi,"UPDATE detail_karyawan SET nama_karyawan_detail='$nama_karyawan_detail' WHERE id_karyawan='$id_karyawan'");
        if($query_update2)
        {
            echo "<script>window.location = 'admin.php?halaman=karyawan'</script>";
        }
    }
}
?>
<div class="container-fluid">
    <h3 class="page-title">Data Karyawan</h3>
    <div class="panel panel-headline">
        <div class="panel-body">
        <!-- Modal -->
        <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Data Karyawan</h4>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="inputEmail2">Nama Karyawan </label>
                                <input type="text" name="nama_karyawan"
                                class="form-control form-control-sm" id="inputEmail2"
                                placeholder="Masukan nama karyawan" required>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="inputEmail2">Tanggal Diterima (e.g : 03 April 2020)</label>
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <input type="text" name="tanggal" class="form-control form-control-sm tanggal" id="inputEmail2" placeholder="Tanggal" required>
                                    </div>
                                    <div class="form-group col-sm-5">
                                        <select name="bulan" id="" class="form-control form-control-sm" id="inputEmail2">
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4">
                                    <input type="text" name="tahun" class="form-control form-control-sm tahun" id="inputEmail2" placeholder="Tahun" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="inputEmail2">Alamat </label>
                                <textarea name="alamat" placeholder="Masukan alamat" class="form-control form-control-sm" id="inputEmail2" cols="30" rows="5" required></textarea>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="inputEmail2">No Hp </label>
                                <input type="text" name="no_hp"
                                class="form-control form-control-sm hp" id="inputEmail2"
                                placeholder="Masukan nomor hp" required>
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
                    <th class="text-center">Nama Karyawan</th>
                    <th class="text-center">Tanggal Diterima</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center">No Hp</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no = 1;
            $query = mysqli_query($koneksi, "SELECT * FROM karyawan ORDER BY nama_karyawan ASC");
            foreach ($query as $data) :
            ?>
                <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $data['nama_karyawan'] ?></td>
                    <td><?php echo date('d-m-Y',strtotime($data['tgl_diterima'])) ?></td>
                    <td><?php echo $data['alamat'] ?></td>
                    <td><?php echo $data['no_hp'] ?></td>
                    <td class="text-center">
                        <a style="cursor:pointer" class="btn btn-sm btn-warning text-white" data-toggle="modal"
                                data-target="#modal-edit<?= $data['id_karyawan'] ?>">Edit</a>
                        <a onclick="return confirm('Yakin ingin menghapus data ?')" href="?halaman=karyawan&hapus_karyawan=<?= $data['id_karyawan'] ?>" class="btn btn-sm btn-danger">Hapus</a>
                    </td> 
                </tr>
            <?php endforeach; ?>
            </tbody>
            </table>
        </div>
    </div>
</div>

<?php foreach($query as $data):  ?>
<div id="modal-edit<?=$data['id_karyawan'];?>" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Data Karyawan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="" method="POST">
			<div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="inputEmail2">Nama Karyawan </label>
                                <input type="hidden" name="id_karyawan" value="<?php echo $data['id_karyawan'] ?>">
                                <input type="text" name="nama_karyawan"
                                class="form-control form-control-sm" id="inputEmail2"
                                placeholder="Masukan nama karyawan" value="<?php echo $data['nama_karyawan'] ?>" required>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="inputEmail2">Tanggal Diterima </label>
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                            <?php 
                                            $tanggal = date('d',strtotime($data['tgl_diterima']));
                                            $bulan = date('m',strtotime($data['tgl_diterima']));
                                            $tahun = date('Y',strtotime($data['tgl_diterima']));
                                            ?>
                                        <input type="text" name="tanggal" class="form-control form-control-sm" id="inputEmail2" placeholder="Tanggal" value="<?php echo $tanggal ?>" readonly>

                                    </div>
                                    <div class="form-group col-sm-5">
                                        <select name="bulan" id="" class="form-control form-control-sm" id="inputEmail2" readonly>
                                        <option value="01" <?php if($bulan == "01"){echo"selected";} else{echo"disabled";} ?>>Januari</option>
                                        <option value="02" <?php if($bulan == "02"){echo"selected";} else{echo"disabled";} ?>>Februari</option>
                                        <option value="03" <?php if($bulan == "03"){echo"selected";} else{echo"disabled";} ?>>Maret</option>
                                        <option value="04" <?php if($bulan == "04"){echo"selected";} else{echo"disabled";} ?>>April</option>
                                        <option value="05" <?php if($bulan == "05"){echo"selected";} else{echo"disabled";} ?>>Mei</option>
                                        <option value="06" <?php if($bulan == "06"){echo"selected";} else{echo"disabled";} ?>>Juni</option>
                                        <option value="07" <?php if($bulan == "07"){echo"selected";} else{echo"disabled";} ?>>Juli</option>
                                        <option value="08" <?php if($bulan == "08"){echo"selected";} else{echo"disabled";} ?>>Agustus</option>
                                        <option value="09" <?php if($bulan == "09"){echo"selected";} else{echo"disabled";} ?>>September</option>
                                        <option value="10" <?php if($bulan == "10"){echo"selected";} else{echo"disabled";} ?>>Oktober</option>
                                        <option value="11" <?php if($bulan == "11"){echo"selected";} else{echo"disabled";} ?>>November</option>
                                        <option value="12" <?php if($bulan == "12"){echo"selected";} else{echo"disabled";} ?>>Desember</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4">
                                    <input type="text" value="<?php echo $tahun ?>" name="tahun" class="form-control form-control-sm" id="inputEmail2" placeholder="Masukan nomor hp" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="inputEmail2">Alamat </label>
                                <textarea name="alamat" placeholder="Masukan alamat" class="form-control form-control-sm" id="inputEmail2" cols="30" rows="5" required><?php echo $data['alamat'] ?></textarea>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="inputEmail2">No Hp </label>
                                <input type="text" value="<?php echo $data['no_hp'] ?>" name="no_hp"
                                class="form-control form-control-sm hp" id="inputEmail2"
                                placeholder="Masukan nomor hp" required>
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
