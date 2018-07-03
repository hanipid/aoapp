{{ content() }}

<form action="" method="post">
  <div class="row">
    <div class="col-8 offset-2">
      <div class="card text-center">
        <div class="card-header h3">
          MUTASI
        </div>
        <div class="card-body">
          <h1 class="card-title">{{ pegawai.nama }}</h1>
          <div class="form-check">
            <select class="custom-select" name="kode_uker">
              {% for uker in unit_kerja %}
              <option {% if uker.kode_uker == pegawai.kode_uker %}selected{% endif %} value="{{ uker.kode_uker }}">{{ uker.nama|upper }}</option>
              {% endfor %}
            </select>
          </div>
          
        </div>
        <div class="card-footer text-muted">
          <button type="submit" class="btn btn-primary btn-block">SIMPAN</button>
        </div>
      </div>
    </div>
  </div>
</form>
