<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
  <div class="row">
    <div class="col">
      <h1>This Contact</h1>
      Hello, world! Open the page in your browser of choice to see your Bootstrapped page. Now you can start building with Bootstrap by creating your own layout, adding dozens of components, and utilizing our official examples.
      <?php foreach ($alamat as $a) : ?>
        <ul>
          <li><?= $a['tipe']; ?></li>
          <li><?= $a['alamat']; ?></li>
          <li><?= $a['kota']; ?></li>
        </ul>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>