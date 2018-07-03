
<form method="post" autocomplete="off">

<div class="row">
  <div class="col-12">
    <li class="float-left">
      {{ link_to("profiles", "&larr; Go Back") }}
    </li>
    <li class="float-right">
      {{ submit_button("Save", "class": "btn btn-success") }}
    </li>
  </div>
</div>

{{ content() }}

<div class="col-md-6 offset-md-3">
  <h2>Create a Profile</h2>

  <div class="form-group">
    <label for="name">Name</label>
    {{ form.render("name") }}
  </div>

  <div class="form-group">
    <label for="active">Active?</label>
    {{ form.render("active") }}
  </div>

</div>

</form>