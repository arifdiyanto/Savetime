<?php

require_once dirname(dirname(__FILE__)) . "/config/conf.php";
require_once DIR_F . "/db/Db1.php";

/**
 * @author arifdiyantotmg@gmail.com
 */
class Syuser extends Db1 {

    public static function model($className = __CLASS__) {
        $obj = new Syuser();
        $obj->tblName = "syuser";
        $obj->arrFields = [
            'userid',
            'username',
            'pass',
            'email',
            'phone',
            'url_img',
            'gender',
            'address',
            'token',
            'attr',
            'isactive',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at'
        ];
        return $obj;
    }

}
