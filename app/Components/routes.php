<?php
return [
    'tickets/list' =>                       'tickets/list',
    'tickets/request/([0-9]+)' =>           'request/add',
    'tickets/event' => 'tickets/event',


    'admin/404' => 'settings/redirect404',
    'action/add/([0-9]+)' => 'cron/add',
    'action/cron' => 'cron/cron',
    'action/update' => 'cron/update',

    'request/done' =>                       'request/done',
    'admin/loginform' =>                    'auth/login',
    'admin/logout' =>                       'auth/logout',
    'admin/register' =>                     'auth/register',
    'admin' => 'index/index',

    'admin/settings' => 'settings/list',
    'admin/profile' =>                      'settings/profile',

    'admin/events' => 'events/list',
    'admin/events/tickets/([0-9]+)' => 'tickets/list',
    'admin/events/requestlist/([0-9]+)' => 'request/list',
    'admin/events/pulloptions/([0-9]+)' => 'pulloptions/list',
    'admin/events/options/([0-9]+)' => 'options/list',

    'admin/pulloptions/delete/([0-9]+)' => 'pulloptions/delete',
    'admin/tickets/delete/([0-9]+)' => 'tickets/delete',
    'admin/tickets/add/([0-9]+)' => 'tickets/add',
    'admin/pulloptions/add/([0-9]+)' => 'pulloptions/add',
    'admin/events/add' => 'events/eventsAdd',




];
?>