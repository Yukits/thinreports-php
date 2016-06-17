<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuki
 * Date: 2016/06/17
 * Time: 18:43
 */

namespace Thinreports\Service;


class TypeFormat
{
    private static $instance;
    private static $version = "0.9.0";

    private function __construct()
    {

    }

    public static function newInstance($version){
        self::$version = $version;
       if(self::$instance == null){
           return new self();
       }
        return self::$instance;
    }

    public function getTypeFormat(){
        switch ($this->version){
            case "0.9.0":
                return json_decode(self::TYPE_VER_09,true);
                break;
            case "0.8.0":
                break;
            default:
                break;
        }
    }
    
    const TYPE_VER_09 = '{
        "list": "list",
        "text": "text-block",
        "page_number": "page_number",
        "image": "image-block",
        "rect" : "rect"
        "ellipse": "ellipse",
        "line": "line"
    }';

}