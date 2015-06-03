<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Default Public Template
*/
?><!DOCTYPE html>
<html class="st-layout ls-top-navbar ls-bottom-footer show-sidebar sidebar-l1 sidebar-r2" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico?v=<?php echo $this->settings->site_version; ?>">
	<link rel="icon" type="image/x-icon" href="/favicon.ico?v=<?php echo $this->settings->site_version; ?>">
    <title><?php echo $page_title; ?> - <?php echo $this->settings->site_name; ?></title>
    <meta name="keywords" content="<?php echo $this->settings->meta_keywords; ?>">
    <meta name="description" content="<?php echo $this->settings->meta_description; ?>">

    <?php // CSS files ?>
    <?php if (isset($custom_css_files) && is_array($custom_css_files)) : ?>
	<?php foreach ($custom_css_files as $css) : ?>
	    <?php if ( ! is_null($css)) : ?>
	    <!-- Compressed Vendor BUNDLE
	    Includes vendor (3rd party) styling such as the customized Bootstrap and other 3rd party libraries used for the current theme/module -->
		<link rel="stylesheet" href="<?php echo $css; ?>vendor.min.css"><?php echo "\n"; ?>
<!-- Compressed Theme BUNDLE
Note: The bundle includes all the custom styling required for the current theme, however
it was tweaked for the current theme/module and does NOT include ALL of the standalone modules;
The bundle was generated using modern frontend development tools that are provided with the package
To learn more about the development process, please refer to the documentation. -->
    <!-- <link href="css/theme.bundle.min.css" rel="stylesheet"> -->
    <!-- Compressed Theme CORE
This variant is to be used when loading the separate styling modules -->
    <link href="<?php echo $css; ?>theme-core.min.css" rel="stylesheet">
    <!-- Standalone Modules
    As a convenience, we provide the entire UI framework broke down in separate modules
    Some of the standalone modules may have not been used with the current theme/module
    but ALL modules are 100% compatible -->
    <link href="<?php echo $css; ?>module-essentials.min.css" rel="stylesheet" />
    <link href="<?php echo $css; ?>module-layout.min.css" rel="stylesheet" />
    <link href="<?php echo $css; ?>module-sidebar.min.css" rel="stylesheet" />
    <link href="<?php echo $css; ?>module-sidebar-skins.min.css" rel="stylesheet" />
    <link href="<?php echo $css; ?>module-navbar.min.css" rel="stylesheet" />
    <link href="<?php echo $css; ?>module-media.min.css" rel="stylesheet" />
    <!-- <link href="<?php echo $css; ?>module-timeline.min.css" rel="stylesheet" /> -->
    <!-- <link href="<?php echo $css; ?>module-cover.min.css" rel="stylesheet" /> -->
    <link href="<?php echo $css; ?>module-chat.min.css" rel="stylesheet" />
    <!-- <link href="<?php echo $css; ?>module-charts.min.css" rel="stylesheet" /> -->
    <!-- <link href="<?php echo $css; ?>module-maps.min.css" rel="stylesheet" /> -->
    <!-- <link href="<?php echo $css; ?>module-colors-alerts.min.css" rel="stylesheet" /> -->
    <link href="<?php echo $css; ?>module-colors-background.min.css" rel="stylesheet" />
    <link href="<?php echo $css; ?>module-colors-buttons.min.css" rel="stylesheet" />
    <!-- <link href="<?php echo $css; ?>module-colors-calendar.min.css" rel="stylesheet" /> -->
    <!-- <link href="<?php echo $css; ?>module-colors-progress-bars.min.css" rel="stylesheet" /> -->
    <link href="<?php echo $css; ?>module-colors-text.min.css" rel="stylesheet" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries
WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!-- If you don't need support for Internet Explorer <= 8 you can safely remove these -->
    <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
	    <?php endif; ?>
	<?php endforeach; ?>
    <?php endif; ?>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <!-- Wrapper required for sidebar transitions -->
    <div class="st-container">
	    <!-- Fixed navbar -->
	<div class="navbar navbar-main navbar-default navbar-fixed-top" role="navigation">
	    <div class="container-fluid">
		<div class="navbar-header">
		    <a href="#sidebar-menu" data-toggle="sidebar-menu" class="toggle pull-left visible-xs"><i class="fa fa-bars"></i></a>
		    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		    </button>
		    <a href="#sidebar-chat" data-toggle="sidebar-menu" class="toggle pull-right visible-xs"><i class="fa fa-comments"></i></a>
		    <a class="navbar-brand" href="<?php echo base_url('welcome'); ?>"><?php echo $this->settings->site_name; ?></a>
		</div>


		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="main-nav">
		  <?php // Nav bar left ?>
		  <ul class="nav navbar-nav">
		      <li class="<?php echo (uri_string() == '') ? 'active' : ''; ?>"><a href="<?php echo base_url('welcome'); ?>"><?php echo lang('core button home'); ?></a></li>
		      <li class="<?php echo (uri_string() == 'contact') ? 'active' : ''; ?>"><a href="<?php echo base_url('contact'); ?>"><?php echo lang('core button contact'); ?></a></li>
			<li><a href="<?php echo base_url('api/users'); ?>">API</a></li>
			<li><a href="<?php echo base_url('africa'); ?>">Africa</a></li>
		  </ul>
		  <?php // Nav bar right ?>
		  <ul class="nav navbar-nav navbar-right">
		      <?php if ($this->session->userdata('logged_in')) : ?>
			  <?php if ($this->user['is_admin']) : ?>
			      <li><a href="<?php echo base_url('admin'); ?>"><?php echo lang('core button admin'); ?></a></li>
			  <?php endif; ?>
			<!-- user -->
			<li class="dropdown user">
			    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
<img src="<?php echo base_url('themes/default/images/people/110/guy-6.jpg'); ?> "alt="" class="img-circle" /> <?php echo $this->user['first_name']; ?> <span class="caret"></span>
			    </a>
			    <ul class="dropdown-menu" role="menu">
				<li><a href="<?php echo base_url('profile'); ?>"><i class="fa fa-user"></i>Profile</a>
				</li>
				<li><a href="#"><i class="fa fa-wrench"></i>Settings</a>
				</li>
				<li><a href="<?php echo base_url('logout'); ?>"><i class="fa fa-sign-out"></i>Logout</a>
				</li>
			    </ul>
			</li>
			<!-- // END user -->
		      <?php else : ?>
			<!-- Login -->
			<li class="dropdown">
			    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<i class="fa fa-fw fa-lock"></i> Login
			    </a>
			    <div class="dropdown-menu dropdown-size-280">

				<!---------LOGIN FORM --------------------->
			<!--Error messages-->

			    <?php // System messages ?>
	<?php if ($this->session->flashdata('message')) : ?>
	    <div class="row alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php echo $this->session->flashdata('message'); ?>
	    </div>
	<?php elseif ($this->session->flashdata('error')) : ?>
	    <div class="row alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php echo $this->session->flashdata('error'); ?>
	    </div>
	<?php elseif (validation_errors()) : ?>
	    <div class="row alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php echo validation_errors(); ?>
	    </div>
	<?php elseif ($this->error) : ?>
	    <div class="row alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php echo $this->error; ?>
	    </div>
      <?php endif; ?>
			<!--End of Error messages-->		
			    <?php echo form_open('', array('role'=>'form')); ?>
			    <div class="form-group">
				<div class="input-group">
				    <span class="input-group-addon"><i class="fa fa-user"></i></span>
				    <?php echo form_input(array('name'=>'login_username', 'id'=>'login_username', 'class'=>'form-control', 'placeholder'=>'Username')); ?>
				</div>
			    </div>
			    <div class="form-group">
				<div class="input-group">
				    <span class="input-group-addon"><i class="fa fa-shield"></i></span>
				    <?php echo form_password(array('name'=>'login_password', 'id'=>'login_password', 'class'=>'form-control', 'placeholder'=>'Password')); ?>
				</div>
			    </div>
			    <div class="text-center">
				<button name= "submit_login" type="submit" class="btn btn-primary">Login <i class="fa fa-sign-in"></i></button>
			    </div>
			    <div class="text-center">
				<a href="<?php echo base_url('user/forgot'); ?>">Forgot password?</a>
			    </div>
			    <?php echo form_close(); ?>
			    </div>
			</li>
			<!-- // END login -->
			
			<!-- Sign up -->
			<li class="dropdown">
			    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw fa-plus"></i> Sign Up</a>
			    <div class="dropdown-menu dropdown-size-280">			   
			    <?php echo form_open('', array('role'=>'form')); ?>
				    <?php // username ?>
				    <div class="form-group form-control-default required <?php echo form_error('username') ? ' has-error' : ''; ?>">
				    <?php echo form_label(lang('users input username'), 'username'); ?>
				    <?php echo form_input(array('name'=>'username', 'value'=>set_value('username', (isset($user['username']) ? $user['username'] : '')), 'class'=>'form-control')); ?>
				    </div>

				<div class="row">
				    <div class="col-md-6">
					    <?php // first name ?>
					    <div class="form-group form-control-default required <?php echo form_error('first_name') ? ' has-error' : ''; ?>">
						<?php echo form_label(lang('users input first_name'), 'first_name');?>
						<?php echo form_input(array('name'=>'first_name', 'value'=>set_value('first_name', (isset($user['first_name']) ? $user['first_name'] : '')), 'class'=>'form-control')); ?>
					    </div>

				    </div>
				    <div class="col-md-6">
					    <?php // last name ?>
					    <div class="form-group form-control-default required <?php echo form_error('last_name') ? ' has-error' : ''; ?>">
						<?php echo form_label(lang('users input last_name'), 'last_name'); ?>
						<?php echo form_input(array('name'=>'last_name', 'value'=>set_value('last_name', (isset($user['last_name']) ? $user['last_name'] : '')), 'class'=>'form-control')); ?>
					    </div>
				    </div>
				</div>
				    <?php // email ?>
				    <div class="form-group form-control-default required <?php echo form_error('email') ? ' has-error' : ''; ?>">
					<?php echo form_label(lang('users input email'), 'email'); ?>
					<?php echo form_input(array('name'=>'email', 'value'=>set_value('email', (isset($user['email']) ? $user['email'] : '')), 'class'=>'form-control')); ?>
				    </div>
				    <?php // password ?>
				    <div class="form-group form-control-default required <?php echo form_error('password') ? ' has-error' : ''; ?>">
					<?php echo form_label(lang('users input password'), 'password'); ?>
					<?php echo form_password(array('name'=>'password', 'value'=>'', 'class'=>'form-control', 'autocomplete'=>'off')); ?>
				    </div>
				    <div class="form-group form-control-default required <?php echo form_error('password_repeat') ? ' has-error' : ''; ?>">
					<?php echo form_label(lang('users input password_repeat'), 'password_repeat'); ?>
					<?php echo form_password(array('name'=>'password_repeat', 'value'=>'', 'class'=>'form-control', 'autocomplete'=>'off')); ?>
				    </div>
				    <div class="row">
				    <?php if ( ! $password_required) : ?>
					<span class="help-block"><br /><?php echo lang('users help passwords'); ?></span>
				    <?php endif; ?>
					</div>
				<?php // buttons ?>
				    <?php if ($this->session->userdata('logged_in')) : ?>
					<button type="submit" name="submit_save" class="btn btn-success"><span class="glyphicon glyphicon-save"></span> <?php echo lang('core button save'); ?></button>
				    <?php else : ?>
					<button type="submit" name="submit_register" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> <?php echo lang('users button register'); ?></button>
				    <?php endif; ?>
			    <?php echo form_close(); ?>
			    </div>
			</li>
			<!-- // END sign up -->
		      <?php endif; ?>
		    </ul>
		    <form class="navbar-form navbar-right">
			<div class="search-2">
			    <div class="input-group">
				<input type="text" class="form-control form-control-w-150" placeholder="Search ..">
				<span class="input-group-btn">
				  <button class="btn btn-inverse" type="button"><i class="fa fa-search"></i></button>
				</span>
			    </div>
			</div>
		    </form>
		</div>
		<!-- /.navbar-collapse -->
	    </div>
	</div>

	<!-- Sidebar component with st-effect-1 (set on the toggle button within the navbar) -->
	<div class="sidebar left sidebar-size-1 sidebar-mini-reveal sidebar-offset-0 sidebar-skin-dark sidebar-visible-desktop" id=sidebar-menu data-type=dropdown>
	    <div data-scrollable>
		<ul class="sidebar-menu sm-active-item-bg sm-icons-block sm-icons-right">
		    <li class="active"><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i><span>Highlights</span></a>
		    </li>
		    <li><a href="<?php echo base_url('discover'); ?>"><i class="fa fa-music"></i><span>Discover</span></a></li>
		    <li><a href="discover.html"><i class="fa fa-music"></i><span>Music</span></a></li>
		    <li><a href="<?php echo base_url('places'); ?>"><i class="fa fa-star"></i><span>Places</span></a>
		    <li><a href="<?php echo base_url('people'); ?>"><i class="fa fa-star"></i><span>People</span></a>
		    </li>
		    <li><a href="player.html"><i class="fa fa-play-circle"></i><span>History</span></a>
		    </li>
		    <li><a href="gallery.html"><i class="fa fa-photo"></i><span>Art &amp Fashion</span></a></li>
		    <li><a href="gallery.html"><i class="fa fa-photo"></i><span>Books</span></a></li>
		    <li><a href="gallery.html"><i class="fa fa-photo"></i><span>Newspapers</span></a></li>
		    <li><a href="gallery.html"><i class="fa fa-photo"></i><span>Radio</span></a></li>
		    <li><a href="gallery.html"><i class="fa fa-photo"></i><span>Culture</span></a></li>
		</ul>
	    </div>
	</div>
	  <!-- Sidebar component with st-effect-1 (set on the toggle button within the navbar) -->
	<div class="sidebar sidebar-chat right sidebar-size-2 sidebar-offset-0 chat-skin-white sidebar-skin-white sidebar-visible-desktop" id=sidebar-chat>
	    <div class="split-vertical">
		<div class="tabbable tabs-icons tabs-highlight-bottom">
		    <ul class="nav nav-tabs">
			<li class="active"><a href="#sidebar-tabs-activity" data-toggle="tab"><i class="fa fa-bar-chart-o"></i></a>
			</li>
			<li><a href="#sidebar-tabs-chat" data-toggle="tab"><i class="fa fa-comments"></i></a>
			</li>
		    </ul>
		</div>
		<div class="split-vertical-body">
		    <div class="split-vertical-cell">
			<div class="tab-content">
			    <div class="tab-pane active" id="sidebar-tabs-activity">
				<div data-scrollable>
				    <h4 class="category">Activity</h4>
				    <div class="sidebar-block">
					<p><i class="fa fa-fw icon-paper-document text-pink-500"></i>
					    <a href="" class="sidebar-link">
						<strong>Caspian</strong> Announcing New Album Release Date</a>
					</p>
					<p><i class="fa fa-fw icon-music-note-2 text-pink-500"></i> <a href="" class="sidebar-link">Listen <strong>Bloom</strong>, the New single from Voyager</a>
					</p>
					<a class="btn btn-xs btn-pink-500" href="">more</a>
				    </div>
				    <h4 class="category">Top Plays</h4>
				    <div class="sidebar-block list-group list-group-menu list-group-striped">
					<div class="list-group-item">
					    <div class="media">
						<div class="media-left">
						    <a href="album.html">
						      <img src="<?php echo base_url('themes/default/images/50/main-playing-guitar.jpg'); ?>" alt="cover" class="media-object" />
						    </a>
						</div>
						<div class="media-body">
						    <h4 class="text-h5 media-heading margin-v-1-2"><a href="album.html">Bloom</a>
						    </h4>
						    <p class="text-grey-500">Woodland (2011)</p>
						</div>
					    </div>
					</div>
					<div class="list-group-item">
					    <div class="media">
						<div class="media-left">
						    <a href="album.html">
						      <img src="<?php echo base_url('themes/default/images/50/portrait-trendy-hair-style.jpg'); ?>" width="35" alt="cover" class="media-object" />
						    </a>
						</div>
						<div class="media-body">
						    <h4 class="text-h5 media-heading margin-v-1-2"><a href="album.html">Dreams</a>
						    </h4>
						    <p class="text-grey-500">Shinning (2014)</p>
						</div>
					    </div>
					</div>
					<div class="list-group-item">
					    <div class="media">
						<div class="media-left">
						    <a href="album.html">
							<img src="<?php echo base_url('themes/default/images/50/singing-woman.jpg'); ?>" width="35" alt="cover" class="media-object" />
						    </a>
						</div>
						<div class="media-body">
						    <h4 class="text-h5 media-heading margin-v-1-2"><a href="album.html">Something</a>
						    </h4>
						    <p class="text-grey-500">Different (2014)</p>
						</div>
					    </div>
					</div>
				    </div>
				    <h4 class="category">Discover Music</h4>
				    <div class="sidebar-block">
					<p>Build for music enthusiasts, our platform has lots of ways to help you find music you'll love and artists you'll fall in love with.</p>
					<a class="btn btn-primary" href="discover.html"><i class="fa fa-fw fa-search"></i> Search</a>
				    </div>
				    <p>&nbsp;</p>
				    <p>&nbsp;</p>
				    <p>&nbsp;</p>
				    <p>&nbsp;</p>
				    <p>&nbsp;</p>
				    <p>&nbsp;</p>
				    <p>&nbsp;</p>
				    <p>&nbsp;</p>
				    <p>&nbsp;</p>
				    <p>&nbsp;</p>
				    <p>&nbsp;</p>
				    <p>&nbsp;</p>
				    <div class="sidebar-block">
					<p>End of scrollable content</p>
				    </div>
				</div>
			    </div>
			    <div class="tab-pane" id="sidebar-tabs-chat">
				<div class="split-vertical">
				    <div class="chat-search">
					<input type="text" class="form-control" placeholder="Search" />
				    </div>
				    <ul class="chat-filter nav nav-pills ">
					<li class="active"><a href="#" data-target="li">All</a>
					</li>
					<li><a href="#" data-target=".online">Online</a>
					</li>
					<li><a href="#" data-target=".offline">Offline</a>
					</li>
				    </ul>
				    <div class="split-vertical-body">
					<div class="split-vertical-cell">
					    <div data-scrollable>
						<ul class="chat-contacts">
						    <li class="online" data-user-id="1">
							<a href="#">
							    <div class="media">
								<div class="pull-left">
								    <span class="status"></span>
								      <img src="<?php echo base_url('themes/default/images/people/110/guy-6.jpg'); ?>" width="40" class="img-circle" />
								</div>
								<div class="media-body">
								    <div class="contact-name">Jonathan S.</div>
								    <small>"Free Today"</small>
								</div>
							    </div>
							</a>
						    </li>
						    <li class="online away" data-user-id="2">
							<a href="#">
							    <div class="media">
								<div class="pull-left">
								    <span class="status"></span>
								      <img src="<?php echo base_url('themes/default/images/people/110/woman-5.jpg'); ?>" width="40" class="img-circle" />
								</div>
								<div class="media-body">
								    <div class="contact-name">Mary A.</div>
								    <small>"Feeling Groovy"</small>
								</div>
							    </div>
							</a>
						    </li>
						    <li class="online" data-user-id="3">
							<a href="#">
							    <div class="media">
								<div class="pull-left ">
								    <span class="status"></span>
								      <img src="<?php echo base_url('themes/default/images/people/110/guy-3.jpg'); ?>"  width="40" class="img-circle" />
								</div>
								<div class="media-body">
								    <div class="contact-name">Adrian D.</div>
								    <small>Busy</small>
								</div>
							    </div>
							</a>
						    </li>
						    <li class="offline" data-user-id="4">
							<a href="#">
							    <div class="media">
								<div class="pull-left">
								    <img src="<?php echo base_url('themes/default/images/people/110/woman-6.jpg'); ?>" width="40" class="img-circle" />
								</div>
								<div class="media-body">
								    <div class="contact-name">Michelle S.</div>
								    <small>Offline</small>
								</div>
							    </div>
							</a>
						    </li>
						    <li class="offline" data-user-id="5">
							<a href="#">
							    <div class="media">
								<div class="pull-left">
								  <img src="<?php echo base_url('themes/default/images/people/110/woman-7.jpg'); ?>" width="40" class="img-circle" />
								</div>
								<div class="media-body">
								    <div class="contact-name">Daniele A.</div>
								    <small>Offline</small>
								</div>
							    </div>
							</a>
						    </li>
						    <li class="online" data-user-id="6">
							<a href="#">
							    <div class="media">
								<div class="pull-left">
								    <span class="status"></span>
									<img src="<?php echo base_url('themes/default/images/people/110/guy-4.jpg'); ?>" width="40" class="img-circle" />
								</div>
								<div class="media-body">
								    <div class="contact-name">Jake F.</div>
								    <small>Busy</small>
								</div>
							    </div>
							</a>
						    </li>
						    <li class="online away" data-user-id="7">
							<a href="#">
							    <div class="media">
								<div class="pull-left">
								    <span class="status"></span>
								      <img src="<?php echo base_url('themes/default/images/people/110/woman-6.jpg'); ?>" width="40" class="img-circle" />
								</div>
								<div class="media-body">
								    <div class="contact-name">Jane A.</div>
								    <small>"Custom Status"</small>
								</div>
							    </div>
							</a>
						    </li>
						    <li class="offline" data-user-id="8">
							<a href="#">
							    <div class="media">
								<div class="pull-left">
								    <span class="status"></span>
								      <img src="<?php echo base_url('themes/default/images/people/110/woman-8.jpg'); ?>" width="40" class="img-circle" />
								</div>
								<div class="media-body">
								    <div class="contact-name">Sabine J.</div>
								    <small>"Offline right now"</small>
								</div>
							    </div>
							</a>
						    </li>
						    <li class="online away" data-user-id="9">
							<a href="#">
							    <div class="media">
								<div class="pull-left">
								    <span class="status"></span>
								      <img src="<?php echo base_url('themes/default/images/people/110/woman-9.jpg'); ?>" width="40" class="img-circle" />
								</div>
								<div class="media-body">
								    <div class="contact-name">Danny B.</div>
								    <small>Be Right Back</small>
								</div>
							    </div>
							</a>
						    </li>
						    <li class="online" data-user-id="10">
							<a href="#">
							    <div class="media">
								<div class="pull-left">
								    <span class="status"></span>
								      <img src="<?php echo base_url('themes/default/images/people/110/woman-8.jpg'); ?>" width="40" class="img-circle" />
								</div>
								<div class="media-body">
								    <div class="contact-name">Elise J.</div>
								    <small>My Status</small>
								</div>
							    </div>
							</a>
						    </li>
						    <li class="online" data-user-id="11">
							<a href="#">
							    <div class="media">
								<div class="pull-left">
								    <span class="status"></span>
								      <img src="<?php echo base_url('themes/default/images/people/110/guy-3.jpg'); ?>"width="40" class="img-circle" />
								</div>
								<div class="media-body">
								    <div class="contact-name">John J.</div>
								    <small>My Status #1</small>
								</div>
							    </div>
							</a>
						    </li>
						</ul>
					    </div>
					</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
	    </div>
	</div>
	<script id="chat-window-template" type="text/x-handlebars-template">
	    <div class="panel panel-default">
		<div class="panel-heading" data-toggle="chat-collapse" data-target="#chat-bill">
		    <a href="#" class="close"><i class="fa fa-times"></i></a>
		    <a href="#">
			<span class="pull-left">
		    <img src="{{ user_image }}" width="40">
		</span>
			<span class="contact-name">{{user}}</span>
		    </a>
		</div>
		<div class="panel-body" id="chat-bill">
		    <div class="media">
			<div class="media-left">
			    <img src="{{ user_image }}" width="25" class="img-circle" alt="people" />
			</div>
			<div class="media-body">
			    <span class="message">Feeling Groovy?</span>
			</div>
		    </div>
		    <div class="media">
			<div class="media-left">
			    <img src="{{ user_image }}" width="25" class="img-circle" alt="people" />
			</div>
			<div class="media-body">
			    <span class="message">Yep.</span>
			</div>
		    </div>
		    <div class="media">
			<div class="media-left">
			    <img src="{{ user_image }}" width="25" class="img-circle" alt="people" />
			</div>
			<div class="media-body">
			    <span class="message">This chat window looks amazing.</span>
			</div>
		    </div>
		    <div class="media">
			<div class="media-left">
			    <img src="{{ user_image }}" width="25" class="img-circle" alt="people" />
			</div>
			<div class="media-body">
			    <span class="message">Thanks!</span>
			</div>
		    </div>
		</div>
		<input type="text" class="form-control" placeholder="Type message..." />
	    </div>
	</script>
      <div class="chat-window-container"></div>
	<!-- sidebar effects OUTSIDE of st-pusher: -->
	<!-- st-effect-1, st-effect-2, st-effect-4, st-effect-5, st-effect-9, st-effect-10, st-effect-11, st-effect-12, st-effect-13 -->
	<!-- content push wrapper -->

    <?php // Main body ?>
    <!-- Main Content -->
        <div class="st-pusher">
            <!-- sidebar effects INSIDE of st-pusher: -->
            <!-- st-effect-3, st-effect-6, st-effect-7, st-effect-8, st-effect-14 -->
            <!-- this is the wrapper for the content -->
            <div class="st-content">
                <!-- extra div for emulating position:fixed of the menu -->
                <div class="st-content-inner" id="content">
    			<?php echo $content; ?>
                </div>
                <!-- /st-content-inner -->
            </div>
            <!-- /st-content -->
        </div>
        <!-- /st-pusher -->


    <?php // Footer ?>
    <!-- Footer -->
	<div class="footer">

    <div id="audio" class="player audio player-control-primary player-white" role="application" aria-label="media player">
		<div id="jquery_jplayer_audio_1" class="jplayer"></div>
		<div class="gui-wrapper">
		    <div class="gui">
			<div class="play-control control">
			    <button class="play button" role="button" aria-label="play" tabindex="0"></button>
			</div>
			<div class="bar">
			    <div class="seek-bar seek-bar-display"></div>
			    <div class="seek-bar">
				<div class="play-bar"></div>
				<div class="details"><span class="title" aria-label="title"></span>
				</div>
				<div class="timing"><span class="duration" role="timer" aria-label="duration"></span>
				</div>
			    </div>
			</div>
		    </div>
		</div>
		<div class="no-solution">Media Player Error
		    <br>Update your browser or Flash plugin</div>
	    </div>
	</div>
	<!-- // Footer -->
    </div>
    <?php // Javascript files ?>

    <!-- Inline Script for colors and config objects; used by various external scripts; -->
    <script>
    var colors = {
	"danger-color": "#e74c3c",
	"success-color": "#81b53e",
	"warning-color": "#f0ad4e",
	"inverse-color": "#2c3e50",
	"info-color": "#2d7cb5",
	"default-color": "#6e7882",
	"default-light-color": "#cfd9db",
	"purple-color": "#9D8AC7",
	"mustard-color": "#d4d171",
	"lightred-color": "#e15258",
	"body-bg": "#f6f6f6"
    };
    var config = {
	theme: "music",
	skins: {
	    "default": {
		"primary-color": "#3498db"
	    }
	}
    };
    </script>

    <?php if (isset($custom_js_files) && is_array($custom_js_files)) : ?>
	<?php foreach ($custom_js_files as $js) : ?>
	    <?php if ( ! is_null($js)) : ?>
		<?php echo "\n"; ?><script type="text/javascript" src="<?php echo $js; ?>vendor-core.min.js"></script><?php echo "\n"; ?>
		<?php echo "\n"; ?><script type="text/javascript" src="<?php echo $js; ?>vendor-forms.min.js"></script><?php echo "\n"; ?>
		<?php echo "\n"; ?><script type="text/javascript" src="<?php echo $js; ?>vendor-media.min.js"></script><?php echo "\n"; ?>
		<?php echo "\n"; ?><script type="text/javascript" src="<?php echo $js; ?>vendor-player.min.js"></script><?php echo "\n"; ?>
		<!-- Standalone Modules
		    As a convenience, we provide the entire UI framework broke down in separate modules
		    Some of the standalone modules may have not been used with the current theme/module
		    but ALL the modules are 100% compatible -->
		<?php echo "\n"; ?><script type="text/javascript" src="<?php echo $js; ?>module-essentials.min.js"></script><?php echo "\n"; ?>
		<?php echo "\n"; ?><script type="text/javascript" src="<?php echo $js; ?>module-layout.min.js"></script><?php echo "\n"; ?>
		<?php echo "\n"; ?><script type="text/javascript" src="<?php echo $js; ?>module-sidebar.min.js"></script><?php echo "\n"; ?>
		<?php echo "\n"; ?><script type="text/javascript" src="<?php echo $js; ?>module-media.min.js"></script><?php echo "\n"; ?>
		<?php echo "\n"; ?><script type="text/javascript" src="<?php echo $js; ?>module-player.min.js"></script><?php echo "\n"; ?>
		<?php echo "\n"; ?><script type="text/javascript" src="<?php echo $js; ?>module-chat.min.js"></script><?php echo "\n"; ?>
	    <?php endif; ?>
	<?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
