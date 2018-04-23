<?php

namespace app\api\controllers;

use yii\web\Controller;
use app\commands\ApiController;

/**
 * Default controller for the `api` module
 */
class BaiduController extends ApiController {

    /**
     * 过滤数据
     */
    public function _filterData($data) {
        preg_match_all("/<a .*? class='fname' target='_blank' .*?>.*?<\/a>/", $data, $aarray);
        $reg2 = "/href=([^\s>]+)/";
        $arr = array();
        for ($i = 0; $i < count($aarray[0]); $i++) {

            preg_match_all($reg2, $aarray[0][$i], $hrefarray);

            $arr[$i]['url'] = $hrefarray[1][0];
            $reg3 = "/>(.*)<\/a>/";
            preg_match_all($reg3, $aarray[0][$i], $acontent);

            $arr[$i]['name'] = $acontent[1][0];
        }
        return $arr;
    }

}
