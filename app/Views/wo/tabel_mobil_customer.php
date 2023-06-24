<div class="row">
  <div class="container-fluid">
    <?php if (session()->getFlashdata('pesan')) : ?>
      <div class="container fluid mt-2">
        <div class="alert alert-primary d-flex align-items-center" role="alert">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
          </svg>
          <div>
            <!-- <div class="alert alert-success alert-dismissible fade in" role="alert"> -->
            <!-- <div class="alert alert-success" role="alert"> -->
            <?= session()->getFlashdata('pesan'); ?>
            <!-- </div> -->
          </div>
        </div>
      </div>
    <?php endif; ?>
    <div class="modal-body">
      <table id="tbl-mobil-detail" class="table table-striped" style="width:100%">
        <thead>
          <tr>
            <th width="30">No.</th>
            <th>No. Polisi</th>
            <th>No. Rangka</th>
            <th>No. Mesin</th>
            <th>Tipe</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $db = \Config\Database::connect();
          $no = 1;
          $kdpemilik = $tbcustomer['kode'];
          $builder = $db->table('tbmobil');
          $builder->where('kdpemilik', $kdpemilik);
          $builder->orderBy('nopolisi');
          $query   = $builder->get();
          $results = $query->getResultArray();
          foreach ($results as $row) {
            echo "<tr><td>$no</td>";
            echo "<td>$row[nopolisi]</td>";
            echo "<td>$row[norangka]</td>";
            echo "<td>$row[nomesin]</td>";
            echo "<td>$row[kdtipe]</td>";
            $no++;
          ?>
            <td width="100">
              <button type="button" class="btn btn-success btn-sm" onClick="detailmobilcustomer(`<?= $row['id'] ?>`)"><i class="fa fa-eye"></i></button>
              <!-- <button type='Button' class='btn btn-warning btn-sm' onClick="edit(<?= $row['nopolisi'] ?>)"><i class="fa fa-edit"></i></button> -->
              <button type='Button' class='btn btn-danger btn-sm btnhapusform' onClick="hapusmobil(`<?= $row['nopolisi'] ?>`)"><i class="fa fa-trash"></i></button>
              <!-- </form> -->
            </td>
          <?php
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>