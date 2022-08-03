<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-warning">
            <div class="card-header">
                <h3 class="card-title">Service Filter</h3>
                <?php $this->load->view('shared/user_controls/cards_button_collapsed'); ?>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="form-horizontal" action="<?= base_url($pageurl) ?>" method="post"
                      id="frm_filter">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="searchName" class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" value="" class="form-control" name="searchName"
                                           id="searchName"
                                           placeholder="Search Name">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="row-cols-md-6">
                    <button type="button" class="btn btn-primary" id="btn_search">Search</button>
                    <button type="button" class="btn btn-default btn-outline-info" id="btn_search_clear">Clear</button>
                </div>
            </div>
            <!-- /.card-footer -->

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-warning">
            <div class="card-header">
                <!--				<h3 class="card-title">Filter</h3>-->
                <div id="" class="card-tools">
                    <button type="button" class="btn btn-primary pull-right" id="btn_new_service"> Add New Service
                    </button>
                </div>
            </div>
            <div class="card-body">

                <div id="" class="col-md-12">
                    <table id="gridService" style="width: 100%" class="table table-bordered table-striped no-footer">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 15%">Action</th>
                                <th style="width: 30%">Name</th>
                                <th style="width: 10%">Price</th>
                                <th style="width: 10%">Is Extra</th>
                                <th style="width: 30%">Description</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>


            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
<script type="text/javascript">
    var pageBaseUrl = '<?= base_url($pageurl); ?>'
    var gridApiUrl = '<?= base_url($pageurl . '/get_data'); ?>';
</script>
