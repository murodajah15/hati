<?php
$session = session();
$pakai = session()->get('pakai');
$tambah = session()->get('tambah');
$edit = session()->get('edit');
$hapus = session()->get('hapus');
$proses = session()->get('proses');
$unproses = session()->get('unproses');
$cetak = session()->get('cetak');
?>

<div class="row">
  <div class="container mt-2">
    <?php if ($tambah == 1) {
    ?>
      <!-- <button class="btn btn-flat btn-primary btn-sm mb-3 tomboltambah" type="button"><i class="fa fa-plus"></i> Tambah Data</button> -->
    <?php
    } else {
    ?>
      <!-- <button class="btn btn-flat btn-primary btn-sm mb-3 tomboltambah" type="button" disabled><i class="fa fa-plus"></i> Tambah</button> -->
    <?php
    }
    ?>

    <!-- <table class="table table-bordered table-striped" id="tbl-customer-data"> -->
    <table id="tbl-wo" class="table table-bordered table-striped" style="width:100%">
      <!-- <table class="table"> -->
      <thead>
        <tr>
          <th width="30">#</th>
          <th width="130">WO</th>
          <th width="150">Tanggal</th>
          <!-- <th width="130">WO</th> -->
          <th width="90">No. Polisi</th>
          <th width="50">Jenis</th>
          <th width="50">KM</th>
          <th width="90">Batal</th>
          <!-- <th width="350" scope="col">User</th> -->
          <th width="150">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        foreach ($wo as $row) {
          echo "<tr><td align=center>$no</td>";
          echo "<td>$row[nowo]</td>";
          echo "<td>$row[tanggal]</td>";
          echo "<td>$row[nopolisi]</td>";
          echo "<td>$row[kdservice]</td>";
          echo "<td>$row[km]</td>";
          echo "<td>$row[batal]</td>";
          $no++;
        ?>
          <td width="100">
            <button type="button" class="btn btn-success btn-sm" onClick="detail(`<?= $row['id'] ?>`)"><i class="fa fa-eye"></i></button>
            <button type='Button' class='btn btn-danger btn-sm' onClick="hapuswo(`<?= $row['id'] ?>`)"><i class="fa fa-trash"></i></button>
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

<script>
  $(document).ready(function() {
    $('#tbl-wo').DataTable();
    $('#tbl-wo1').DataTable({
      destroy: true,
      processing: true,
      serverSide: true,
      // scrollY: "400px",
      // scrollCollapse: true,
      ajax: {
        url: '<?= site_url('/wo/ajax-load-data') ?>',
        type: 'POST',
      },
      ordering: true,
      columns: [{
          data: null,
          render: function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          data: 'nowo',
          name: 'nowo'
        },
        {
          data: 'tanggal',
          name: 'tanggal'
        },
        {
          data: 'noestimasi',
          name: 'noestimasi',
        },
        {
          data: 'nopolisi',
          name: 'nopolisi'
        },
        {
          data: 'batal',
          name: 'batal'
        },
        // {
        //   data: 'nmpemilik',
        //   name: 'nmpemilik'
        // },
        // {
        //   data: 'user',
        //   name: 'user'
        // },
        {
          data: null,
          render: function(data, type, row, meta) {
            return `<a href="#${row.id}" ><button class='btn btn-sm btn-success' href='javascript:void(0)' onclick="detail(${row.id})"><i class='fa fa-eye')></i></button></a>
            <a href="#${row.id}"><button class='btn btn-sm btn-warning' href='javascript:void(0)' onclick="edit(${row.id})" <?= $edit == 1 ?  '' : '' ?>><i class='fa fa-edit'></i></button></a>
            <a href="#${row.id},${row.nowo}"><button class='btn btn-sm btn-danger' href='javascript:void(0)' onclick="hapus(${row.id})" <?= $hapus == 1 ?  '' : 'disabled' ?>><i class='fa fa-trash'"></i></button></a>`;
          }
        },
        // <a href="#${row.id}"><button class='btn btn-sm btn-info' href='javascript:void(0)' onclick="formdetailmobil(${row.id})"><i class='fa fa-car')></i></button></a>
        // <a href="#${row.id}" onclick="detailmobil(${row.id})"><button class='btn btn-sm btn-info' href='javascript:void(0)'><i class='fa fa-car')></i></button></a>
      ],
      columnDefs: [{
        orderable: false,
        targets: [0, 1, 2, 3, 4, 5]
      }],
      bFilter: true,
      order: [
        [0, 'asc'],
        [1, 'asc'],
        [2, 'asc'],
        [3, 'asc'],
        [4, 'asc'],
        [5, 'asc'],
      ],
    });
  });

  function hapuswo($id) {
    swal({
        title: "Yakin akan hapus ?",
        text: "Once deleted, you will not be able to recover this data!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "<?php echo site_url('wo/hapuswo') ?>/" + $id,
            type: "POST",
            dataType: "JSON",
            success: function(data1) {
              //if success reload ajax table
              // $('#modal_form').modal('hide');
              reload_table_wo();
              swal({
                title: "Data Berhasil dihapus ",
                text: "",
                icon: "info"
              })
              // .then(function() {
              //   window.location.href = '/wo';
              // });
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert('Error deleting data id ' + $kode);
            }
          });
        } else {
          // swal("Batal Hapus!");
        }
      });
  }
</script>