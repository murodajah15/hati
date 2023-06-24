  <form id="form_teman" methode="POST">
    <input type="hidden" name="Id" id="Id">
    <div class="form-group">
      <label for="NamaTeman">NamaTeman</label>
      <!-- onkeyup="this.value = this.value.toUpperCase() autocomplete="off"" -->
      <input type="text" class="form-control NamaTeman" id="NamaTeman" name="namateman" required>
      <div class="invalid-feedback">
        <?= $validation->getError('namateman'); ?>
      </div>
    </div>
    </div>
    <div class="form-group">
      <label for="Alamat">Alamat</label>
      <input type="text" class="form-control" id="Alamat" name="alamat">
    </div>
    <div class="form-group">
      <label for="JenisKelamin">JenisKelamin</label>
      <select class="form-select" name="jeniskelamin" id="JenisKelamin">
        <option value="">[Pilih Jenis Kelamin]
          <?php
          foreach ($jk as $key) {
            echo "<option value='$key->uraian'>";
            echo "$key->uraian</option>";
          }
          ?>
        </option>
      </select>
    </div>
  </form>