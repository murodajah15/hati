<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
  <div class="row">
    <div class="col">
      <?php d($test);
      echo $test[0];
      echo $test[1];
      echo $test[2];
      ?>
      <h1>This Home</h1>
      Hello, world! Open the page in your browser of choice to see your Bootstrapped page. Now you can start building with Bootstrap by creating your own layout, adding dozens of components, and utilizing our official examples.
    </div>
  </div>
</div>
<?= $this->endSection(); ?>