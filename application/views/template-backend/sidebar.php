<?php 
	class SideBarItem {
		var $name, $action_id, $url, $submenu;
		public function __construct($name, $action_id, $url = "#", $submenu = null) {
			$this->name			= $name;
			$this->action_id	= $action_id;
			$this->url			= $url;
			$this->submenu		= $submenu;
		}

		public function getUrl() {
			if($this->url != "#" || $this->action_id == UserAction::NONE) {
				return $this->url;
			} else {
				return backendUrl(getActionUrl($this->action_id));
			}
		}

		public function getClass() {
			return strtolower($this->name);
		}

		public function getName() {
			return ucfirst($this->name);
		}

		public function isActive() {
			$flag = false;
			if(currentUrl() == $this->getUrl()) {
				$flag = true;
			} elseif($this->action_id == UserAction::NONE && $this->submenu != null) {
				foreach($this->submenu as $temp) { 
					if(currentUrl() == $temp->getUrl()) {
						$flag = true;
					}
				}
			}
			return $flag;
		}

		public function hasAccess() {
			if($this->action_id == UserAction::NONE && $this->submenu != null) {
				$hasAccess = false;
				foreach($this->submenu as $temp) { 
					if(validateAction($temp->action_id)) {
						$hasAccess = true;
						break;
					}
				}
				return $hasAccess;
			} else {
				return TRUE;
			}
		}
	}

	$arrSideBarItem[] = new SideBarItem("DashBoard", UserAction::DASHBOARD, backendUrl("dashboard"));

	$submenu = array();
	$submenu[] = new SideBarItem("Add Actions", UserAction::ADDACTION, backendUrl("action/add"));
	$submenu[] = new SideBarItem("Manage Actions", UserAction::LISTACTION, backendUrl("action/pagedList"));
	$arrSideBarItem[] = new SideBarItem("Actions", UserAction::NONE, "javascript:;", $submenu);

	$submenu = array();
	$submenu[] = new SideBarItem("Add Role", UserAction::ADDROLE);
	$submenu[] = new SideBarItem("Manage Roles", UserAction::LISTROLE);
	$arrSideBarItem[] = new SideBarItem("Roles", UserAction::NONE, "javascript:;", $submenu);

	$submenu = array();
	$submenu[] = new SideBarItem("Add User", UserAction::DASHBOARD);
	$arrSideBarItem[] = new SideBarItem("User", UserAction::NONE, "javascript:;", $submenu);
?>

<!--sidebar start-->
<?php $userData = getLoggedUser(); ?>
<aside>
	<div id="sidebar"  class="nav-collapse ">
		<!-- sidebar menu start-->
		<ul class="sidebar-menu" id="nav-accordion">
			<p class="centered"><a href="profile.html"><img src="assets/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
			<h5 class="centered"><?php echo $userData->user_name; ?></h5>
			<?php foreach($arrSideBarItem as $item) { if(!$item->hasAccess()) { continue; } ?>
				<li class="<?php echo $item->submenu == null ? "mt" : "sub-menu"; ?>" >
					<a href="<?php echo $item->getUrl(); ?>" <?php if($item->isActive()) echo ' class="active"'; ?>>
						<i class="fa fa-<?php $item->getClass(); ?>"></i>
						<span><?php echo $item->getName(); ?></span>
					</a>
					<?php if($item->submenu != null) { ?>
						<ul class="sub">
							<?php foreach($item->submenu as $temp) { 
									if($temp->hasAccess()) { ?>
										<li><a href="<?php echo $temp->getUrl(); ?>"><?php echo $temp->getName(); ?></a></li>
							<?php }  } ?>
						</ul>
					<?php } ?>
				</li>
			<?php } ?>

			<!-- <li class="mt">
				<a href="<?php echo backendUrl('dashboard'); ?>"<?php if(!isset($module)) echo ' class="active"'; ?>>
					<i class="fa fa-dashboard"></i>
					<span>Dashboard</span>
				</a>
			</li>

			<li class="sub-menu">
				<a href="javascript:;"<?php if(isset($module) && $module == 'user') echo ' class="active"'; ?>>
					<i class="fa fa-users"></i>
					<span>User</span>
				</a>
				<ul class="sub">
					<li><a href="<?php echo base_url('backend/user/add'); ?>">Add User</a></li>
					<li><a href="<?php echo base_url('backend/user/manage'); ?>">Manage User</a></li>
				</ul>
			</li> -->
		</ul>
		<!-- sidebar menu end-->
	</div>
</aside>
<!--sidebar end-->