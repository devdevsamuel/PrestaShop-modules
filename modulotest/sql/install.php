<?php
$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS '. _DB_PREFIX_ . 'modulotest (
    id_prueba INT(11) NOT NULL AUTO_INCREMENT,
    texto VARCHAR(255),
    PRIMARY KEY (id_prueba)
) ENGINE= ' . _MYSQL_ENGINE_ . ' InnoDB DEFAULT CHARSET=utf8;';

foreach($sql as $query) {
    // Ejecuta el query
    if (!Db::getInstance()->execute($query)) {
        return false;
    }
}