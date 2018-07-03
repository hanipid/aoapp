
<form method="post" autocomplete="off">

  <div class="row">
    <div class="col-12">
      <div class="float-left">
        {{ link_to("profiles", "&larr; Go Back") }}
      </div>
      <div class="float-right">
        {{ submit_button("Save", "class": "btn btn-success") }}
      </div>
    </div>
  </div>

  {{ content() }}

  <div class="col-md-6 offset-md-3">

    <h2>Edit profile</h2>

    <ul class="nav nav-tabs">
      <li class="nav-item"><a href="#A" class="nav-link active" data-toggle="tab">Basic</a></li>
      <li class="nav-item"><a href="#B" class="nav-link" data-toggle="tab">Users</a></li>
    </ul>

    <div class="tabbable">
      <div class="tab-content">
        <div class="tab-pane active" id="A">

          {{ form.render("id") }}

          <div class="clearfix">
            <label for="name">Name</label>
            {{ form.render("name") }}
          </div>

          <div class="clearfix">
            <label for="active">Active?</label>
            {{ form.render("active") }}
          </div>

        </div>

        <div class="tab-pane" id="B">
          <p>
            <table class="table table-bordered table-striped" align="center">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Banned?</th>
                  <th>Suspended?</th>
                  <th>Active?</th>
                </tr>
              </thead>
              <tbody>
              {% for user in profile.users %}
                <tr>
                  <td>{{ user.id }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.banned == 'Y' ? 'Yes' : 'No' }}</td>
                  <td>{{ user.suspended == 'Y' ? 'Yes' : 'No' }}</td>
                  <td>{{ user.active == 'Y' ? 'Yes' : 'No' }}</td>
                  <td width="12%">{{ link_to("users/edit/" ~ user.id, '<i class="icon-pencil"></i> Edit', "class": "btn") }}</td>
                  <td width="12%">{{ link_to("users/delete/" ~ user.id, '<i class="icon-remove"></i> Delete', "class": "btn") }}</td>
                </tr>
              {% else %}
                <tr><td colspan="3" align="center">There are no users assigned to this profile</td></tr>
              {% endfor %}
              </tbody>
            </table>
          </p>
        </div>

      </div>
    </div>

  </div>

</form>