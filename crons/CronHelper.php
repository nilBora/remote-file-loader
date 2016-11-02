<?php

class CronHelper
{
    private $_file;        
    
    public function __construct($file)
    {
        $this->_file = $file;    
    }
    
    private function _getBaseLockPath()
    {
        return dirname($this->_file).'/locks/';
    }
    
    private function _getLockFileName()
    {
        return 'lock_'.basename($this->_file, '.php');
    }
    
    public function isRuning()
    {
        $path = $this->_getBaseLockPath();
        
        $filePath = $path.$this->_getLockFileName().'.chk';
    
        $lastPid = false;
        if (file_exists($filePath)) {
            $lastPid = (int) file_get_contents($filePath);
        }
    
        $res = false;
        if ($lastPid) {
            $cmd = 'ps -p '.$lastPid.' | grep '.$lastPid.' | '.
                   'awk "{ print \$1 }"';
            $res = (int) `$cmd`;
        }
    
        if ($res && $res === $lastPid) {
           return true;
        }
    
        $pid = getmypid();
        $res = file_put_contents($filePath, $pid);
        if ($res === false) {
            throw new Exception("Access error: ".$filePath);
        }
    
        return false;
    }
}
