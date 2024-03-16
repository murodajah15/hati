@include('home.config')

<?php
$connect = session('connect');
$nm_perusahaan = $saplikasi->nm_perusahaan;
$alamat_perusahaan = $saplikasi->alamat;
$telp_perusahaan = $saplikasi->telp;

date_default_timezone_set('Asia/Jakarta');

$tgl1 = date('Y-m-d', strtotime($tanggal1));
$tgl2 = date('Y-m-d', strtotime($tanggal2));
$no = 1;

if ($semuasupplier != 'Y') {
    echo 'supplier : ' . $kdsupplier . ' - ' . $nmsupplier;
} else {
    $kdsupplier = '';
}

$tgl = $semuaperiode == 'Y' ? 'Semua Periode' : $tgl1 . ' s/d ' . $tgl2;

if ($bulanan != 'Bulanan') {
    if ($semuaperiode == 'Y') {
        $tgl = 'Semua Periode';
        if ($semuasupplier == 'Y') {
            $queryh = mysqli_query($connect, "select nobeli,tglbeli,nobeli,kdsupplier,nmsupplier,noinvoice,tglinvoice,carabayar,total,sudahbayar,kurangbayar from belih where proses='Y' order by tglbeli");
        } else {
            $queryh = mysqli_query($connect, "select nobeli,tglbeli,nobeli,kdsupplier,nmsupplier,noinvoice,tglinvoice,carabayar,total,sudahbayar,kurangbayar from belih where proses='Y' and kdsupplier='$kdsupplier' order by tglbeli");
        }
    } else {
        $tgl = $tgl1 . ' s/d ' . $tgl2;
        if ($semuasupplier == 'Y') {
            $queryh = mysqli_query($connect, "select nobeli,tglbeli,nobeli,kdsupplier,nmsupplier,noinvoice,tglinvoice,carabayar,total,sudahbayar,kurangbayar from belih  where proses='Y' and (tglbeli>='$tgl1' and tglbeli<='$tgl2') order by tglbeli");
        } else {
            $queryh = mysqli_query($connect, "select nobeli,tglbeli,nobeli,kdsupplier,nmsupplier,noinvoice,tglinvoice,carabayar,total,sudahbayar,kurangbayar from belih  where proses='Y' and (tglbeli>='$tgl1' and tglbeli<='$tgl2') and kdsupplier='$kdsupplier' order by tglbeli");
        }
    }

    $cek = mysqli_num_rows($queryh);
    if (empty($cek)) {
        echo '<script>
            alert(\'Tidak Ada sesuai kriteria\')
                    window.close()
        </script>';
    }
    echo '<style>
        td { border: 0.5px solid grey; margin: 5px;}
              th { border: 0.5px solid grey; font-weight:normal;}
              body { font-family: comic sans ms;}
      </style>
    <font size="1" face="comic sans ms">
    ' .
        "<b><font size='3'>$nm_perusahaan</font></b>" .
        '
    <br>' .
        "$alamat_perusahaan" .
        '
    <br>' .
        "$telp_perusahaan" .
        '</font>
    <font size="2"><br>LAPORAN HARIAN HUTANG
    <br>Tanggal : ' .
        "$tgl" .
        '
    <br></br></font>';

    if ($semuasupplier == 'Y') {
        if ($groupingsupplier == 'Y') {
            if ($semuaperiode == 'Y') {
                $tgl = 'Semua Periode';
                if ($semuasupplier == 'Y') {
                    $queryh = mysqli_query($connect, "select nobeli,tglbeli,nobeli,kdsupplier,nmsupplier,noinvoice,tglinvoice,carabayar,total,sudahbayar,kurangbayar from belih where proses='Y' group by kdsupplier order by kdsupplier");
                } else {
                    $queryh = mysqli_query($connect, "select nobeli,tglbeli,nobeli,kdsupplier,nmsupplier,noinvoice,tglinvoice,carabayar,total,sudahbayar,kurangbayar from belih where proses='Y' and kdsupplier='$kdsupplier' group by kdsupplier order by kdsupplier");
                }
            } else {
                $tgl = $tgl1 . ' s/d ' . $tgl2;
                if ($semuasupplier == 'Y') {
                    $queryh = mysqli_query($connect, "select nobeli,tglbeli,nobeli,kdsupplier,nmsupplier,noinvoice,tglinvoice,carabayar,total,sudahbayar,kurangbayar from belih  where proses='Y' and (tglbeli>='$tgl1' and tglbeli<='$tgl2') group by kdsupplier order by kdsupplier");
                } else {
                    $queryh = mysqli_query($connect, "select nobeli,tglbeli,nobeli,kdsupplier,nmsupplier,noinvoice,tglinvoice,carabayar,total,sudahbayar,kurangbayar from belih  where proses='Y' and (tglbeli>='$tgl1' and tglbeli<='$tgl2') and kdsupplier='$kdsupplier' group by kdsupplier order by kdsupplier");
                }
            }
            echo '<table table-layout="fixed"; cellpadding="2"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
      <tr>
        <th width="30px" height="20"><font size="1" color="black">NO.</th>
        <th width="100px"><font size="1" color="black">NO. BELI</th>
        <th width="75px"><font size="1" color="black">TGL. BELI</th>
        <th width="140px"><font size="1" color="black">NO. INVOICE</th>
        <th width="75px"><font size="1" color="black">TGL. INVOICE</th>
        <th width="90px"><font size="1" color="black">CARA BAYAR</th>
        <th width="100px"><font size="1" color="black">HUTANG</th>
        <th width="100px"><font size="1" color="black">BAYAR</th>
        <th width="100px"><font size="1" color="black">SISA</th>
      </tr>';
            $gtsisa_hutang = 0;
            $gthutang = 0;
            $gtbayar = 0;
            while ($row = mysqli_fetch_assoc($queryh)) {
                $nobeli = $row['nobeli'];
                $kdsupplier = $row['kdsupplier'];
                $supplier = $row['kdsupplier'] . ' - ' . $row['nmsupplier'];
                echo '<tr>
     <td style="text-align:center;color:blue;">' .
                    $no .
                    '</td>
     <td colspan=11 style="color:blue;">' .
                    $supplier .
                    '</td>
    </tr>';
                $nobeli = $row['nobeli'];
                if ($semuaperiode == 'Y') {
                    $tgl = 'Semua Periode';
                    $queryd = mysqli_query($connect, "select * from belih where proses='Y' and kdsupplier='$kdsupplier' order by tglbeli");
                } else {
                    $tgl = $tgl1 . ' s/d ' . $tgl2;
                    $queryd = mysqli_query($connect, "select * from belih where proses='Y' and (tglbeli>='$tgl1' and tglbeli<='$tgl2') and kdsupplier='$kdsupplier' order by tglbeli");
                }
                $nno = 1;
                $totalhutang = 0;
                $totalsisa_hutang = 0;
                $totalbayar = 0;
                while ($rowd = mysqli_fetch_assoc($queryd)) {
                    $hutang = number_format($rowd['total'], 0, '.', ',');
                    $sudahbayar = number_format($rowd['sudahbayar'], 0, '.', ',');
                    $kurangbayar = number_format($rowd['kurangbayar'], 0, '.', ',');
                    // $tglbeli = date('d-m-Y', strtotime($rowd['tglbeli']));
                    $tglbeli = $row['tglbeli'];
                    // $tglinvoice = date('d-m-Y', strtotime($rowd['tglinvoice']));
                    $tglinvoice = $rowd['tglinvoice'];
                    echo '<tr>
            <td width="30px"  align="center">' .
                        $nno .
                        '</td>
            <td>&nbsp;' .
                        $rowd['nobeli'] .
                        '</td>
            <td>&nbsp;' .
                        $tglbeli .
                        '</td>
            <td>&nbsp;' .
                        $rowd['noinvoice'] .
                        '</td>
            <td>&nbsp;' .
                        $tglinvoice .
                        '</td>
            <td>&nbsp;' .
                        $rowd['carabayar'] .
                        '</td>
            <td align="right">' .
                        $hutang .
                        '</td>
            <td align="right">' .
                        $sudahbayar .
                        '</td>
            <td align="right">' .
                        $kurangbayar .
                        '</td>
          </tr>';
                    $nno++;
                    $totalsisa_hutang = $totalsisa_hutang + $rowd['kurangbayar'];
                    $totalhutang = $totalhutang + $rowd['total'];
                    $totalbayar = $totalbayar + $rowd['sudahbayar'];
                    $gtsisa_hutang = $gtsisa_hutang + $rowd['kurangbayar'];
                    $gthutang = $gthutang + $rowd['total'];
                    $gtbayar = $gtbayar + $rowd['sudahbayar'];
                }
                $no++;
                $totalsisa_hutangf = number_format($totalsisa_hutang, 0, '.', ',');
                $totalhutangf = number_format($totalhutang, 0, '.', ',');
                $totalbayarf = number_format($totalbayar, 0, '.', ',');
                echo '<tr><td colspan="6"  align="left">&nbsp;' .
                    'Total' .
                    '&nbsp;</td>
        <td  align="right">' .
                    $totalhutangf .
                    '</td>
        <td  align="right">' .
                    $totalbayarf .
                    '</td>
        <td  align="right">' .
                    $totalsisa_hutangf .
                    '</td>';
                echo '</tr>';
            }
            if ($semuasupplier == 'Y') {
                $gtsisa_hutangf = number_format($gtsisa_hutang, 0, '.', ',');
                $gthutangf = number_format($gthutang, 0, '.', ',');
                $gtbayarf = number_format($gtbayar, 0, '.', ',');
                echo '<tr><td colspan="6"  align="left">&nbsp;' .
                    'Grand  Total' .
                    '&nbsp;</td>
          <td  align="right">' .
                    $gthutangf .
                    '</td>
          <td  align="right">' .
                    $gtbayarf .
                    '</td>
          <td  align="right">' .
                    $gtsisa_hutangf .
                    '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<table table-layout="fixed"; cellpadding="2"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
      <tr>
        <th width="30px" height="20"><font size="1" color="black">NO.</th>
        <th width="100px"><font size="1" color="black">NO. BELI</th>
        <th width="75px"><font size="1" color="black">TGL. BELI</th>
        <th width="140px"><font size="1" color="black">NO. INVOICE</th>
        <th width="75px"><font size="1" color="black">TGL. INVOICE</th>
        <th width="300px"><font size="1" color="black">SUPPLIER</th>
        <th width="90px"><font size="1" color="black">CARA BAYAR</th>
        <th width="100px"><font size="1" color="black">HUTANG</th>
        <th width="100px"><font size="1" color="black">BAYAR</th>
        <th width="100px"><font size="1" color="black">SISA</th>
      </tr>';
            $totalhutang = 0;
            $totalsisa_hutang = 0;
            $totalbayar = 0;
            while ($row = mysqli_fetch_assoc($queryh)) {
                //$subtotal_ppn = $rowd['subtotal'] - ($rowd['subtotal'] * ($row['ppn']/100));
                $hutang = number_format($row['total'], 0, '.', ',');
                $sudahbayar = number_format($row['sudahbayar'], 0, '.', ',');
                $kurangbayar = number_format($row['kurangbayar'], 0, '.', ',');
                // $tglbeli = date('d-m-Y', strtotime($row['tglbeli']));
                $tglbeli = $row['tglbeli'];
                // $tglinvoice = date('d-m-Y', strtotime($row['tglinvoice']));
                $tglinvoice = $row['tglinvoice'];
                echo '<tr>
        <td width="30px"  align="center">' .
                    $no .
                    '</td>
        <td>&nbsp;' .
                    $row['nobeli'] .
                    '</td>
        <td>&nbsp;' .
                    $tglbeli .
                    '</td>
        <td>&nbsp;' .
                    $row['noinvoice'] .
                    '</td>
        <td>&nbsp;' .
                    $tglinvoice .
                    '</td>
          <td>&nbsp;' .
                    $row['kdsupplier'] .
                    ' - ' .
                    $row['nmsupplier'] .
                    '</td>
          <td>&nbsp;' .
                    $row['carabayar'] .
                    '</td>
          <td align="right">' .
                    $hutang .
                    '</td>
        <td align="right">' .
                    $sudahbayar .
                    '</td>
        <td align="right">' .
                    $kurangbayar .
                    '</td>
      </tr>';
                $no++;
                $totalsisa_hutang = $totalsisa_hutang + $row['kurangbayar'];
                $totalhutang = $totalhutang + $row['total'];
                $totalbayar = $totalbayar + $row['sudahbayar'];
            }
            $totalhutang = number_format($totalhutang, 0, '.', ',');
            $totalsisa_hutang = number_format($totalsisa_hutang, 0, '.', ',');
            $totalbayar = number_format($totalbayar, 0, '.', ',');
            echo '<tr><td colspan="7"  align="left">&nbsp;' .
                'Total' .
                '&nbsp;</td>
    <td  align="right">' .
                $totalhutang .
                '</td>
    <td  align="right">' .
                $totalbayar .
                '</td>
    <td  align="right">' .
                $totalsisa_hutang .
                '</td>';
            echo '</tr>';
        }
    } else {
        echo 'Persupplier : ' . $kdsupplier . ' - ' . $nmsupplier;
        echo '<table table-layout="fixed"; cellpadding="2"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
   <tr>
    <th width="30px" height="20"><font size="1" color="black">NO.</th>
        <th width="95px"><font size="1" color="black">NO. PEMBELIAN</th>
    <th width="80px"><font size="1" color="black">TANGGAL</th>
        <th width="95px"><font size="1" color="black">NO. INVOICE</th>
        <th width="75px"><font size="1" color="black">TANGGAL<br>INVOICE</th>
    <th width="100px"><font size="1" color="black">CARA BAYAR</th>
    <th width="100px"><font size="1" color="black">HUTANG</th>
    <th width="100px"><font size="1" color="black">BAYAR</th>
    <th width="100px"><font size="1" color="black">SISA</th>
   </tr>';

        $totalhutang = 0;
        $totalsisa_hutang = 0;
        $totalbayar = 0;
        while ($row = mysqli_fetch_assoc($queryh)) {
            //$subtotal_ppn = $rowd['subtotal'] - ($rowd['subtotal'] * ($row['ppn']/100));
            $hutang = number_format($row['total'], 0, '.', ',');
            $sudahbayar = number_format($row['sudahbayar'], 0, '.', ',');
            $kurangbayar = number_format($row['kurangbayar'], 0, '.', ',');
            // $tglbeli = date('d-m-Y', strtotime($row['tglbeli']));
            $tglbeli = $row['tglbeli'];
            // $tglinvoice = date('d-m-Y', strtotime($row['tglinvoice']));
            $tglinvoice = $row['tglinvoice'];
            echo '<tr>
        <td width="30px"  align="center">' .
                $no .
                '</td>
        <td>&nbsp;' .
                $row['nobeli'] .
                '</td>
        <td>&nbsp;' .
                $tglbeli .
                '</td>
        <td>&nbsp;' .
                $row['noinvoice'] .
                '</td>
        <td>&nbsp;' .
                $tglinvoice .
                '</td>
        <td>&nbsp;' .
                $row['carabayar'] .
                '</td>';
            // <td align="right">&nbsp;' . $hutang . '&nbsp;</td>
            // <td align="right">&nbsp;' . $sudahbayar . '&nbsp;</td>
            // <td align="right">&nbsp;' . $kurangbayar . '&nbsp;</td>
            echo '<td align="right">' .
                $hutang .
                '</td>
        <td align="right">' .
                $sudahbayar .
                '</td>
        <td align="right">' .
                $kurangbayar .
                '</td>
      </tr>';
            $no++;
            $totalsisa_hutang = $totalsisa_hutang + $row['kurangbayar'];
            $totalhutang = $totalhutang + $row['total'];
            $totalbayar = $totalbayar + $row['sudahbayar'];
        }
        $totalhutang = number_format($totalhutang, 0, '.', ',');
        $totalsisa_hutang = number_format($totalsisa_hutang, 0, '.', ',');
        $totalbayar = number_format($totalbayar, 0, '.', ',');
        echo '<tr><td colspan="6"  align="left">&nbsp;' .
            'Total' .
            '&nbsp;</td>
    <td  align="right">' .
            $totalhutang .
            '</td>
    <td  align="right">' .
            $totalbayar .
            '</td>
    <td  align="right">' .
            $totalsisa_hutang .
            '</td>';
        echo '</tr>';
    }
    echo '</table><font size="1"><left>Tanggal cetak : ' . date('d-m-Y H:i:s a');
} else {
    //Bulanan
    if ($semuaperiode == 'Y') {
        $tgl = 'Semua Periode';
        if ($semuasupplier == 'Y') {
            $queryh = mysqli_query($connect, "select * from belih where proses='Y' group by tglbeli order by tglbeli");
        } else {
            $queryh = mysqli_query($connect, "select * from belih where proses='Y' and kdsupplier='$kdsupplier' group by tglbeli order by tglbeli");
        }
    } else {
        $tgl = $tgl1 . ' s/d ' . $tgl2;
        if ($semuasupplier == 'Y') {
            $queryh = mysqli_query($connect, "select * from belih where proses='Y' and (tglbeli>='$tgl1' and tglbeli<='$tgl2') group by tglbeli order by tglbeli");
        } else {
            $queryh = mysqli_query($connect, "select * from belih where proses='Y' and kdsupplier='$kdsupplier' and (tglbeli>='$tgl1' and tglbeli<='$tgl2') group by tglbeli order by tglbeli");
        }
    }
    echo '<style>
        td { border: 0.5px solid grey; margin: 5px;}
              th { border: 0.5px solid grey; font-weight:normal;}
              body { font-family: comic sans ms;}
      </style>
    <font size="1" face="comic sans ms">
    ' .
        "$nm_perusahaan" .
        '
    <br>' .
        "$alamat_perusahaan" .
        '
    <br>' .
        "$telp_perusahaan" .
        '</font>
    <font size="2"><br>LAPORAN BULANAN HUTANG
    <br>Tanggal : ' .
        "$tgl" .
        '
    <br></br></font>';
    if ($semuasupplier == 'Y') {
        echo 'Semua Supplier';
    } else {
        echo 'Persupplier : ' . $kdsupplier . ' - ' . $nmsupplier;
    }
    echo '<table table-layout="fixed"; cellpadding="2"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
      <tr>
        <th width="30px" height="20"><font size="1" color="black">NO.</th>
        <th width="75px"><font size="1" color="black">TANGGAL</th>
        <th width="100px"><font size="1" color="black">HUTANG</th>
        <th width="100px"><font size="1" color="black">BAYAR</th>
        <th width="100px"><font size="1" color="black">SISA</th>
      </tr>';
    $totalhutang = 0;
    $totalsisa_hutang = 0;
    $totalbayar = 0;
    while ($row = mysqli_fetch_assoc($queryh)) {
        $tglbeli = $row['tglbeli'];
        if ($semuasupplier == 'Y') {
            $queryhlagi = mysqli_query($connect, "select sum(total) as total,sum(subtotal) as subtotal,sum(sudahbayar) as sudahbayar,sum(kurangbayar) as kurangbayar from belih where tglbeli='$tglbeli' and proses='Y'");
        } else {
            $queryhlagi = mysqli_query($connect, "select sum(total) as total,sum(subtotal) as subtotal,sum(sudahbayar) as sudahbayar,sum(kurangbayar) as kurangbayar from belih where tglbeli='$tglbeli' and kdsupplier='$kdsupplier' and proses='Y'");
        }
        while ($rowhlagi = mysqli_fetch_assoc($queryhlagi)) {
            $hutang = number_format($rowhlagi['total'], 0, '.', ',');
            $sudahbayar = number_format($rowhlagi['sudahbayar'], 0, '.', ',');
            $kurangbayar = number_format($rowhlagi['kurangbayar'], 0, '.', ',');
            $totalsisa_hutang = $totalsisa_hutang + $rowhlagi['kurangbayar'];
            $totalhutang = $totalhutang + $rowhlagi['total'];
            $totalbayar = $totalbayar + $rowhlagi['sudahbayar'];
        }
        $month = date('M', strtotime($tglbeli));
        $year = date('Y', strtotime($tglbeli));
        echo '<tr>
        <td width="30px"  align="center">' .
            $no .
            '</td>
        <td>&nbsp;' .
            $tglbeli .
            '</td>
        <td align="right">' .
            $hutang .
            '</td>
        <td align="right">' .
            $sudahbayar .
            '</td>
        <td align="right">' .
            $kurangbayar .
            '</td>';
        // <td align="right">&nbsp;' . $hutang . '&nbsp;</td>
        // <td align="right">&nbsp;' . $sudahbayar . '&nbsp;</td>
        // <td align="right">&nbsp;' . $kurangbayar . '&nbsp;</td>
        echo '</tr>';
        $no++;
    }
    $totalhutang = number_format($totalhutang, 0, '.', ',');
    $totalsisa_hutang = number_format($totalsisa_hutang, 0, '.', ',');
    $totalbayar = number_format($totalbayar, 0, '.', ',');
    echo '<tr><td colspan="2"  align="left">&nbsp;' .
        'Total' .
        '&nbsp;</td>
    <td  align="right">' .
        $totalhutang .
        '</td>
    <td  align="right">' .
        $totalbayar .
        '</td>
    <td  align="right">' .
        $totalsisa_hutang .
        '</td>
  </tr>';
    // echo '<tr><td colspan="2"  align="left">&nbsp;' . "Total" . '&nbsp;</td>
    //   <td  align="right">&nbsp;' . $totalhutang . '&nbsp;</td>
    //   <td  align="right">&nbsp;' . $totalbayar . '&nbsp;</td>
    //   <td  align="right">&nbsp;' . $totalsisa_hutang . '&nbsp;</td>
    // </tr>';
    echo '</table><font size="1"><left>Tanggal cetak : ' . date('d-m-Y H:i:s a');
}
