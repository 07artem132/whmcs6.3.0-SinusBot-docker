<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace sinusdocker\helpers;

use Illuminate\Database\Capsule\Manager as Capsule;
use Exception;

class database {

  
    public static function Product_custom_fields_exists($pid, $fieldname) {
        try {
            $row = (array) Capsule::table('tblcustomfields')->selectRaw('SQL_NO_CACHE fieldname')->whereraw('relid = \''. $pid .'\'and fieldname = \''. $fieldname.'\'')->first();
        } catch (\Exception $e) {
            logModuleCall('TeamSpeak_3', __CLASS__ . '->' . __FUNCTION__, NULL, NULL, $e->getMessage(), null);
            throw new Exception('sql error');
        }

        if (!empty($row))
            return TRUE;

        return FALSE;
    }

    public static function Product_custom_fields_text_add($pid, $fieldname) {
        try {
            $row = (array) Capsule::table('tblcustomfields')->insert(
                            [
                                'type' => 'product',
                                'relid' => $pid,
                                'fieldname' => $fieldname,
                                'fieldtype' => 'text'
                            ]
            );
        } catch (\Exception $e) {
            logModuleCall('TeamSpeak_3', __CLASS__ . '->' . __FUNCTION__, NULL, NULL, $e->getMessage(), null);
            throw new Exception('sql error');
        }

        return TRUE;
    }

}
