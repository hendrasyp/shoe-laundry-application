<div class="login-box">
	<div class="login-logo">
		<img src="<?=base_url();?>assets/img/logo-login.png" style="width: 100%" />
	</div>
	<!-- /.login-logo -->
	<div class="card">
		<div class="card-body login-card-body">
			<p class="login-box-msg">Sign in to start your session</p>

			<form action="<?= base_url('auth/login_auth')?>" method="post">
				<div class="input-group mb-3">
					<input type="text" class="form-control" name="data[uid]" id="uid" placeholder="Username">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-envelope"></span>
						</div>
					</div>
				</div>
				<div class="input-group mb-3">
					<input type="password" name="data[upass]" class="form-control" placeholder="Password">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-lock"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<button type="submit" class="btn btn-primary btn-block">Sign In</button>
					</div>
					<!-- /.col -->
				</div>
			</form>


		</div>
		<!-- /.login-card-body -->
	</div>
</div>
