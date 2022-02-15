<?php 
if (!class_exists('User')) include_once(dirname(__FILE__).'/inc/user.php');
$userData = getUserLogin();
//$userData = $user->checkUser($userData);

$user_email 		= $userData['user_email'];
$user_nickname 		= $userData['user_nickname'] != '' ? $userData['user_nickname'] : $userData['user_first_name'].' '.$userData['user_last_name'];

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$location = str_replace($site_config['homepage'],'',$actual_link);
?>
    <nav class="navbar navbar-inverse navbar-fixed-top">

        <div class="container">
		<?php if($userData && !preg_match("/(file|folder)\/(.*)/i",$location)) { ?>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
                <a class="navbar-brand" href="<?=$site_config['homepage']?>/dashboard"><i class="fa fa-tachometer fa-2"></i> {{dashboard}}</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">

                <ul class="nav navbar-nav navbar-left">
				<?php if(preg_match("/dashboard/i",$location)) { ?>
                    <li><a href="<?=$site_config['homepage']?>/dashboard/manager"><span class="glyphicon glyphicon-folder-open"></span> {{file_manager}}</a></li>
					<!--
                    <li><a href="./dashboard/groups"><span class="fa fa-users"></span> Groups</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><span class="fa fa-money"></span> MMO <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="./dashboard/withdraw"><span class="fa fa-money"></span> Rút tiền</a></li>
                            <li><a href="./dashboard/earnings"><span class="glyphicon glyphicon-calendar"></span> Thu nhập</a></li>
                            <li><a href="./dashboard/withdrawal-history"><span class="fa fa-history"></span> Lịch sử GD</a></li>
                        </ul>
                    </li>
					-->
                    <li><a href="<?=$site_config['homepage']?>/dashboard/remote"><span class="glyphicon glyphicon-transfer"></span> {{remote}}</a></li>
					<?php } ?>
                </ul>

                <ul class="nav navbar-nav navbar-right">
				<?php if(preg_match("/dashboard/i",$location)) { ?>
                    <li><a href="<?=$site_config['homepage']?>/dashboard/upload"><i class="fa fa-cloud-upload"></i> {{upload}}</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i class="fa fa-user"></i> <?=$user_nickname?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="g-signin2" style="display:none"></li>
                            <li><a href="<?=$site_config['homepage']?>/dashboard/profile"><span class="glyphicon glyphicon-credit-card"></span> {{profile}}</a></li>
                            <li><a href="<?=$site_config['homepage']?>/logout" onclick="signOut();" title="{{logout}}"><span class="glyphicon glyphicon-log-in"></span> {{logout}}</a></li>
                        </ul>
                    </li>
					<?php } else { ?>
					<ul id="navbar" class="nav navbar-nav navbar-right">
						<li><a href="<?=$site_config['homepage']?>/dashboard"><i class="fa fa-tachometer"></i> {{dashboard}}</a></li>
						<li class="dropdown dropdown-notifications">
							<a href="#notifications-panel" class="dropdown-toggle">
								<span data-count="0" class="glyphicon glyphicon-bell notification-icon"></span>
							</a>
							<div class="dropdown-container">
								<div class="dropdown-toolbar">
									<h3 class="dropdown-toolbar-title">{{notification}}</h3>
								</div>
								<ul class="dropdown-menu no-notify">
								</ul>
								<div class="dropdown-footer text-center">
									<a onclick="javascript:location.href='<?=$site_config['homepage']?>/dashboard/withdrawal-history'" href="#">{{view_all}}</a>
								</div>
							</div>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i class="fa fa-user"></i> <?=$user_nickname?> <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li class="g-signin2" style="display:none"></li>
								<li><a href="<?=$site_config['homepage']?>/dashboard/profile"><i class="fa fa-credit-card"></i> {{profile}}</a></li>
								<li><a href="<?=$site_config['homepage']?>/logout" onclick="signOut();" title="{{logout}}"><span class="glyphicon glyphicon-log-in"></span> {{logout}}</a></li>
							</ul>
						</li>
					</ul>
					<?php } ?>
                </ul>
            </div>
		<?php } else { ?>
		        <div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
            <a class="navbar-brand" href="<?=$site_config['homepage']?>">
                <span class="fa fa-cloud fa-x2"></span> <?=$site_config['site_name']?>
            </a>
        </div>
		<?php if(!preg_match("/(file|folder)\/(.*)/i",$location)) { ?>
        
		<?php } ?>
		<?php } ?>
        </div>

        <script>
            function signOut() {
                var auth2 = gapi.auth2.getAuthInstance();
                auth2.signOut().then(function() {});
            }
        </script>
    </nav>
