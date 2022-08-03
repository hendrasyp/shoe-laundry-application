<?php if ($is_extra == "No") : ?>
	<?php if (isset($service_id)) : ?>
		<input type="hidden" name="xServiceId" id="xServiceId" value="<?= $service_id; ?>">
	<?php endif; ?>
	<div class="row">
		<div class="col-sm-6" style="float: left">
			<div class="form-group row">
				<label for="txt_item_name" class="col-sm-3 col-form-label">Item Name</label>
				<div class="col-sm-9">
					<input type="text" id="txt_item_name"
								 name="txt_item_name" value="<?= isset($itemDetail) ? $itemDetail->item_name : ""; ?>"
								 class="form-control form-control-sm">
				</div>
			</div>
			<div class="form-group row">
				<label for="txt_size" class="col-sm-3 col-form-label">Size</label>
				<div class="col-sm-9">
					<input type="text" id="txt_size"
								 name="txt_size" value="<?= isset($itemDetail) ? $itemDetail->size : ""; ?>"
								 class="form-control form-control-sm">
				</div>
			</div>
		</div>
		<div class="col-sm-6" style="float: left">

			<div class="form-group row">
				<label for="txt_insole" class="col-sm-3 col-form-label">Insole Color</label>
				<div class="col-sm-9">
					<input type="text" id="txt_insole"
								 name="txt_insole" value="<?= isset($itemDetail) ? $itemDetail->color_insole : ""; ?>"
								 class="form-control form-control-sm">
				</div>
			</div>
			<div class="form-group row">
				<label for="txt_tali" class="col-sm-3 col-form-label">Shoelaces Color</label>
				<div class="col-sm-9">
					<input type="text" id="txt_tali"
								 name="txt_tali" value="<?= isset($itemDetail) ? $itemDetail->color_tali : ""; ?>"
								 class="form-control form-control-sm">
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
<div class="row">
	<div class="col-md-12">

		<table id="gridSearchCustomer" style="width: 100%" class="table table-bordered table-striped table-sm">
			<thead>
			<tr>
				<th style="width: 5%">No</th>
				<th style="width: 6%">Action</th>
				<th style="text-align: center;">Name</th>
				<th style="text-align: center;">Price</th>
				<th style="text-align: center;">Description</th>
				<th style="text-align: center;">Estimate Day</th>
			</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	var gridCustApi = baseurl + 'rest/modal/service_search_modal_get_data';
	var orderUrl = baseurl + 'transaction/order/';
	var header_id = '<?=$header_id?>';
	var detail_id = '<?=$detail_id?>';
	var is_extra = '<?=$is_extra?>';
</script>
<script type="text/javascript" src="<?= _load('js/modules/modal/service.js'); ?>"></script>
