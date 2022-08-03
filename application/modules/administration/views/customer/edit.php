<form class="form-horizontal" id="frm_user_detail" name="frm_user_detail"
      action="<?= base_url('administration/user/update'); ?>" method="post">
    <input type="hidden" name="hid_user_id" id="hid_user_id" value="<?= $viewData->id; ?>">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title">Customer Detail</h3>
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
                                <input type="text" <?= !empty($viewData->username) ? "readonly" : ""; ?> value="<?= $viewData->username; ?>" class="form-control"
                                       name="username"
                                       id="username"
                                       placeholder="Username">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                            <div class="col-sm-9">
                                <input type="phone" <?= !empty($viewData->phone) ? "" : ""; ?> value="<?= $viewData->phone; ?>" class="form-control"
                                       name="phone"
                                       id="phone"
                                       placeholder="Phone">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" value="<?= $viewData->email; ?>" class="form-control" name="email"
                                       id="email"
                                       placeholder="email">
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

                    </div>

                </div>
                <div class="card-footer">
                    <button type="button" id="btn_save" class="btn btn-success">Save</button>
                    <button type="button" id="btn_cancel" class="btn btn-default">Cancel</button>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</form>
