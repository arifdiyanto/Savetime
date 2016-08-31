<?php

require_once dirname(dirname(__FILE__)) . '/config/conf.php';
require_once DIR_F . '/db/Db1.php';
/**
 * @author Arif Diyanto on 31 Aug 2016 07:28
 */
class Mproduct extends Db1 {
    public static function model($className = __CLASS__) {
        $obj = new Mproduct();
        $obj->tblName = 'Mproduct';
        $obj->tblKey = 'pro_id';
        $obj->arrFields = ['pro_id','pro_kode','pro_name','pro_kw','pro_unit','pro_price','created_by','created_date','prod_image','pro_isactive','update_by','update_at',];
        return $obj;
    }
}
