<?php
return [
    'tickets/list' =>                       'tickets/list',
    'tickets/request/([0-9]+)' =>           'request/add',
    'action/add' =>                         'cron/add',
    'action/update' =>                       'cron/update',
    'request/done' =>                       'request/done',
    'admin/loginform' =>                    'auth/login',
    'admin/profile' =>                      'auth/profile',
    'admin/logout' =>                       'auth/logout',
    'admin/tickets' =>                      'tickets/list',
    'admin/tickets/delete/([0-9]+)' =>      'tickets/delete',
    'admin/pulloptions/delete/([0-9]+)' =>  'pulloptions/delete',
    'admin/tickets/add' =>                  'tickets/add',
    'admin/pulloptions/add' =>              'pulloptions/add',
    'admin/pulloptions' =>                  'pulloptions/list',
    'admin/options' =>                      'options/list',
    'admin/register' =>                     'auth/register',
    'admin/events' =>                       'events/events',
    'admin/events/add' =>                       'events/eventsAdd',
    'admin' =>                               'index/index',

];
?>