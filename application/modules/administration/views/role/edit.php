<form class="form-horizontal" id="frm_role_detail" name="frm_role_detail"
	  action="<?= base_url('administration/user/update'); ?>" method="post">
	<input type="hidden" name="hid_user_id" id="hid_user_id" value="<?= $viewData->id; ?>">
	<div class="row">
		<div class="col-md-12">
			<div class="card card-outline card-warning">
				<div class="card-header">
					<h3 class="card-title">User Detail</h3>
					<?php $this->load->view('shared/user_controls/cards_button_collapsed'); ?>
					<!-- /.card-tools -->
				</div>
				<div class="card-body">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="name" class="col-sm-3 col-form-label">Nama Lengkap</label>
							<div class="col-sm-9">
								<input type="text" value="<?= $viewData->name; ?>" class="form-control" name="name"
									   id="name"
									   placeholder="Nama Lengkap">
							</div>
						</div>
						<div class="form-group row">
							<label for="name" class="col-sm-3 col-form-label">Username</label>
							<div class="col-sm-9">
								<input type="text" readonly value="<?= $viewData->username; ?>" class="form-control"
									   name="username"
									   id="username"
									   placeholder="Username">
							</div>
						</div>
						<div class="form-group row">
							<label for="name" class="col-sm-3 col-form-label">Password</label>
							<div class="col-sm-9">
								<input type="text" value="" class="form-control" name="password"
									   id="password"
									   placeholder="Password">
							</div>
						</div>
						<div class="form-group row">
							<label for="rol" class="col-sm-3 col-form-label">Role</label>
							<div class="col-sm-9">
								<?php //print_r($roleList); ?>
								<select id="roleid" name="roleid" class="form-control">
									<option value="">Pilih Role</option>
									<?php foreach ($roleList as $key => $role): ?>
										<option <?= ($role->id == $viewData->roleid) ? "selected" : ""; ?>
												value="<?= $role->id; ?>"><?= ucwords(strtolower($role->name)); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>

				</div>
				<div class="card-footer">
					<button type="button" id="btn_save" class="btn btn-success">Save</button>
					<button type="button" class="btn btn-default">Cancel</button>
				</div>
				<!-- /.card-body -->
			</div>
		</div>
	</div>
</form>
