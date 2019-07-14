<?php


namespace App\Helpers;

use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Model;
use DB;

class RedisControlModel extends Model
{
    private $rediskeys;
    private $dataQuery;
    private $destroyCache;
    private $querySelect;
    private $redisQuery;


    /**
     * RedisControlModel constructor.
     * @param $keys
     * @param string $query
     * @param bool $destroy
     * @param string $select
     */

    public function __construct($query = "",$destroy = false,$select = "*")
    {
        parent::__construct();
        $this->rediskeys = env("APP_NAME")."_".$this->table;
        $this->dataQuery = $query;
        $this->destroyCache = $destroy;
        $this->querySelect = $select;
    }



    /**
     * @param $query
     * @return false|string
     */

    public function compailedQuery($query){
        $queryKeys = $this->rediskeys."_query";
        $q = $this->redisQuery($query);
        return json_encode(DB::select(DB::raw("SELECT * FROM $this->table $this->redisQuery")));

    }

    /**
     * @param $query
     * @return $this
     */

    private function redisQuery($query){
        $queryKeys = $this->rediskeys."_query";

        if (Redis::exists($queryKeys) && Redis::get($queryKeys) == $query){

            $this->redisQuery = Redis::get($queryKeys);
            return $this;

        }else{
            Redis::set($queryKeys,$query);
            $this->redisQuery = Redis::get($queryKeys);
            return $this;
        }
    }

    /**
     * Get parent branches
     */

    public function getFromDB(){
        $rediskeys = $this->rediskeys;

        if (!Redis::exists($rediskeys) || $this->destroyCache) {
            $data = $this->compailedQuery($this->dataQuery);
            $storeInCache = Redis::set("$rediskeys",$data);
            return Redis::get($rediskeys);

        }else{
            return Redis::get($rediskeys);
        }
    }

    /**
     * UPDATE data onchange
     * @return boolean;
     */
    public function updateOnChange(){
        $rediskeys = $this->rediskeys;
        return Redis::del($rediskeys);
    }

    /**
     * GET settings object
     * Settings cache decode;
     * @return object;
     */

    public function getFromRedis(){
        $data = $this->getFromDB();
        return json_decode($data);
    }



}
