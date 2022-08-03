<div id="" class="col-md-12">
	<table id="gridSearchCustomer" style="width: 100%" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th style="width: 5%">No</th>
			<th>Action</th>
			<th>Name</th>
			<th>Phone</th>
			<th>Email</th>
		</tr>
		</thead>
		<tbody>

		</tbody>
	</table>
</div>

<div class="modal-footer">
	<!--	<div class="mdlButtons" th:each="i: ${viewBtnModal}">-->
	<!--		<button type="button" th:attr="id=${i.getBtnName()}"-->
	<!--				th:classappend="${i.getBtnType()} + ' ' + ${i.getBtnEventClass()}"-->
	<!--				class="btn"-->
	<!--				th:text="${i.getBtnTitle()}"></button>-->
	<!--	</div>-->
</div>

<script type="text/javascript">
	var gridCustApi = baseurl + 'rest/modal/customer_search_modal_get_data';
	var orderUrl = baseurl + 'transaction/order/';
</script>
<script type="text/javascript" src="<?= _load('js/modules/modal/customer.js'); ?>"></script>
