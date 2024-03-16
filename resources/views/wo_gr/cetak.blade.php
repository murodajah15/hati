@include('home.config')

<?php
$connect = session('connect');
$nm_perusahaan = session('nm_perusahaan');
$alamat_perusahaan = session('alamat');
$telp_perusahaan = session('telp');

date_default_timezone_set('Asia/Jakarta');
$id = $_GET['id'];
$no = 1;

// $queryh = mysqli_query($connect, "select * from no_gr where id='$id' and no_gr.close=1 order by nowo");
// $de = mysqli_fetch_assoc($queryh);
// $nowo = $de['nowo'];
// $tanggal = date('d-M-Y', strtotime($de['tanggal'])); //$de['tgljual']; //

$tanggal = date('d-M-Y', strtotime($wo_gr->tanggal)); //$wo_gr->tgljual']; //
$kdpemilik = $wo_gr->kdpemilik;
$nmpemilik = $wo_gr->nmpemilik;
$total = $wo_gr->total;
$keluhan = $wo_gr->keluhan;
$ppn = $wo_gr->pr_ppn;
$rp_ppn = $wo_gr->total * ($ppn / 100);
$total_no = $wo_gr->total_no;
$pemilik = $wo_gr->kdpemilik . '-' . $wo_gr->nmpemilik;

// $queryh = mysqli_query($connect, "select * from tbcustomer where kode='$kdpemilik'");
// $de = mysqli_fetch_assoc($queryh);
// $alamatcust = $de['alamat'] . ' ' . $de['kota'] . ' ' . $de['kodepos'];
// $telpcust = $de['telp1'] . ' - ' . $de['telp2'];

$alamatcust = $tbcustomer->alamat . ' ' . $tbcustomer->kota . ' ' . $tbcustomer->kodepos;
$telpcust = $tbcustomer->telp1 . ' - ' . $tbcustomer->telp2;

$html = '';

?>
@include('home.logo')
<?php
$html .= session('tampillogo');

$html .=
    '<p style="font-family: Tahoma, Verdana, Segoe, sans-serif;font-size:18px;text-align:center;margin-top:1px;margin-bottom:0px;"><u>WORK GENERAL REPAIR</u></p>
	<table border="0">
    <tr>
      <td colspan=4 style="font-size:18px;font-family: Tahoma, Verdana, Segoe, sans-serif;text-align:center;">&nbsp;&nbsp;NO.' .
    "$wo_gr->nowo" .
    '</td>
    </tr>
		<tr><td width="30" style="font-size:12px;font-family: Tahoma, Verdana, Segoe, sans-serif;text-align:left;">TIPE/TAHUN.</td><td width="280" style="font-size:14px";>: ' .
    "$tbmobil->nmtipe" .
    ' / ' .
    "$tbmobil->tahun" .
    '</td>
		<td width="380" style="font-size:14px;font-family: Tahoma, Verdana, Segoe, sans-serif;">' .
    "$nmpemilik" .
    '</td>
		<tr><td width="30" style="font-size:12px;font-family: Tahoma, Verdana, Segoe, sans-serif;">NO.POLISI </td><td width="280" style="font-size:13px";>: ' .
    "$wo_gr->nopolisi" .
    '</td>
		</td><td width="180" style="font-size:12px;font-family: Tahoma, Verdana, Segoe, sans-serif;">' .
    "$alamatcust" .
    '</td>
		<tr><td style="font-size:13px;font-family: Tahoma, Verdana, Segoe, sans-serif;">NO.RANGKA</td><td width="280" style="font-size:13px";>: ' .
    "$wo_gr->norangka" .
    '</td>
    <td style="font-size:13px;font-family: Tahoma, Verdana, Segoe, sans-serif;">' .
    "$telpcust" .
    '</td></tr></table>';

// if (count($wo_grd_jasa) > 0) {
$html .= '<br><font size=2><b>JASA PERBAIKAN</b></font><br>';
// }
$html .= '<table border="1" table-layout="fixed"; cellpadding="2"; cellspacing="1"; style="font-size:13px;font-family: Tahoma, Verdana, Segoe, sans-serif;" class="table table-striped table table-bordered;">
		<tr>
      <thead>
			<td width="30px" style="text-align:center;">NO.</td>
			<td width="100px" style="text-align:center;">PERINCIAN</td>
			<td width="410px" style="text-align:center;">KERUSAKAN</td>
			<td width="80px" style="text-align:center;">HARGA</td>
			<td width="50px" style="text-align:center;">QTY</td>
			<td width="60px" style="text-align:center;">DISC. (%)</td>
			<td width="90px" style="text-align:center;">JUMLAH</td>
		</tr></thead><tbody>';
$n = 0;
$totalsubtotal = 0;
$totalppn = 0;
$totaljasa = 0;
foreach ($wo_grd_jasa as $row) {
    $n++;
    $fharga = number_format($row['harga'], 0, ',', '.');
    $fqty = number_format($row['qty'], 0, ',', '.');
    $fpr_discount = number_format($row['pr_discount'], 2, ',', '.');
    $fsubtotal = number_format($row['subtotal'], 0, ',', '.');
    $html .=
        '<tr><td style="text-align:right">' .
        $n .
        '</td>
        <td>' .
        $row->kode .
        '</td>
        <td>' .
        $row->nama .
        '</td>
        <td style="text-align:right">' .
        $fharga .
        '</td>
        <td style="text-align:right">' .
        $fqty .
        '</td>
        <td style="text-align:right">' .
        $fpr_discount .
        '</td>
        <td style="text-align:right">' .
        $fsubtotal .
        '</td></tr>';
    $totalsubtotal = $totalsubtotal + $row->subtotal;
    $ppn = $row->subtotal * ($row->pr_ppn / 100);
    $totalppn = $totalppn + $ppn;
    $totaljasa = $totaljasa + $row->subtotal + $ppn;
}
$ftotalsubtotal = number_format($totalsubtotal, 0, ',', '.');
$ftotalppn = number_format($totalppn, 0, ',', '.');
$ftotaljasa = number_format($totaljasa, 0, ',', '.');
$html .=
    '<tr><td colspan=6 style="text-align:right">Sub Total Jasa
    <td style="text-align:right">' .
    $ftotalsubtotal .
    '</td></td></tr>
    <tr><td colspan=6 style="text-align:right">PPN
    <td style="text-align:right">' .
    $ftotalppn .
    '</td></td></tr>
    <tr><td colspan=6 style="text-align:right">Total Jasa
    <td style="text-align:right">' .
    $ftotaljasa .
    '</td></td></tr>';
$html .= '</tbody></table>';

// if (count($wo_grd_part) > 0 or count($wo_grd_bahan) > 0) {
$html .= '<font size=2><b>SPARE PART</b></font><br>';
// }
$html .= '<table border="1" table-layout="fixed"; cellpadding="2"; cellspacing="1"; style="font-size:13px;font-family: Tahoma, Verdana, Segoe, sans-serif;" class="table table-striped table table-bordered;">
		<tr>
      <thead>
			<td width="30px" style="text-align:center;">NO.</td>
			<td width="100px" style="text-align:center;">KODE PART</td>
			<td width="410px" style="text-align:center;">NAMA PART</td>
			<td width="50px" style="text-align:center;">SATUAN</td>
			<td width="80px" style="text-align:center;">HARGA</td>
			<td width="50px" style="text-align:center;">QTY</td>
			<td width="60px" style="text-align:center;">DISC. (%)</td>
			<td width="90px" style="text-align:center;">JUMLAH</td>
		</tr></thead><tbody>';
$n = 0;
$totalsubtotal = 0;
$totalppn = 0;
$totalpart = 0;
foreach ($wo_grd_part as $row) {
    $n++;
    $fharga = number_format($row['harga'], 0, ',', '.');
    $fqty = number_format($row['qty'], 0, ',', '.');
    $fpr_discount = number_format($row['pr_discount'], 2, ',', '.');
    $fsubtotal = number_format($row['subtotal'], 0, ',', '.');
    $html .=
        '<tr><td style="text-align:right">' .
        $n .
        '</td>
        <td>' .
        $row->kode .
        '</td>
        <td>' .
        $row->nama .
        '</td>
        <td style="text-align:right">' .
        $row->nmsatuan .
        '</td>
        <td style="text-align:right">' .
        $fharga .
        '</td>
        <td style="text-align:right">' .
        $fqty .
        '</td>
        <td style="text-align:right">' .
        $fpr_discount .
        '</td>
        <td style="text-align:right">' .
        $fsubtotal .
        '</td></tr>';
    $totalsubtotal = $totalsubtotal + $row->subtotal;
    $ppn = $row->subtotal * ($row->pr_ppn / 100);
    $totalppn = $totalppn + $ppn;
    $totalpart = $totalpart + $row->subtotal + $ppn;
}
foreach ($wo_grd_bahan as $row) {
    $n++;
    $fharga = number_format($row['harga'], 0, ',', '.');
    $fqty = number_format($row['qty'], 0, ',', '.');
    $fpr_discount = number_format($row['pr_discount'], 2, ',', '.');
    $fsubtotal = number_format($row['subtotal'], 0, ',', '.');
    $html .=
        '<tr><td style="text-align:right">' .
        $n .
        '</td>
        <td>' .
        $row->kode .
        '</td>
        <td>' .
        $row->nama .
        '</td>
        <td style="text-align:right">' .
        $row->nmsatuan .
        '</td>
        <td style="text-align:right">' .
        $fharga .
        '</td>
        <td style="text-align:right">' .
        $fqty .
        '</td>
        <td style="text-align:right">' .
        $fpr_discount .
        '</td>
        <td style="text-align:right">' .
        $fsubtotal .
        '</td></tr>';
    $totalsubtotal = $totalsubtotal + $row->subtotal;
    $ppn = $row->subtotal * ($row->pr_ppn / 100);
    $totalppn = $totalppn + $ppn;
    $totalpart = $totalpart + $row->subtotal + $ppn;
}
$ftotalsubtotal = number_format($totalsubtotal, 0, ',', '.');
$ftotalppn = number_format($totalppn, 0, ',', '.');
$ftotalpart = number_format($totalpart, 0, ',', '.');
$gt = $totaljasa + $totalpart;
$fgt = number_format($gt, 0, ',', '.');
$html .=
    '<tr><td colspan=7 style="text-align:right">Sub Total Spare Part
    <td style="text-align:right">' .
    $ftotalsubtotal .
    '</td></td></tr>
    <tr><td colspan=7 style="text-align:right">PPN
    <td style="text-align:right">' .
    $ftotalppn .
    '</td></td></tr>
    <tr><td colspan=7 style="text-align:right">Total Spare Part
    <td style="text-align:right">' .
    $ftotalpart .
    '</td></td></tr><tr><td colspan=7 style="text-align:right"><b>Grand Total</b>
    <td style="text-align:right"><b>' .
    $fgt .
    '</b></td></td></tr>';
$html .= '</tbody></table>';
$fown_risk = number_format($wo_gr->own_risk, 0, ',', '.');
$html .= '<br>Own Risk : Rp. ' . $fown_risk . ',-<br>';
$html .= '<font size=2><br>Jakarta, ' . date('d', strtotime($wo_gr->tanggal)) . ' ' . date('M', strtotime($wo_gr->tanggal)) . ' ' . date('Y', strtotime($wo_gr->tanggal)) . ',';
$html .=
    '<table border="1" height="15" style="font-size:13px;font-family: Tahoma, Verdana, Segoe, sans-serif;" table-layout="fixed"; cellpadding="0"; cellspacing="0"; class="table table-striped table table-bordered;">	
			<tr>
				<td width="150px" align="center"><color="black">Menyetujui</td>
				<td width="210px" align="center"><color="black">Hormat Kami</td>
				tr><tr>
			<td colspan="1"></td><td align="center"><br><br><br><br><br><br></td>
			<tr><td align="center" width="180"></td><td width="180" align="center">' .
    $nm_perusahaan .
    '</td></tr>';
$html .= '</table>';
$html .= '<br><font size=2><u>PERHATIAN :</u>';
$html .= '<br>1. Perkiraan tersebut diatas berdasarkan apa yang dapat diketahui sementara, dan dapat berubah sesuai keadaan yang sebenarnya pada saat pelaksanaan kerja perbaikan';
$html .= '<br>2. Perbaikan baru dapat dilaksanakan jika sudah ada Surat Perintah Kerja (SPK).</font>';

echo $html;
?>
