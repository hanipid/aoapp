{{ content() }}

<div align="right">
    {{ link_to("users/create", "<i class='icon-plus-sign'></i> Create Users", "class": "btn btn-primary") }}
</div>

<form method="post" action="{{ url("users/search") }}" autocomplete="off">

    <div class="col-md-6 offset-md-3">

        <h2>Search users</h2>

        <div class="form-group">
            <label for="id">Id</label>
            {{ form.render("id") }}
        </div>

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

        <div class="form-group">
            {{ submit_button("Search", "class": "btn btn-primary") }}
        </div>

    </div>

</form>