<form method='get' action='rkasir_keluar_export'>
    @csrf
    <?php
    $tgl1 = $tanggal1;
    $tgl2 = $tanggal2;
    $no = 1;
    ?>
    <input type="hidden" name="semuaperiode" value="<?= $semuaperiode ?>">
    <input type="hidden" name="tanggal1" value="<?= $tanggal1 ?>">
    <input type="hidden" name="tanggal2" value="<?= $tanggal2 ?>">
    <input type="hidden" name="tgl1" value="<?= $tanggal1 ?>">
    <input type="hidden" name="tgl2" value="<?= $tanggal2 ?>">
    <input type="hidden" name="groupingsupplier" value="<?= $groupingsupplier ?>">
    <input type="hidden" name="semuasupplier" value="<?= $semuasupplier ?>">
    <input type="hidden" name="kdsupplier" value="<?= $kdsupplier ?>">
    <input type="hidden" name="nmsupplier" value="<?= $nmsupplier ?>">
    <button type='submit' class='btn btn-danger'>Export ke Excel</button>
    <button type='button' class='btn btn-danger' onClick="window.print()">Print</button>
</form>

@include('report.rkasir_keluar_view')
