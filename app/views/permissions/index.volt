
{{ content() }}

<form method="post">

<h2>Manage Permissions</h2>

<div class="card bg-light pt-3 mb-3" align="center">

	<div class="form-group row">
    <label for="profileId" class="col-md-1 offset-md-3 col-form-label">Profile</label>
    <div class="col-md-4 mx-2">
      {{ select('profileId', profiles, 'class':'form-control', 'using': ['id', 'name'], 'useEmpty': true, 'emptyText': '...', 'emptyValue': '') }}
    </div>
    <div class="col-md-1">
      {{ submit_button('Search', 'class': 'btn btn-primary', 'name' : 'search') }}
    </div>
  </div>

</div>

{% if request.isPost() and profile %}

{% for resource, actions in acl.getResources() %}

	<h3>{{ resource }}</h3>

	<table class="table table-bordered table-striped" align="center">
		<thead>
			<tr>
				<th width="5%"></th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
			{% for action in actions %}
			<tr>
				<td align="center"><input type="checkbox" name="permissions[]" value="{{ resource ~ '.' ~ action }}"  {% if permissions[resource ~ '.' ~ action] is defined %} checked="checked" {% endif %}></td>
				<td>{{ acl.getActionDescription(action) ~ ' ' ~ resource }}</td>
			</tr>
			{% endfor %}
		</tbody>
	</table>
			
{% endfor %}

{{ submit_button('Submit', 'class': 'btn btn-primary', 'name':'submit') }}   

{% endif %}

</form>
