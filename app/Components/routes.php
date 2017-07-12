<?php
return [
    'tickets/list' => 'tickets/list',
    'tickets/request/([0-9]+)' => 'request/add',
    'action=add' => 'cron/add',
    // 'action=disabled'=>'cron/disabled',
    'request/done' => 'request/done',
    'admin/loginform' => 'admin/login',
    'admin/profile' => 'admin/profile',
    'admin/logout' => 'admin/logout',
    'admin/tickets' => 'tickets/list',
    'admin/tickets/delete/([0-9]+)' => 'tickets/delete',
    'admin/pulloptions/delete/([0-9]+)' => 'pulloptions/delete',
    'admin/tickets/add' => 'tickets/add',
    'admin/pulloptions/add' => 'pulloptions/add',
    'admin/pulloptions' => 'pulloptions/list',
    'admin/options' => 'options/list',
    'admin' => 'admin/index',
    'admin/register' => 'admin/register',

];
?>