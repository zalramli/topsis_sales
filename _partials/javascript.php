<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/scripts/klorofil-common.js"></script>
<script src="assets/vendor/jquery/jquery.dataTables.min.js"></script>
<script src="assets/vendor/jquery/dataTables.bootstrap4.min.js"></script>
<script src="assets/vendor/jquery/jquery.mask.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.bobot').mask('0');
		$('.tanggal').mask('00');
		$('.tahun').mask('0000');
		$('.hp').mask('000000000000000');
		$('.total_penjualan').mask('0000');
	})
</script>
<script>
$(document).ready(function() {
    $('#example').DataTable({
        "ordering": false
    });
    $('#example2').DataTable({
        "ordering": false
    });
    $('#example3').DataTable({
        "ordering": false
    });
    $('#example4').DataTable({
        "ordering": false
    });
    $('#example5').DataTable({
        "ordering": false
    });
    $('#example6').DataTable({
        "ordering": false
    });
    $('#example7').DataTable({
        "ordering": false
    });
    $('#example8').DataTable({
        "ordering": false
    });
});
</script>