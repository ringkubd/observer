<?php
if(!function_exists('getAcollectionKeyAsArray')){
    function getAcollectionKeyAsArray($collection,$key,$value){
        if (is_null($collection) || empty($collection)){
            return null;
        }
        $array = [];
        foreach ($collection as $v){
            $array[$v->{$key}] = $v->{$value};
        }
        return $array;
    }
}
