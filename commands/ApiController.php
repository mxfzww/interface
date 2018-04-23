<?php

/**
 * @auto zhaowei
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\web\Controller;
use yii;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ApiController extends Controller {

    //接口引擎
    protected $getInterfaceData;
    //文件配置名
    protected $classData;
    //接口配置文件信息
    protected $methodParm;
    //接口权限信息
    protected $pathParm;
    
    public function __construct($id, $module, $config = array()) {
        parent::__construct($id, $module, $config);
        $this->getClass();
        //判读接口是否开通
        if (!empty($this->getRole())) {
            if (empty($this->getSettionInformation())) {
                exit("没有该接口信息");
            }
        } else {
            exit("接口没开通");
        }
    }

    /**
     * 网盘公共接口
     */
    final public function actionSkydriveinterface() {
        $parm = include $this->pathParm;
        print_r(Yii::$app->curl->setGetParams($this->methodParm)->get($parm["swooleclient"]['host']));

    }

    /**
     * 获取接口权限
     */
    public function getRole() {
        $filepath = $this->interfaceSettiongFile();
        if (file_exists($filepath)) {
            $methodClass = include $filepath;
            if (in_array($this->classData, explode(",", $methodClass['interface']))) {
                return $methodClass;
            }
        }
        return [];
    }

    /**
     * 获取接口配置文件信息
     */
    public function getSettionInformation() {
        $filepath = $this->interfaceInformationPath();
        if (file_exists($filepath)) {
            $methodClass = include $filepath;
            $this->methodParm = $methodClass;
            return $methodClass;
        }
        return [];
    }

    /**
     * 获取配置名
     * @return type
     */
    public function getClass() {
        $classString = get_class($this);
        $this->classData = strtolower(str_replace("Controller", "", array_pop(explode("\\", $classString))));
    }

    /**
     * 获取接口权限文件路径
     */
    public function interfaceSettiongFile() {
        $filename = Yii::$app->basePath . "/api/config/config.php";
        $this->pathParm =  $filename;
        return $filename;
    }

    /**
     * 获取接口配置文件路径
     */
    public function interfaceInformationPath() {
        return sprintf(Yii::$app->basePath . "/api/config/sassPan/%s.php", $this->classData);
    }

}
