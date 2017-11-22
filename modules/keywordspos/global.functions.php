<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 12/31/2009 0:51
 */

if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

$array_color = array('#AADEAE','#9CDDEF','#EADABE','#ECEEDB','#C9DABD','#ADCCDE','#BDCC99','#AC9DAF','#DDAF99','#BCAFBA','#CFA9FB','#FDBF99','#CEEDCB','#BA9DF9','#CAEAA9','#E9BEB9','#DCCEE9','#9BFDCC','#EFA9CA','#CFAEFA','#BBED99','#C999CF','#E9FDAB','#AFDFA9','#CC9EAC','#BDFADA','#FE9AAA','#AEADD9','#DABEFF','#A9ECB9','#DAAAF9','#DEAAEB','#ECDED9','#E9ACBE','#DCD9E9','#BEA99D','#EABCAA','#CEEBAF','#ECFDBA','#CDABCC','#FCCEE9','#AED99D','#ACDCA9','#F9CBAC','#9EACBD','#EEB9A9','#DECEDA','#BEFAFF','#BFDCED','#DDCB9D');

function nv_delete_project($id)
{
    global $db, $module_data;

    $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '  WHERE id = ' . $id);
}

function nv_check($keywordid)
{
    global $db, $module_data;

    require_once NV_ROOTDIR . '/modules/keywordspos/RankChecker.class.php';

    list ($projectid, $keyword, $url) = $db->query('SELECT projectid, title, url FROM ' . NV_PREFIXLANG . '_' . $module_data . '_keywords WHERE id=' . $keywordid)->fetch(3);

    $newGoogleRankChecker = new GoogleRankChecker();
    $useproxies = false;
    $arrayproxies = [];
    $rank = $newGoogleRankChecker->find($keyword, $url, $useproxies, $arrayproxies);

    if (!empty($rank)) {
        if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', date('d/m/Y', NV_CURRENTTIME), $m)) {
            $checktime = mktime(23, 59, 59, $m[2], $m[1], $m[3]);
        } else {
            return false;
        }

        try {
            $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_data(projectid, keywordid, checktime, pos) VALUES(:projectid, :keywordid, ' . $checktime . ', :pos)');
            $stmt->bindParam(':projectid', $projectid, PDO::PARAM_INT);
            $stmt->bindParam(':keywordid', $keywordid, PDO::PARAM_INT);
            $stmt->bindParam(':pos', $rank, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_data SET pos = :pos WHERE projectid = :projectid AND keywordid = :keywordid AND checktime = ' . $checktime);
            $stmt->bindParam(':projectid', $projectid, PDO::PARAM_INT);
            $stmt->bindParam(':keywordid', $keywordid, PDO::PARAM_INT);
            $stmt->bindParam(':pos', $rank, PDO::PARAM_INT);
            $stmt->execute();
        }
    }
}