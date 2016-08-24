<?php

require_once dirname(dirname(__FILE__)) . '/config/conf.php';
require_once DIR_F . '/db/Db1.php';
/**
 * @author udin on 24 Aug 2016 16:15
 */
class Mvendor extends Db1 {
    public static function model($className = __CLASS__) {
        $obj = new Mvendor();
        $obj->tblName = 'Mvendor';
        $obj->tblKey = 'id';
        $obj->arrFields = ['id','name','address','notelp','created_by','created_at','update_by','update_at','isactive','image',];
        return $obj;
    }
}
