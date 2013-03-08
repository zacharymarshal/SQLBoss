<dl>
    <dt><?php echo __('Host') ?></dt>
    <dd><?php echo h($connection['Connection']['host']) ?></dd>
    <dt><?php echo __('Username') ?></dt>
    <dd><?php echo h($connection['Connection']['username']) ?></dd>
    <dt><?php echo __('Password') ?></dt>
    <dd><?php echo str_repeat('&bull;', 12) ?></dd>
</dl>