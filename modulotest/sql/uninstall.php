<?php
$sql = array();

$sql[] = 'DROP TABLE IF EXISTS '. _DB_PREFIX_ . 'modulotest';


foreach($sql as $query) {
    // Ejecuta el query
    if (!Db::getInstance()->execute($query)) {
        return false;
    }
}