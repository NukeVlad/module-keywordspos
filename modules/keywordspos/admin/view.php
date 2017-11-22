<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2015 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 02 Jun 2015 07:53:31 GMT
 */
if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

$projectid = $nv_Request->get_int('projectid', 'post,get', 0);
$rows = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE id=' . $projectid)->fetch();
if (!$rows) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

$z = 1;
$array_labels = $array_data = array();
$result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_keywords WHERE projectid=' . $projectid);
while ($row = $result->fetch()) {
    $data = array();
    $j = 1;
    $current = mktime(23, 59, 59, date('m', NV_CURRENTTIME), date('d', NV_CURRENTTIME), date('Y', NV_CURRENTTIME));
    for ($i = $current; $j <= 15; $i -= 86400) {
        if ($z == 1) {
            $array_labels[] = nv_date('d/m', $i);
        }
        $data[$i] = 0;
        $j++;
    }
    $_result = $db->query('SELECT checktime, pos FROM ' . NV_PREFIXLANG . '_' . $module_data . '_data WHERE projectid=' . $projectid . ' AND keywordid=' . $row['id'] . ' AND checktime IN (' . implode(',', array_keys($data)) . ')');
    while (list ($checktime, $pos) = $_result->fetch(3)) {
        $data[$checktime] = $pos;
    }

    $data = array_reverse($data);
    $array_labels = array_reverse($array_labels);

    $array_data[] = array(
        'label' => $row['title'],
        'backgroundColor' => $array_color[$z],
        'borderColor' => $array_color[$z],
        'data' => array_values($data),
        'fill' => false
    );
    $z++;
}

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $rows);
$xtpl->assign('LABELS', json_encode($array_labels));
$xtpl->assign('DATA', json_encode($array_data));

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = sprintf($lang_module['projects_of'], $rows['title']);

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';