<?php

class DownloadsObject extends Core
{
    private $_tableName = 'downloads';

    public function get($search)
    {
        $sql = "SELECT * FROM ".$this->_tableName;

        return $this->select($sql, $search);
    }
}