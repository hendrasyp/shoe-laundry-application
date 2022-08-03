<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-dark-warning">
	<!-- Brand Logo -->
	<a href="<?= base_url('dashboard') ?>" class="brand-link bg-warning text-sm">
		<img src="<?= _load("img/mini-logo.png"); ?>" alt="<?=$config_company_name; ?>" class="brand-image img-circle elevation-3"
				 style="opacity: .8">
		<span class="brand-text font-weight-bolder" style="color: #FFF"><?=$config_company_name?></span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column  nav-child-indent nav-compact" data-widget="treeview"
					role="menu"
					data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class
								 with font-awesome or any other icon font library -->

<!--				<li class="nav-header">MAIN MENU--><?php ////echo sizeof($mainmenu); ?><!--</li>-->
				<?php //do_debug($mainmenu); ?>
				<?php
				$hasTreeView = "has-treeview";
				$noTreeView = "";
				for ($idx = 0; $idx < sizeof($mainmenu); $idx++) {
					$oMenu = "";
					$rootMenu = $mainmenu[$idx];
					$childCount = sizeof($mainmenu[$idx]["child"]);
					//if ($childCount > 0) {
					$oMenu .= '<li class="nav-item ' . $hasTreeView . '">';
					$oMenu .= '<a href="javascript:void(0);" class="nav-link active">';
					$oMenu .= '<i class="nav-icon fas ' . $rootMenu["menuIcon"] . '"></i>';
					$oMenu .= '<p>' . $rootMenu["menuTitle"] . '<i class="fas fa-angle-left right"></i></p>';
					$oMenu .= '</a>';
					$oMenu .= '<ul class="nav nav-treeview">';
					for ($idxChild = 0; $idxChild < $childCount; $idxChild++) {
						$child = $mainmenu[$idx]["child"][$idxChild];
						$oMenu .= '<li class="nav-item">';
						$oMenu .= '<a href="' . base_url($child['menuUrl']) . '" class="nav-link">';
						$oMenu .= '<i class="far ' . $child['menuIcon'] . ' nav-icon"></i>';
						$oMenu .= '<p>' . $child['menuTitle'] . '</p>';
						$oMenu .= '</a>';
						$oMenu .= '</li>';
					}
					$oMenu .= '</ul>';
					$oMenu .= '</li>';
					//}
					echo $oMenu;
				}
				?>


				<li class="nav-item">
					<a href="<?= base_url('auth/logout') ?>" class="nav-link active">
						<i class="nav-icon fas fa-edit"></i>
						<p>
							Logout
						</p>
					</a>

				</li>
<!--				<li class="nav-item">-->
<!--					<div style="max-width: 233px;-->
<!--    width: 100%;-->
<!--    overflow-x: scroll;-->
<!--    background-color: #FFF;-->
<!--    border-radius: 7px;">-->
<!--						--><?php
//
//						do_debug($userInfo);
//						?>
<!--					</div>-->
<!---->
<!--				</li>-->


			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>
