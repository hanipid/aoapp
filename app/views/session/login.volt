{{ content() }}

<div class="col-md-4 offset-md-4">
	{{ form('class': 'form-search') }}

		<div class="card">

			<div class="card-body">
				<h5 class="card-title">Log In</h5>
				<div class="card-text">

					<div class="form-group">{{ form.render('email') }}</div>
					<div class="form-group">{{ form.render('password') }}</div>

					<div class="form-group">
						{{ form.render('remember') }}
						{{ form.label('remember') }}
					</div>

					{{ form.render('go') }}

					{{ form.render('csrf', ['value': security.getToken()]) }}

					<hr>

					<div class="forgot">
						{{ link_to("session/forgotPassword", "Forgot my password") }}
					</div>
				</div>
			</div>
			
		</div>

	</form>

</div>