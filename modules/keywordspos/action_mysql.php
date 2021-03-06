<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2016 VINADES.,JSC. All rights reserved
 * @Createdate Sun, 14 Feb 2016 15:13:13 GMT
 */
if (!defined('NV_IS_FILE_MODULES')) die('Stop!!!');

$sql_drop_module = array();
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data;
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_keywords";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_data";

$sql_create_module = $sql_drop_module;
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "(
  id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL COMMENT 'Tên gọi',
  note tinytext NOT NULL COMMENT 'Ghi chú',
  status tinyint(1) NOT NULL COMMENT 'Trạng thái',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_keywords(
  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  projectid smallint(4) unsigned NOT NULL,
  title varchar(255) NOT NULL COMMENT 'Từ khóa',
  url varchar(255) NOT NULL COMMENT 'Liên kết',
  note tinytext NOT NULL COMMENT 'Ghi chú',
  weight smallint(4) unsigned NOT NULL DEFAULT '0',
  status tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Trạng thái',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_data(
  projectid smallint(4) unsigned NOT NULL,
  keywordid mediumint(8) unsigned NOT NULL,
  checktime int(11) unsigned NOT NULL,
  pos smallint(4) unsigned NOT NULL,
  UNIQUE KEY projectid (projectid, keywordid, checktime)
) ENGINE=MyISAM";

$data = array();
foreach ($data as $config_name => $config_value) {
    $sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config (config_name, config_value) VALUES(" . $db->quote($config_name) . ", " . $db->quote($config_value) . ")";
}