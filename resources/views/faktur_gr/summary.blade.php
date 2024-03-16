<div class="card-body">
    <form action="tbmobil_update" method="post" class="formfaktur_gr">
        <div class="row mt-2 mb-2">
            <?php
            $ftotal_jasa = number_format($faktur_gr->total_jasa, 0, ',', ',');
            $ftotal_part = number_format($faktur_gr->total_part, 0, ',', ',');
            $ftotal_bahan = number_format($faktur_gr->total_bahan, 0, ',', ',');
            $ftotal_opl = number_format($faktur_gr->total_opl, 0, ',', ',');
            $ftotal = number_format($faktur_gr->total, 0, ',', ',');
            $fdpp = number_format($faktur_gr->dpp, 0, ',', ',');
            $fpr_ppn = number_format($faktur_gr->pr_ppn, 0, ',', ',');
            $fppn = number_format($faktur_gr->ppn, 0, ',', ',');
            $ftotal_faktur = number_format($faktur_gr->total_faktur, 0, ',', ',');
            ?>
            <div class="col-12 col-sm-6">
                <label for="nama" class="form-label mb-1">Total Spare Part</label>
                <input type="text" class="form-control form-control-sm mb-2 text-end" id="grandtotal_part"
                    value="<?= $ftotal_part ?>" style="text-align:right;" readonly>
                <label for="nama" class="form-label mb-1">Total Jasa</label>
                <input type="text" class="form-control form-control-sm mb-2 text-end" id="grandtotal_jasa"
                    value="<?= $ftotal_jasa ?>" style="text-align:right;" readonly>
                <label for="nama" class="form-label mb-1">Total Bahan</label>
                <input type="text" class="form-control form-control-sm mb-2 text-end" id="grandtotal_bahan"
                    value="<?= $ftotal_bahan ?>" style="text-align:right;" readonly>
                <label for="nama" class="form-label mb-1">Total OPL</label>
                <input type="text" class="form-control form-control-sm mb-2 text-end" id="grandtotal_opl"
                    value="<?= $ftotal_opl ?>" style="text-align:right;" readonly>
                <label for="nama" class="form-label mb-1">Total</label>
                <input type="text" class="form-control form-control-sm mb-2 text-end" id="total_s_j_b"
                    value="<?= $ftotal ?>" style="text-align:right;" readonly>
            </div>
            <div class="col-12 col-sm-6">
                <label for="nama" class="form-label mb-1">DPP</label>
                <input type="text" class="form-control form-control-sm mb-2 text-end" id="dpp"
                    value="<?= $fdpp ?>" style="text-align:right;" readonly>
                <label for="nama" class="form-label mb-1">PPN (%)</label>
                <input type="text" class="form-control form-control-sm mb-2 text-end" id="ppn"
                    value="<?= $fpr_ppn ?>" style="text-align:right;" readonly>
                <label for="nama" class="form-label mb-1">PPN</label>
                <input type="text" class="form-control form-control-sm mb-2 text-end" id="ppn"
                    value="<?= $fppn ?>" style="text-align:right;" readonly>
                {{-- <label for="nama" class="form-label mb-1">Materai</label>
                                    <input type="text" class="form-control form-control-sm mb-2 text-end"
                                        id="materai"> --}}
                <label for="nama" class="form-label mb-1">Grand Total</label>
                <input type="text" class="form-control form-control-sm mb-2 text-end" id="grantotal"
                    value="<?= $ftotal_faktur ?>" style="text-align:right;" readonly>
            </div>
        </div>
    </form>
</div>
