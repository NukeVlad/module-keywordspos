<?php

/**
 * @Project NUKEVIET 4.x
 * @Author mynukeviet (contact@mynukeviet.com)
 * @Copyright (C) 2017 mynukeviet. All rights reserved
 * @Createdate Sun, 19 Nov 2017 14:43:59 GMT
 */

if (!defined('NV_IS_MOD_KEYWORDSPOS')) die('Stop!!!');

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

// danh sách dự án
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE status=1';
$array_projects = $nv_Cache->db($sql, 'id', $module_name);

$projectid = $nv_Request->get_int('projectid', 'get', reset($array_projects));
$rows = $array_projects[$projectid];

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

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('ROW', $rows);
$xtpl->assign('LABELS', json_encode($array_labels));
$xtpl->assign('DATA', json_encode($array_data));
$xtpl->assign('BASE_URL', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name, true));

if (!empty($array_projects)) {
    foreach ($array_projects as $projects) {
        $projects['selected'] = $projects['id'] == $projectid ? 'selected="selected"' : '';
        $xtpl->assign('PROJECTS', $projects);
        $xtpl->parse('main.projects');
    }
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $rows['title'];
$array_mod_title[] = array(
    'title' => $page_title,
    'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op
);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';