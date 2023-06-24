<div class="row">
  <div class="container mt-2">
    <!-- <table class="table table-bordered table-striped" id="tbl-customer-data"> -->
    <table id="tbl-wo-part" class="table table-bordered table-striped" style="width:100%">
      <!-- <table class="table"> -->
      <thead>
        <tr>
          <th width="30">#</th>
          <th width="200">Kode Part</th>
          <th width="400">Nama Spare Part</th>
          <th width="100">Qty</th>
          <th>Harga Satuan</th>
          <th width="90">Disc (%)</th>
          <th>Subtotal</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 0;
        $db = \Config\Database::connect();
        $builder = $db->table('wo_part_temp');
        $query    = $builder->where('nowo', $nowo);
        $query    = $builder->get();
        $results = $query->getResultArray();
        foreach ($results as $row) {
          $no++;
          $id = $row['id'];
          echo "<tr><td align=center>$no</td>";
          echo "<td>$row[kodepart]</td>";
          echo "<td>$row[namapart]</td>";
          echo "<td>$row[qty]</td>";
          echo "<td>$row[harga]</td>";
          echo "<td>$row[pr_discount]</td>";
          echo "<td>$row[subtotal]</td>";
        ?>
          <td><a href="#"><button type="button" class="btn btn-danger btn-sm" onclick="hapuspartwo(<?= $id ?>)"><i class='fa fa-trash'></i></button></a></td>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#tbl-wo-part').DataTable();
  });
</script>