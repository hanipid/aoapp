{{ content() }}

<div class="float-left">
    {{ link_to("users/index", "&larr; Go Back") }}
</div>
<div class="float-right">
    {{ link_to("users/create", "Create users", "class": "btn btn-primary") }}
</div>

{% for user in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Profile</th>
            <th>Banned?</th>
            <th>Suspended?</th>
            <th>Confirmed?</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
{% endif %}
        <tr>
            <td>{{ user.id }}</td>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.profile.name }}</td>
            <td>{{ user.banned == 'Y' ? 'Yes' : 'No' }}</td>
            <td>{{ user.suspended == 'Y' ? 'Yes' : 'No' }}</td>
            <td>{{ user.active == 'Y' ? 'Yes' : 'No' }}</td>
            <td width="12%">{{ link_to("users/edit/" ~ user.id, '<i class="icon-pencil"></i> Edit', "class": "btn") }}</td>
            <td width="12%">{{ link_to("users/delete/" ~ user.id, '<i class="icon-remove"></i> Delete', "class": "btn", "onclick":"return confirm('Are you sure?')") }}</td>
        </tr>
{% if loop.last %}
    </tbody>
    <tfoot>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group" role="group">
                    {{ link_to("users/search", '<i class="icon-fast-backward"></i> First', "class": "btn btn-secondary") }}
                    {{ link_to("users/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn btn-secondary ") }}
                    {{ link_to("users/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn btn-secondary") }}
                    {{ link_to("users/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn btn-secondary") }}
                    <span class="btn">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    </tfoot>
</table>
{% endif %}
{% else %}
    No users are recorded
{% endfor %}
