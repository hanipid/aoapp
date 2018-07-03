{{ content() }}

<form action="" method="post">
  <div class="row">
    <div class="col-8 offset-2">
      <div class="card text-center">
        <div class="card-header h3">
          STATUS
        </div>
        <div class="card-body">
          <h1 class="card-title">{{ pegawai.nama }}</h1>
          <div class="form-check">
            <select class="custom-select" name="status">
              {% for ps in pegawai_status %}
              <option {% if ps.id == pegawai.status %}selected{% endif %} value="{{ ps.id }}">{{ ps.status|upper }}</option>
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
