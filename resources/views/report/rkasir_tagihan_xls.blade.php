<form method='get' action='rkasir_tagihan_export'>
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
    <input type="hidden" name="nmkasir" value="<?= $nmkasir ?>">
    <input type="hidden" name="carabayar" value="<?= $carabayar ?>">
    <input type="hidden" name="groupingcarabayar" value="<?= $groupingcarabayar ?>">
    <input type="hidden" name="groupingcustomer" value="<?= $groupingcustomer ?>">
    <input type="hidden" name="semuacustomer" value="<?= $semuacustomer ?>">
    <input type="hidden" name="kdcustomer" value="<?= $kdcustomer ?>">
    <input type="hidden" name="nmcustomer" value="<?= $nmcustomer ?>">
    <button type='submit' class='btn btn-danger'>Export ke Excel</button>
    <button type='button' class='btn btn-danger' onClick="window.print()">Print</button>
</form>

@include('report.rkasir_tagihan_view')
