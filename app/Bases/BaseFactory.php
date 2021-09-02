<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/15 0015
 * Time: 14:04
 */

namespace App\Bases;

class BaseFactory
{
    public static $instance;
    public static function getInstance(){
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param string $className
     * @param string $params
     * @return mixed
     * Date            2021/1/15 05:48:39
     * Author          Rex
     */
    private function generateClass($className = "",$params = ""){
        return (isset($params)&&!empty($params))? new $className($params) : new $className();
    }

    /**
     * @param string $repoName
     * @param string $params
     * @return mixed
     * Date            2021/1/15 05:46:57
     * Author          Rex
     */
    public function generateRepository($repoName = "",$params = ""){
        return $this->generateClass('\App\\Repositories\\'.ucfirst($repoName).'Repository',$params);
    }

    /**
     * @param string $modelName
     * @return mixed
     * Date            2021/1/15 05:46:53
     * Author          Rex
     */
    public function generateModel($modelName = ""){
        return $this->generateClass('\App\\Models\\'.ucfirst($modelName));
    }

    /**
     * @param string $serviceName
     * @param string $params
     * @return mixed
     * Date            2021/1/15 05:46:49
     * Author          Rex
     */
    public function generateService($serviceName = "", $params = ""){
        return $this->generateClass('\App\\Services\\'.ucfirst($serviceName).'Service',$params);
    }

}