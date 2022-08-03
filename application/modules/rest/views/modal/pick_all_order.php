<div id="" class="col-md-12">
    <div class="row">
        <div class="col-sm-12" style="float: left">
            <div class="form-group row">
                <label for="txtPersonPickup" class="col-sm-4 col-form-label">Pick by</label>
                <div class="col-sm-8">
                    <input type="text" id="txtPersonPickup" name="txtPersonPickup" value=""
                           class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-group row">
                <label for="pickupDate" class="col-sm-4 col-form-label">Pickup Date</label>
                <div class="col-sm-8">
                    <div class="input-group date">
                        <input readonly="readonly" style="text-align: center"
                               value="<?php echo dateToday('d/m/Y'); ?>"
                               id="pickupDate" title="Please Select Date" type="text"
                               class="form-control form-control-sm pull-right datepicker">

                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
		<div class="mdlButtons">
			<button type="button" id="btn_modal_save_pickup"
					class="btn btn-success btn_modal_save_pickup">Save</button>
            <button type="button" id="btn_modal_save_pickup_cancel"
                    class="btn btn-default btn_modal_save_pickup_cancel">Cancel</button>
		</div>
</div>

<script type="text/javascript">
	var gridCustApi = baseurl + 'rest/modal/customer_search_modal_get_data';
	var orderUrl = baseurl + 'transaction/order/';
</script>
<script type="text/javascript" src="<?= _load('js/modules/modal/customer.js'); ?>"></script>
