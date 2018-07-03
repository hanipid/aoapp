<!DOCTYPE html>
<html>
	<head>
		<title>Welcome to AO App</title>
	  <!-- Custom fonts for this template-->
	  {{ stylesheet_link('css/font-awesome.css') }}
		<link href="https://bootswatch.com/4/yeti/bootstrap.min.css" rel="stylesheet">		
		{{ stylesheet_link('css/style.css') }}
		{{ stylesheet_link('css/jquery.smartmenus.bootstrap-4.css') }}
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
	</head>
	<body>

		{{ content() }}

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
		<script src="https://blackrockdigital.github.io/startbootstrap-sb-admin/js/sb-admin.min.js"></script>

		<!-- SmartMenus jQuery plugin -->
		{{ javascript_include('js/jquery.smartmenus.min.js') }}

		<!-- SmartMenus jQuery Bootstrap 4 Addon -->
		{{ javascript_include('js/jquery.smartmenus.bootstrap-4.min.js') }}

		<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

		<script type="text/javascript">
			$(document).ready( function () {
			    $('#myTable').DataTable();
			});
		</script>
	</body>
</html>