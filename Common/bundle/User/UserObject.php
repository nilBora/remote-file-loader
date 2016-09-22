<?php

class UserObject extends Core
{
    private $_tableName = 'users';

    public function get($search)
    {
        $sql = "SELECT * FROM ".$this->_tableName;

        return $this->select($sql, $search);
    }
}