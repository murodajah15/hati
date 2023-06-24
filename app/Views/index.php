<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="<?= csrf_token() ?>" content="<?= csrf_hash() ?>">
  <title><?= $title; ?></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css" />
</head>

<body>

  <!-- Content -->
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            User
            <a href="" class="btn btn-primary btn-sm float-right">New Record</a>
          </div>
          <div class="card-body">

            <table id="user-table" class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <td>No</td>
                  <td>Nama</td>
                  <td>Email</td>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>

          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- /.Content -->

  <footer class="text-center mt-5">
    <p><em><small>Seri Tutorial CodeIgniter 4: Integrasi Datatable CodeIgniter @ <a href="https://qadrlabs.com/">qadrLabs</a></small></em></p>
  </footer>

  <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      var table = $('#user-table').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
          "url": "<?php echo site_url('ajaxList') ?>",
          "type": "POST"
        },
        "columnDefs": [{
          "targets": [],
          "orderable": false,
        }, ],
      });
    });
  </script>

</body>

</html>