{{ content() }}

<h1 class="text-center">Database AO</h1>

<div class="my-2">
	<a href="{{ url('ao/create') }}" class="btn btn-primary btn-sm">Tambah Pegawai</a>
</div>

<table class="table border table-sm" id="myTable">
	<thead>
		<tr>
			<th>#</th>
			<th>Nama</th>
			<th>KANCA</th>
			<th>UKER</th>
			<th>Status</th>
			<th></th>
		</tr>
	</thead>

	<tbody>
		{% for v1 in view1 %}
		<tr>
			<td>{{ loop.index }}</td>
			<td><a href="{{ url('ao/edit/'~v1.pegawai_id) }}">{{ v1.nama|upper }}</a></td>
			<td>{{ v1.kanca|upper }}</td>
			<td>{{ v1.uker|upper }}</td>
			<td>{{ v1.status|upper }}</td>
			<td>
				<a href="{{ url('ao/mutasi/'~v1.pegawai_id) }}" class="btn btn-primary btn-sm">MUTASI</a>
				<a href="{{ url('ao/status/'~v1.pegawai_id) }}" class="btn btn-primary btn-sm">STATUS</a>
			</td>
		</tr>
		{% endfor %}
	</tbody>
</table>