
<form method="post" autocomplete="off">

<div class="float-left">
    {{ link_to("users", "&larr; Go Back") }}
</div>
<div class="float-right">
    {{ submit_button("Save", "class": "btn btn-success") }}
</div>

{{ content() }}

<div class="col-md-6 offset-md-3">
    <h2>Create a User</h2>

    <div class="form-group">
        <label for="name">Name</label>
        {{ form.render("name") }}
    </div>

    <div class="form-group">
        <label for="email">E-Mail</label>
        {{ form.render("email") }}
    </div>

    <div class="form-group">
        <label for="profilesId">Profile</label>
        {{ form.render("profilesId") }}
    </div>

</div>

</form>