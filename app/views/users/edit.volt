
{{ content() }}



<form method="post" autocomplete="off">

  <div class="row">
    <div class="col-md-12">
      <div class="float-left">
        {{ link_to("users", "&larr; Go Back") }}
      </div>
      <div class="float-right">
        {{ submit_button("Save", "class": "btn btn-big btn-success") }}
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <h2>Edit users</h2>

      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item"><a href="#A" class="nav-link active" data-toggle="tab" role="tab" aria-selected="true">Basic</a></li>
        <li class="nav-item"><a href="#B" class="nav-link" data-toggle="tab" role="tab" aria-selected="false">Successful Logins</a></li>
        <li class="nav-item"><a href="#C" class="nav-link" data-toggle="tab" role="tab" aria-selected="false">Password Changes</a></li>
        <li class="nav-item"><a href="#D" class="nav-link" data-toggle="tab" role="tab" aria-selected="false">Reset Passwords</a></li>
      </ul>

      <div class="tabbable">
        <div class="tab-content">
          <div class="tab-pane active" id="A" role="tabpanel" aria-labelledby="nav-A">

            {{ form.render("id") }}

            <div class="row">
              <div class="col-md-4 offset-md-2">

                <div class="form-group">
                  <label for="name">Name</label>
                  {{ form.render("name") }}
                </div>

                <div class="form-group">
                  <label for="profilesId">Profile</label>
                  {{ form.render("profilesId") }}
                </div>

                <div class="form-group">
                  <label for="suspended">Suspended?</label>
                  {{ form.render("suspended") }}
                </div>

              </div>

              <div class="col-md-4">

                <div class="form-group">
                  <label for="email">E-Mail</label>
                  {{ form.render("email") }}
                </div>

                <div class="form-group">
                  <label for="banned">Banned?</label>
                  {{ form.render("banned") }}
                </div>

                <div class="form-group">
                  <label for="active">Confirmed?</label>
                  {{ form.render("active") }}
                </div>

              </div>
            </div>
          </div>

          <div class="tab-pane" id="B" role="tabpanel" aria-labelledby="nav-B">
            <p>
              <table class="table table-bordered table-striped" align="center">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>IP Address</th>
                    <th>User Agent</th>
                  </tr>
                </thead>
                <tbody>
                {% for login in user.successLogins %}
                  <tr>
                    <td>{{ login.id }}</td>
                    <td>{{ login.ipAddress }}</td>
                    <td>{{ login.userAgent }}</td>
                  </tr>
                {% else %}
                  <tr><td colspan="3" align="center">User does not have successfull logins</td></tr>
                {% endfor %}
                </tbody>
              </table>
            </p>
          </div>

          <div class="tab-pane" id="C" role="tabpanel" aria-labelledby="nav-C">
            <p>
              <table class="table table-bordered table-striped" align="center">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>IP Address</th>
                    <th>User Agent</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                {% for change in user.passwordChanges %}
                  <tr>
                    <td>{{ change.id }}</td>
                    <td>{{ change.ipAddress }}</td>
                    <td>{{ change.userAgent }}</td>
                    <td>{{ date("Y-m-d H:i:s", change.createdAt) }}</td>
                  </tr>
                {% else %}
                  <tr><td colspan="3" align="center">User has not changed his/her password</td></tr>
                {% endfor %}
                </tbody>
              </table>
            </p>
          </div>

          <div class="tab-pane" id="D" role="tabpanel" aria-labelledby="nav-D">
            <p>
              <table class="table table-bordered table-striped" align="center">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Date</th>
                    <th>Reset?</th>
                  </tr>
                </thead>
                <tbody>
                {% for reset in user.resetPasswords %}
                  <tr>
                    <th>{{ reset.id }}</th>
                    <th>{{ date("Y-m-d H:i:s", reset.createdAt) }}
                    <th>{{ reset.reset == 'Y' ? 'Yes' : 'No' }}
                  </tr>
                {% else %}
                  <tr><td colspan="3" align="center">User has not requested reset his/her password</td></tr>
                {% endfor %}
                </tbody>
              </table>
            </p>
          </div>

        </div>
      </div>
    </div>
  </div>

</form>