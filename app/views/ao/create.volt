{{ content() }}

<form action="{{ url('ao/create') }}" method="post">
  <div class="row">
    <div class="col-8 offset-2">
      <div class="card text-center">
        <div class="card-header h3">
          Pegawai Baru
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="nama">Nama Pegawai</label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Pegawai">
          </div>          
          <div class="form-group">
            <label for="kode_uker">Unit Kerja</label>
            <select class="custom-select" id="kode_uker" name="kode_uker">
              {% for uker in unit_kerja %}
              <option value="{{ uker.kode_uker }}">{{ uker.nama|upper }}</option>
              {% endfor %}
            </select>
          </div>  
          <div class="form-group">
            <label for="status">Status</label>
            <select class="custom-select" id="status" name="status">
              {% for ps in pegawai_status %}
              <option value="{{ ps.id }}">{{ ps.status|upper }}</option>
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
