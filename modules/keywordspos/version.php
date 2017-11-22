<?php

/**
 * @Project NUKEVIET 4.x
 * @Author mynukeviet (contact@mynukeviet.com)
 * @Copyright (C) 2017 mynukeviet. All rights reserved
 * @Createdate Sun, 19 Nov 2017 14:43:59 GMT
 */

if (!defined('NV_MAINFILE')) die('Stop!!!');

$module_version = array(
    'name' => 'Keywordspos',
    'modfuncs' => 'main,cronjobs',
    'change_alias' => 'main',
    'submenu' => 'main',
    'is_sysmod' => 0,
    'virtual' => 1,
    'version' => '1.0.00',
    'date' => 'Sun, 19 Nov 2017 14:43:59 GMT',
    'author' => 'mynukeviet (contact@mynukeviet.com)',
    'uploads_dir' => array(
        $module_name
    ),
    'note' => ''
);