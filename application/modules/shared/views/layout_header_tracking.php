<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
	<meta http-equiv="Pragma" content="no-cache"/>
	<meta http-equiv="Expires" content="0"/>

	<title><?= (isset($page_title)) ? $page_title." | " : "Dashboard | ";?><?=COMPANY_NAME?></title>
	<link rel="shortcut icon" href="<?= _load("img/mini-logo.png"); ?>">
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php $this->load->view('shared/fragments/css_bundle'); ?>
</head>
<body class="hold-transition layout-top-nav text-sm">
<div class="wrapper">

<!--	TOP NAVBAR-->
	<!-- Navbar -->
	<nav class="main-header navbar navbar-expand navbar-dark navbar-gray-dark">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-search"></i></a>
			</li>
		</ul>
		<div class="page-title">
			<p class="page-title" style="line-height: 0px;
    margin-bottom: 0;
    color: #f4f6f9;
    font-size: 25px;
    padding-left: 7px;">Tracking</p>

		</div>
		<div class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto" id="navbarCollapse">

			<!-- SEARCH FORM -->
			<form class="form-inline md-12 pull-right float-right" id="fr">
				<div class="input-group input-group-sm">
					<input onkeyup="cariInvoice();" name="inv" id="inv" action="<?= base_url($pageurl) ?>" method="get"
								 id="frm_user_filter" style="color: white" value="<?=$nofaktur?>" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
					<div class="input-group-append">
						<button class="btn btn-navbar" type="submit" id="btnsubmit">
							<i class="fas fa-search"></i>
						</button>
					</div>
				</div>
			</form>
		</div>

	</nav>
	<!-- /.navbar -->

	<!--	TOP NAVBAR-->
	<?php //$this->load->view('shared/fragments/main_sidebar', array('mainmenu' => $menus)); ?>

	<div class="content-wrapper">

		<!-- Main content -->
		<section class="content" style="padding-top: 14px;">
			<div class="container-fluid" id="floki_container">
