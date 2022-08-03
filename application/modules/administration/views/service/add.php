<form class="form-horizontal" id="frm_input" name="frm_input" method="post">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title">Service Detail</h3>
                    <?php $this->load->view('shared/user_controls/cards_button_collapsed'); ?>
                    <!-- /.card-tools -->
                </div>
                <div class="card-body">
                    <?php $this->load->view('/service/form', array("data" => $viewData)); ?>

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
