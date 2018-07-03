<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  {{ link_to(null, 'class': 'navbar-brand', 'AO App')}}
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation" style="">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor03">
    <ul class="navbar-nav mr-auto">
      {%- set menus = [
        'Home': 'index',
        'About': 'about'
      ] -%}

      {%- for key, value in menus %}
        {% if value == dispatcher.getControllerName() %}
        <li class="nav-item active">{{ link_to(value, key, 'class':'nav-link') }}</li>
        {% else %}
        <li class="nav-item">{{ link_to(value, key, 'class':'nav-link') }}</li>
        {% endif %}
      {%- endfor -%}
    </ul>

    <ul class="navbar-nav float-right">
      {%- if logged_in is defined and not(logged_in is empty) -%}
      <li class="nav-item">{{ link_to('users', 'Users Panel', 'class':'nav-link') }}</li>
      <li class="nav-item">{{ link_to('session/logout', 'Logout', 'class':'nav-link') }}</li>
      {% else %}
      <li class="nav-item">{{ link_to('session/login', 'Login', 'class':'nav-link') }}</li>
      {% endif %}
    </ul>
  </div>
</nav>

<div class="container main-container">
  {{ content() }}
</div>

<footer>
Made with love by the Phalcon Team

    {{ link_to("privacy", "Privacy Policy") }}
    {{ link_to("terms", "Terms") }}

© {{ date("Y") }} Phalcon Team.
</footer>
