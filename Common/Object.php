<?php

class Object
{
    const FETCH_ROW = "FETCH_ROW";
    const FETCH_ALL = "FETCH_ALL";

    public static $db;

    public static function factory($db)
    {
        static::$db = $db;
    }

    public function get($sql)
    {
        //print_r($this->db);
    }

    public function select($sql, $search)
    {
        $where = $this->_getPrepareWhereBySearch($search);

        $query = static::$db->query($sql.$where);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    private function _getPrepareWhereBySearch($search)
    {
        $where = " WHERE ";
        foreach ($search as $name => $value) {
            $where.=$name.' = '.'"'.$value.'"';
        }

        return $where;
    }

    public function search($sql, $search, $type = self::FETCH_ALL)
    {

    }

    private function _getPDOType($type)
    {
    }
}