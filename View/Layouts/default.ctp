<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo __('SQLBoss:'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		// echo $this->Html->meta('icon', $this->Html->url('/favicon.png'));
		echo $this->Html->css('bootstrap');
		echo $this->Html->css('bootstrap-responsive');
		echo $this->Html->css('/media/font-awesome/css/font-awesome.min.css');

		echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js');
		echo $this->Html->script('bootstrap');

		echo $this->fetch('meta');
		echo $this->fetch('css');
	?>
</head>
<body>
	<div class="container-fluid">
		<div class="navbar" style="padding-top: 10px">
			<div class="navbar-inner">
				<div class="container">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<?php echo $this->Html->link('SQLBoss', array('controller' => 'pages'), array(
						'class' => 'brand'
					)) ?>
					
					<?php if ( ! isset($connection_parameters)) $connection_parameters = array(); ?>

					<div class="nav-collapse collapse">
						<ul class="nav">
							<li><?php echo $this->Html->link(
								'Query',
								array(
									'controller' => 'queries',
									'action'     => 'index'
								) + $connection_parameters
							) ?></li>
							<li><?php echo $this->Html->link(
								'History',
								array(
									'controller' => 'queries',
									'action'     => 'history'
								) + $connection_parameters
							) ?></li>
							<li><?php echo $this->Html->link(
								'Saved',
								array(
									'controller' => 'queries',
									'action'     => 'saved'
								) + $connection_parameters
							) ?></li>
							<li><?php echo $this->Html->link(
								'Databases',
								array(
									'controller' => 'databases',
									'action'     => 'index'
								) + $connection_parameters
							) ?></li>
						</ul>
						<ul class="nav pull-right">
							<li>
								<?php echo $this->Html->link(
									$auth_user['username'],
									array('controller' => 'users', 'action' => 'view', $auth_user['id']),
									array('title' => 'View profile')
								) ?>
							</li>
							<li class="dropdown">
								<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" title="Administration">
									<i class="icon-cogs"></i> <b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<li><?php echo $this->Html->link(
										'Connections',
										array('controller' => 'connections', 'action' => 'index')
									) ?></li>
									<li><?php echo $this->Html->link(
										'Users',
										array('controller' => 'users', 'action' => 'index')
									) ?></li>
								</ul>
							</li>
							<li>
								<?php echo $this->Html->link(
									'<i class="icon-signout"></i>',
									array('controller' => 'users', 'action' => 'logout'),
									array('escape' => false, 'title' => 'Sign out')
								) ?>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<?php echo $this->Session->flash('flash', array(
					'params' => array('class' => 'alert')
			)); ?>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<?php echo $this->fetch('content'); ?>
			</div>
		</div>
	</div>
	<?php //echo $this->element('sql_dump'); ?>
	<?php echo $this->fetch('script'); ?>
</body>
</html>
