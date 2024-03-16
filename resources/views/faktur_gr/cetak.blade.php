@include('home.config')

<?php
$connect = session('connect');
$nm_perusahaan = session('nm_perusahaan');
$alamat_perusahaan = session('alamat');
$telp_perusahaan = session('telp');

date_default_timezone_set('Asia/Jakarta');
$id = $_GET['id'];
$no = 1;

// $queryh = mysqli_query($connect, "select * from no_gr where id='$id' and no_gr.close=1 order by nofaktur");
// $de = mysqli_fetch_assoc($queryh);
// $nofaktur = $de['nofaktur'];
// $tanggal = date('d-M-Y', strtotime($de['tanggal'])); //$de['tgljual']; //

$tanggal = date('d-M-Y', strtotime($faktur_gr->tanggal)); //$faktur_gr->tgljual']; //
$kdpemilik = $faktur_gr->kdpemilik;
$nmpemilik = $faktur_gr->nmpemilik;
$total = $faktur_gr->total;
$keluhan = $faktur_gr->keluhan;
$ppn = $faktur_gr->pr_ppn;
$rp_ppn = $faktur_gr->total * ($ppn / 100);
$total_no = $faktur_gr->total_no;
$pemilik = $faktur_gr->kdpemilik . '-' . $faktur_gr->nmpemilik;

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
    '<p style="font-family: Tahoma, Verdana, Segoe, sans-serif;font-size:25px;text-align:center;margin-top:1px;margin-bottom:0px;"><u>FAKTUR GENERAL REPAIR</u></p>
	<table border="0">
    </tr>
		<tr><td width="80" style="font-size:12px;font-family: Tahoma, Verdana, Segoe, sans-serif;text-align:left;">TIPE/TAHUN</td><td width="280" style="font-size:14px";>: ' .
    "$tbmobil->nmtipe" .
    ' / ' .
    "$tbmobil->tahun" .
    '</td>
		<td width="380" style="font-size:14px;font-family: Tahoma, Verdana, Segoe, sans-serif;">' .
    "$nmpemilik" .
    '</td>
		<tr><td width="80" style="font-size:12px;font-family: Tahoma, Verdana, Segoe, sans-serif;">NO.POLISI </td><td width="280" style="font-size:13px";>: ' .
    "$faktur_gr->nopolisi" .
    '</td>
		</td><td width="180" style="font-size:12px;font-family: Tahoma, Verdana, Segoe, sans-serif;">' .
    "$alamatcust" .
    '</td>
		<tr><td width="80" style="font-size:13px;font-family: Tahoma, Verdana, Segoe, sans-serif;">NO.RANGKA</td><td width="280" style="font-size:13px";>: ' .
    "$faktur_gr->norangka" .
    '</td>
    <td style="font-size:13px;font-family: Tahoma, Verdana, Segoe, sans-serif;">' .
    "$telpcust" .
    '</td></tr></table>';

$html .=
    '<table border="0"><tr><td width="80" style="font-size:12px;font-family: Tahoma, Verdana, Segoe, sans-serif;text-align:left;">NO.MESIN</td><td width="280" style="font-size:14px";>: ' .
    "$tbmobil->nomesin" .
    '</td>
    <td width="80" style="font-size:12px;font-family: Tahoma, Verdana, Segoe, sans-serif;">NO. WO</td><td width="280" style="font-size:13px";>: ' .
    "$faktur_gr->nowo" .
    '</td>
    <tr><td style="font-size:13px;font-family: Tahoma, Verdana, Segoe, sans-serif;" width="80">WARNA</td><td width="280" style="font-size:13px";>: ' .
    "$tbmobil->nmwarna" .
    '</td>
    <td width="80" style="font-size:12px;font-family: Tahoma, Verdana, Segoe, sans-serif;">NO. FAKTUR</td><td width="280" style="font-size:13px";>: ' .
    "$faktur_gr->nofaktur" .
    '</td>
    <tr><td style="font-size:13px;font-family: Tahoma, Verdana, Segoe, sans-serif;" width="80">KM</td><td width="280" style="font-size:13px";>: ' .
    "$faktur_gr->km" .
    '</td>
		<td width="80" style="font-size:12px;font-family: Tahoma, Verdana, Segoe, sans-serif;">TGL.FAKTUR</td><td width="280" style="font-size:13px";>: ' .
    "$faktur_gr->tanggal" .
    '</td>
		</tr></table>';

// if (count($faktur_grd_jasa) > 0) {
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
foreach ($faktur_grd_jasa as $row) {
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

// if (count($faktur_grd_part) > 0 or count($faktur_grd_bahan) > 0) {
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
foreach ($faktur_grd_part as $row) {
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
foreach ($faktur_grd_bahan as $row) {
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
$html .= '<br>Saran  : ' . $faktur_gr->saran;
$html .= '<br>Service Advisor  : ' . $faktur_gr->nmsa . '<br>';
$fown_risk = number_format($faktur_gr->own_risk, 0, ',', '.');
$html .= 'Own Risk : Rp. ' . $fown_risk . ',-<br><br>';
// $html .= '<font size=2><br>Jakarta, ' . date('d', strtotime($faktur_gr->tanggal)) . ' ' . date('M', strtotime($faktur_gr->tanggal)) . ' ' . date('Y', strtotime($faktur_gr->tanggal)) . ',';
$html .=
    '<table border="1" height="15" style="font-size:13px;font-family: Tahoma, Verdana, Segoe, sans-serif;" table-layout="fixed"; cellpadding="0"; cellspacing="0"; class="table table-striped table table-bordered;">	
			<tr>
				<td width="150px" align="center"><color="black">Customer</td>
				<td width="210px" align="center"><color="black">Hormat Kami</td>
				tr><tr>
			<td colspan="1"></td><td align="center"><br><br><br><br><br><br></td>
			<tr><td align="center" width="180"></td><td width="180" align="center">' .
    $nm_perusahaan .
    '</td></tr>';
$html .= '</table>';
// $html .= '<br><font size=2><u>PERHATIAN :</u>';
// $html .= '<br>1. Perkiraan tersebut diatas berdasarkan apa yang dapat diketahui sementara, dan dapat berubah sesuai keadaan yang sebenarnya pada saat pelaksanaan kerja perbaikan';
// $html .= '<br>2. Perbaikan baru dapat dilaksanakan jika sudah ada Surat Perintah Kerja (SPK).</font>';

echo $html;
?>
