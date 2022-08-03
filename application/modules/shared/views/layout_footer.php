</div>
</section>
<!-- /.content -->
</div>

<!-- /.content-wrapper -->
<footer class="main-footer ">
	<strong>Copyright &copy; 2021 <a href="https://www.suhendrayohanaputra.com"><?=COMPANY_NAME?></a>.</strong>
	All rights reserved.
	<div class="float-right d-none d-sm-inline-block">
		<b>Version</b> 1.0.0
	</div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
	<!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script type="text/javascript" src="<?= _load('plugins/jquery/jquery.min.js'); ?>"></script>
<script type="text/javascript" src="<?= _load('plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
<script>
	$.widget.bridge('uibutton', $.ui.button);
	var baseurl = '<?php echo base_url(); ?>';
</script>
<script type="text/javascript" src="<?= _load('plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script type="text/javascript" src="<?= _load('plugins/moment/moment.min.js'); ?>"></script>
<script type="text/javascript" src="<?= _load('plugins/select2/js/select2.full.min.js'); ?>"></script>
<script type="text/javascript" src="<?= _load('plugins/daterangepicker/daterangepicker.js'); ?>"></script>
<script type="text/javascript" src="<?= _load('plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'); ?>"></script>
<script type="text/javascript"
		src="<?= _load('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'); ?>"></script>
<script type="text/javascript" src="<?= _load('plugins/summernote/summernote-bs4.min.js'); ?>"></script>
<script type="text/javascript"
		src="<?= _load('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'); ?>"></script>
<script type="text/javascript" src="<?= _load('plugins/datatables/jquery.dataTables.js'); ?>"></script>
<script type="text/javascript" src="<?= _load('plugins/datatables/datatables.js'); ?>"></script>
<script type="text/javascript" src="<?= _load('plugins/noty/lib/noty.js'); ?>"></script>
<script type="text/javascript" src="<?= _load('plugins/chart.js/Chart.min.js'); ?>"></script>
<script type="text/javascript" src="<?= _load('plugins/loading-overlay/loadingoverlay.min.js'); ?>"></script>
<script type="text/javascript" src="<?= _load('plugins/jquery-validation/dist/jquery.validate.min.js'); ?>"></script>
<script type="text/javascript" src="<?= _load('plugins/bootstrap-switch/js/bootstrap-switch.min.js'); ?>"></script>
<script type="text/javascript" src="<?= _load('js/adminlte.js'); ?>"></script>
<script type="text/javascript" src="<?= _load('js/kinet_underscore.js'); ?>"></script>
<script type="text/javascript" src="<?= _load('js/kinet_common.js'); ?>"></script>


<div class="modal fade" id="kinetModal" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered mw-100 w-75" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-sm-12 row">
					<div class="col-sm-10">
						<h4 class="modal-title" id="exampleModalLabel2nd"></h4>
					</div>
					<div class="col-sm-2">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				Content is loading...
			</div>
		</div>
	</div>
</div>

<?php
if ((isset($js)) && (!empty($js))) {
	foreach ($js as $file) :
		?>
		<script type="text/javascript" src="<?= _load($file); ?>"></script>
	<?php
	endforeach;
}
?>

<script type="text/javascript" src="<?= _load('js/demo.js'); ?>"></script>

</body>
</html>
