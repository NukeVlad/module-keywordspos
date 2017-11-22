<?php

/**
 * @Project NUKEVIET 4.x
 * @Author mynukeviet (contact@mynukeviet.com)
 * @Copyright (C) 2017 mynukeviet. All rights reserved
 * @Createdate Sun, 19 Nov 2017 14:43:59 GMT
 */

if (!defined('NV_IS_MOD_KEYWORDSPOS')) die('Stop!!!');

if ($sys_info['allowed_set_time_limit']) {
    set_time_limit(0);
}

$result = $db->query('SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_keywords WHERE status=1');
while (list ($id) = $result->fetch(3)) {
    nv_check($id);
}