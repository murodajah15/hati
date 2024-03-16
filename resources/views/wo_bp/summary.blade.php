<div class="card-body">
    <form action="tbmobil_update" method="post" class="formwo_bp">
        <div class="row mt-2 mb-2">
            <?php
            $ftotal_jasa = number_format($wo_bp->total_jasa, 0, ',', ',');
            $ftotal_part = number_format($wo_bp->total_part, 0, ',', ',');
            $ftotal_bahan = number_format($wo_bp->total_bahan, 0, ',', ',');
            $ftotal_opl = number_format($wo_bp->total_opl, 0, ',', ',');
            $ftotal = number_format($wo_bp->total, 0, ',', ',');
            $fdpp = number_format($wo_bp->dpp, 0, ',', ',');
            $fpr_ppn = number_format($wo_bp->pr_ppn, 0, ',', ',');
            $fppn = number_format($wo_bp->ppn, 0, ',', ',');
            $ftotal_wo = number_format($wo_bp->total_wo, 0, ',', ',');
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
                    value="<?= $ftotal_wo ?>" style="text-align:right;" readonly>
            </div>
        </div>
    </form>
</div>
