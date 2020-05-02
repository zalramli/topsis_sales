<?php 
    $query = mysqli_query($koneksi, "SELECT * FROM detail_karyawan JOIN karyawan USING(id_karyawan) JOIN kriteria USING (id_kriteria)");
    $jumlah_batas = mysqli_num_rows($query);
    $data      = [];
    $kriterias = [];
    $bobot     = [];
    $atribut     = [];
    $nilai_kuadrat = [];
    if ($query) {
        foreach($query as $row)
        {
            if(!isset($data[$row['nama_karyawan_detail']])){
                $data[$row['nama_karyawan_detail']]=[];
            }
            if(!isset($data[$row['nama_karyawan_detail']][$row['nama_kriteria']])){
                $data[$row['nama_karyawan_detail']][$row['nama_kriteria']]=[];
            }

            if(!isset($nilai_kuadrat[$row['nama_kriteria']])){
                $nilai_kuadrat[$row['nama_kriteria']]=0;
            }

            
            if($row['nama_kriteria'] == "Lama Kerja")
            {
                date_default_timezone_set("Asia/Jakarta");
                $tgl_diterima = date("Y-m-d",strtotime($row['value_kriteria']));
                $sekarang = date("Y-m-d");
                $selisih = ((strtotime ($sekarang) - strtotime ($tgl_diterima
                ))/(60*60*24));
                $row['value_kriteria'] = (int) $selisih;
            }
            $bobot[$row['nama_kriteria']]=$row['bobot'];
            $atribut[$row['nama_kriteria']]=$row['atribut'];
            $data[$row['nama_karyawan_detail']][$row['nama_kriteria']] = $row['value_kriteria'];
            $nilai_kuadrat[$row['nama_kriteria']]+=pow($row['value_kriteria'],2);
            $kriterias[]=$row['nama_kriteria'];
        }
        
    }
    $kriteria     =array_unique($kriterias);
    $jml_kriteria =count($kriteria);

    $i=0;
    foreach($data as $nama => $krit)
    {
        ++$i;
        foreach($kriteria as $k){
            round(($krit[$k]/sqrt($nilai_kuadrat[$k])),3);
        }
    }

    $i=0;
    $y=[];
    foreach($data as $nama => $krit)
    {
        ++$i;
        foreach($kriteria as $k)
        {
            $y[$k][$i-1]=round(($krit[$k]/sqrt($nilai_kuadrat[$k])),3)*$bobot[$k];
        }
    }

    $yplus=[];
    foreach($kriteria as $k){
        if($atribut[$k] == "Benefit")
        {
            $yplus[$k]=([$k]?max($y[$k]):min($y[$k]));
        }
        else 
        {
            $yplus[$k]=([$k]?min($y[$k]):max($y[$k]));

        }
    }

    $ymin=[];
    foreach($kriteria as $k){
        if($atribut[$k] == "Cost")
        {
            $ymin[$k]=[$k]?max($y[$k]):min($y[$k]);
        }
        else 
        {
            $ymin[$k]=[$k]?min($y[$k]):max($y[$k]);
        }
    }

    $i=0;
    $dplus=[];
    foreach($data as $nama => $krit)
    {
        ++$i;
        foreach($kriteria as $k)
        {
            if(!isset($dplus[$i-1])) 
                $dplus[$i-1]=0;
                $dplus[$i-1]+=pow($yplus[$k]-$y[$k][$i-1],2);
        }
    }
    $i=0;
    $dmin=[];
    foreach($data as $nama => $krit)
    {
        ++$i;
        foreach($kriteria as $k)
        {
            if(!isset($dmin[$i-1]))$dmin[$i-1]=0;
            $dmin[$i-1]+=pow($ymin[$k]-$y[$k][$i-1],2);
        }
    }
    $count_data = 0;

?>
<div class="container-fluid">
    <h3 class="page-title"> Prioritas Kelayakan Kenaikan Gaji Karyawan</h3>
    <div class="panel panel-headline">
        <div class="panel-body">
            <?php 
                $count_data = count($data);
                if($count_data > 1)
                {
            ?>
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama Karyawan</th>
                        <th>No Hp</th>
                        <th>V<sub>i</sub></th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $i=0;
                    $V=[];
                    $nama_karyawan = NULL;
                    $no_hp = NULL;
        
                    foreach($data as $nama => $krit)
                    {
                        ++$i;
                    ?>
                    <?php 
                        foreach($kriteria as $k)
                        {
                            $V[$i-1]=sqrt($dmin[$i-1])/(sqrt($dmin[$i-1])+sqrt($dplus[$i-1]));
                        }
                        $preferensi = round($V[$i-1],3);
                        $tampung_array[] = ["nama_barang" => $nama,"nilai" => $preferensi];
                        
                        ?>
                    <?php
                    }

                    // Mengurutkan array dari kecil ke besar
                    function cmp($a, $b)
                    {
                        return strcmp($a["nilai"], $b["nilai"]);
                    }
                    usort($tampung_array, "cmp");
                    // Di balik
                    $tampung_array = array_reverse($tampung_array);
                ?>
                    <?php
                        $no = 1; 
                        foreach($tampung_array as $tampil)
                        {
                            $nama = $tampil['nama_barang'];
                            $explode = explode(",",$tampil['nama_barang']);
                            $nama_karyawan = $explode[0];
                            $no_hp = $explode[1];
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $no++."." ?></td>
                        <td><?php echo stripcslashes($nama_karyawan) ?></td>
                        <td><?php echo $no_hp ?></td>
                        <td><?php echo $tampil['nilai'] ?></td>
                    </tr>
                    <?php 
                        }
                    ?>
                </tbody>
            </table>
            <?php } else { ?>
            <h2 class="text-center">Minimal 2 Data Karyawan</h2>
            <?php } ?>
        </div>
    </div>
</div>