<div class="container-fluid">
    <h3 class="page-title"> Evaluation Matrix (x<sub>ij</sub>)</h3>
    <div class="panel panel-headline">
        <div class="panel-body">
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
                    if(!isset($data[$row['id_karyawan']])){
                        $data[$row['id_karyawan']]=[];
                    }
                    if(!isset($data[$row['id_karyawan']][$row['nama_kriteria']])){
                        $data[$row['id_karyawan']][$row['nama_kriteria']]=[];
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
                    $data[$row['id_karyawan']][$row['nama_kriteria']] = $row['value_kriteria'];
                    $nilai_kuadrat[$row['nama_kriteria']]+=pow($row['value_kriteria'],2);
                    $kriterias[]=$row['nama_kriteria'];
                }
                
            }
            $kriteria     =array_unique($kriterias);
            $jml_kriteria =count($kriteria);
            $count_data = 0;
            ?>
            <?php 
                $count_data = count($data);
                if($count_data > 1)
                {
            ?>
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th class="text-center" width="5%" rowspan="2">No</th>
                    <th class="text-center" rowspan="2">Nama karyawan</th>
                    <th class="text-center" colspan="<?php echo $jml_kriteria;?>">KRITERIA</th>
                </tr>
                <tr>
                    <?php
                    foreach($kriteria as $k)
                    {
                    ?>
                        <th class="text-center"><?php echo $k ?></th>
                    <?php
                    }
                    ?>
                </tr>
                </thead>
                <tbody>
                    <?php
                    $i=0;
                    foreach($data as $nama=>$krit){
                    echo "<tr>
                        <td>".(++$i)."</td>
                        <td>$nama</td>";
                    foreach($kriteria as $k){
                        echo "<td align='center'>$krit[$k]</td>";
                    }
                    echo "</tr>\n";
                    }
                    ?>
                </tbody>
            </table>
            <?php } else { ?>
                <h2 class="text-center">Minimal 2 Data Karyawan</h2>
            <?php } ?>
        </div>
    </div>

    <h3 class="page-title">Rating Kinerja Ternormalisasi (r<sub>ij</sub>)</h3>
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
                    <th class="text-center" width="5%" rowspan="2">No</th>
                    <th class="text-center" rowspan="2">Nama karyawan</th>
                    <th class="text-center" colspan="<?php echo $jml_kriteria;?>">KRITERIA</th>
                </tr>
                <tr>
                    <?php
                    foreach($kriteria as $k)
                    {
                    ?>
                        <th class="text-center"><?php echo $k ?></th>
                    <?php
                    }
                    ?>
                </tr>
                </thead>
                <tbody>
                <?php
                $i=0;
                foreach($data as $nama=>$krit){
                    echo "<tr>
                    <td>".(++$i)."</td>
                    <td>{$nama}</td>";
                    foreach($kriteria as $k){
                    echo "<td align='center'>".round(($krit[$k]/sqrt($nilai_kuadrat[$k])),4)."</td>";
                    }
                    echo
                    "</tr>\n";
                }
                ?>
                </tbody>
            </table>
            <?php } else { ?>
                <h2 class="text-center">Minimal 2 Data Karyawan</h2>
            <?php } ?>
        </div>
    </div>

    <h3 class="page-title">Rating Bobot Ternormalisasi(y<sub>ij</sub>)</h3>
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
                    <th class="text-center" width="5%" rowspan="2">No</th>
                    <th class="text-center" rowspan="2">Nama karyawan</th>
                    <th class="text-center" colspan="<?php echo $jml_kriteria;?>">KRITERIA</th>
                </tr>
                <tr>
                    <?php
                    foreach($kriteria as $k)
                    {
                    ?>
                        <th class="text-center"><?php echo $k ?></th>
                    <?php
                    }
                    ?>
                </tr>
                </thead>
                <tbody>
                    <?php
                    $i=0;
                    $y=array();
                    foreach($data as $nama=>$krit){
                    echo "<tr>
                        <td>".(++$i)."</td>
                        <td>{$nama}</td>";
                    foreach($kriteria as $k){
                        $y[$k][$i-1]=round(($krit[$k]/sqrt($nilai_kuadrat[$k])),4)*$bobot[$k];
                        echo "<td align='center'>".$y[$k][$i-1]."</td>";
                    }
                    echo
                        "</tr>\n";
                    }
                    ?>
                </tbody>
            </table>
            <?php } else { ?>
                <h2 class="text-center">Minimal 2 Data Karyawan</h2>
            <?php } ?>
        </div>
    </div>

    <h3 class="page-title">Solusi Ideal positif (A<sup>+</sup>)</h3>
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
                    <th colspan='<?php echo $jml_kriteria;?>'>Kriteria</th>
                    </tr>
                    <tr>
                    <?php
                    foreach($kriteria as $k)
                        echo "<th>$k</th>\n";
                    ?>
                    </tr>
                    <tr>
                    <?php
                    for($n=1;$n<=$jml_kriteria;$n++)
                        echo "<th>y<sub>{$n}</sub><sup>+</sup></th>";
                    ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <?php
                    $yplus=array();
                    foreach($kriteria as $k){
                        $yplus[$k]=([$k]?max($y[$k]):min($y[$k]));
                        echo "<th>$yplus[$k]</th>";
                    }
                    ?>
                    </tr>
                </tbody>
            </table>
            <?php } else { ?>
                <h2 class="text-center">Minimal 2 Data Karyawan</h2>
            <?php } ?>
        </div>
    </div>

    <h3 class="page-title">Solusi Ideal negatif (A<sup>-</sup>)</h3>
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
                    <th colspan='<?php echo $jml_kriteria;?>'>Kriteria</th>
                    </tr>
                    <tr>
                    <?php
                    foreach($kriteria as $k)
                        echo "<th>{$k}</th>\n";
                    ?>
                    </tr>
                    <tr>
                    <?php
                    for($n=1;$n<=$jml_kriteria;$n++)
                        echo "<th>y<sub>{$n}</sub><sup>-</sup></th>";
                    ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <?php
                    $ymin=array();
                    foreach($kriteria as $k){
                        $ymin[$k]=[$k]?min($y[$k]):max($y[$k]);
                        echo "<th>{$ymin[$k]}</th>";
                    }
                    ?>
                    </tr>
                </tbody>
            </table>
            <?php } else { ?>
                <h2 class="text-center">Minimal 2 Data Karyawan</h2>
            <?php } ?>
        </div>
    </div>

    <h3 class="page-title">Jarak positif (D<sub>i</sub><sup>+</sup>)</h3>
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
                    <th>No</th>
                    <th>Nama</th>
                    <th>D<suo>+</sup></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i=0;
                    $dplus=array();
                    foreach($data as $nama=>$krit){
                    echo "<tr>
                        <td>".(++$i)."</td>
                        <td>{$nama}</td>";
                    foreach($kriteria as $k){
                        if(!isset($dplus[$i-1])) $dplus[$i-1]=0;
                        $dplus[$i-1]+=pow($yplus[$k]-$y[$k][$i-1],2);
                    }
                    echo "<td>".round(sqrt($dplus[$i-1]),6)."</td>
                        </tr>\n";
                    }
                    ?>
                </tbody>
            </table>
            <?php } else { ?>
                <h2 class="text-center">Minimal 2 Data Karyawan</h2>
            <?php } ?>
        </div>
    </div>

    <h3 class="page-title">Jarak negatif (D<sub>i</sub><sup>-</sup>)</h3>
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
                    <th>No</th>
                    <th>Nama</th>
                    <th>D<suo>-</sup></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i=0;
                    $dmin=array();
                    foreach($data as $nama=>$krit){
                    echo "<tr>
                        <td>".(++$i)."</td>
                        <td>{$nama}</td>";
                    foreach($kriteria as $k){
                        if(!isset($dmin[$i-1]))$dmin[$i-1]=0;
                        $dmin[$i-1]+=pow($ymin[$k]-$y[$k][$i-1],2);
                    }
                    echo "<td>".round(sqrt($dmin[$i-1]),6)."</td>
                        </tr>\n";
                    }
                    ?>
                </tbody>
            </table>
            <?php } else { ?>
                <h2 class="text-center">Minimal 2 Data Karyawan</h2>
            <?php } ?>
        </div>
    </div>

    <h3 class="page-title">Nilai Preferensi(V<sub>i</sub>)</h3>
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
                    <th>No</th>
                    <th>Nama</th>
                    <th>V<sub>i</sub></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i=0;
                    $V=array();
                    foreach($data as $nama=>$krit){
                    echo "<tr>
                        <td>".(++$i)."</td>
                        <td>{$nama}</td>";
                    foreach($kriteria as $k){
                        $V[$i-1]=$dmin[$i-1]/($dmin[$i-1]+$dplus[$i-1]);
                    }
                    echo "<td>{$V[$i-1]}</td></tr>\n";
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