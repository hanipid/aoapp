{{ content() }}

<form action="{{ url('ao/edit/'~pegawai.id) }}" method="post">
  <div class="row">
    <div class="col-8 offset-2">
      <div class="card text-center">
        <div class="card-header h3">
          Ubah Nama Pegawai
        </div>
        <div class="card-body">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text" id="">Nama Pegawai</span>
            </div>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Pegawai" value="{{ pegawai.nama }}">
            <div class="input-group-append">
              <a href="{{ url('ao/delete/'~pegawai.id) }}" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin?')">Hapus Data Permanen</a>
            </div>
          </div>
        </div>
        <div class="card-footer text-muted">
          <button type="submit" class="btn btn-primary btn-block">SIMPAN</button>
        </div>
      </div>
    </div>
  </div>
</form>
