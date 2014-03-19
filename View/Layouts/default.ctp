<!DOCTYPE html>
<html lang="en">
<head>
  <?php echo $this->Html->charset(); ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="/favicon.png" />
  <title>
    <?php echo __('SQLBoss:'); ?>
    <?php echo $title_for_layout; ?>
  </title>
  <?php
    echo $this->Html->css('//cdn.jsdelivr.net/bootstrap/3.1.1/css/bootstrap.min.css');
    echo $this->Html->css('//cdn.jsdelivr.net/fontawesome/4.0.3/css/font-awesome.min.css');

    echo $this->fetch('meta');
    echo $this->fetch('css');
  ?>
</head>
<body>
  <div class="navbar navbar-default">
    <div class="container-fluid">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#sqlboss-navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="fa fa-bars"></span>
          </button>
          <?php echo $this->Html->link('SQLBoss', array('controller' => 'pages'), array(
            'class' => 'navbar-brand'
          )) ?>
        </div>
        
        <?php if ( ! isset($connection_parameters)) $connection_parameters = array(); ?>

        <div class="collapse navbar-collapse" id="sqlboss-navbar-collapse">
          <ul class="nav navbar-nav">
            <li <?php echo ($this->params['controller'] == 'schema' ? 'class="active"' : '') ?>><?php echo $this->Html->link(
              'Schema',
              array(
                'controller' => 'schema',
                'action'     => 'index'
              ) + $connection_parameters
            ) ?></li>
            <li <?php echo ($this->params['controller'] == 'queries' && $this->params['action'] == 'index' ? 'class="active"' : '') ?>><?php echo $this->Html->link(
              'Query',
              array(
                'controller' => 'queries',
                'action'     => 'index'
              ) + $connection_parameters
            ) ?></li>
            <li <?php echo ($this->params['controller'] == 'queries' && $this->params['action'] == 'history' ? 'class="active"' : '') ?>>
              <?php echo $this->Html->link(
                'History',
                array(
                  'controller' => 'queries',
                  'action'     => 'history'
                ) + $connection_parameters
              ) ?>
            </li>
            <li <?php echo ($this->params['controller'] == 'queries' && $this->params['action'] == 'saved' ? 'class="active"' : '') ?>>
              <?php echo $this->Html->link(
                'Saved',
                array(
                  'controller' => 'queries',
                  'action'     => 'saved'
                ) + $connection_parameters
              ) ?>
            </li>
            <li <?php echo ($this->params['controller'] == 'databases') ? 'class="active"' : ''?>>
              <?php echo $this->Html->link(
                'Databases',
                array(
                  'controller' => 'databases',
                  'action'     => 'index'
                ) + $connection_parameters
              ) ?>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li>
              <?php echo $this->Html->link(
                $auth_user['username'],
                array('controller' => 'users', 'action' => 'view', $auth_user['id']),
                array('title' => 'View profile')
              ) ?>
            </li>
            <li class="dropdown">
              <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" title="Administration">
                <i class="fa fa-cogs"></i>
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
                '<i class="fa fa-sign-out"></i>',
                array('controller' => 'users', 'action' => 'logout'),
                array('escape' => false, 'title' => 'Sign out')
              ) ?>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12 col-md-12">
        <?php echo $this->Session->flash('flash', array(
            'params' => array('class' => 'alert alert-warning')
        )); ?>
        <?php echo $this->fetch('content'); ?>
      </div>
    </div>
  </div>
  <?php echo $this->element('sql_dump'); ?>
  <?php echo $this->fetch('script'); ?>
</body>
    echo $this->Html->script('//cdn.jsdelivr.net/jquery/2.1.0/jquery.min.js');
    echo $this->Html->script('//cdn.jsdelivr.net/bootstrap/3.1.1/js/bootstrap.min.js');
</html>
