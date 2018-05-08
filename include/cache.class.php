<?
!defined('IN_WEB') && exit('Access Denied');

abstract class Cache_Abstract {
    abstract function fetch($key);
    abstract function store($key, $data, $ttl=0);
    abstract function delete($key);
}
 
 
class Cache_MemCache extends Cache_Abstract {
    public $connection;
 
    function __construct() {
        $this->connection = new MemCache;
    }
 
    function store($key, $data, $ttl=0) {
        return $this->connection->set($key, $data, 0, $ttl);
    }
 
    function fetch($key) {
        return $this->connection->get($key);
    }
 
    function delete($key) {
        return $this->connection->delete($key);
    }
  
    function addServer($host, $port = 11211, $weight = 10) {
        $this->connection->addServer($host, $port, true, $weight);
    }
 
}
 
class Cache_File extends Cache_Abstract {
 	private $cachepath='';
	
	function setpath($cachepath){
		$this->cachepath =$cachepath;
	}
	
    function store($key, $data, $ttl=0) {
        $h = fopen($this->getFileName($key), 'a+');
        if (!$h)
            throw new Exception('Could not write to cache');
        flock($h, LOCK_EX);
        fseek($h, 0);
        ftruncate($h, 0);
		if($ttl==0) $ttl = 60*60*24*360;
        $data = serialize(array(time() + $ttl, $data));
        if (fwrite($h, $data) === false) {
            throw new Exception('Could not write to cache');
        }
        fclose($h);
    }
 
    function fetch($key) {
        $filename = $this->getFileName($key);
        if (!file_exists($filename))
            return false;
        $h = fopen($filename, 'r');
        if (!$h)
            return false;
        flock($h, LOCK_SH);
		$data = fread($h, filesize($filename));
        fclose($h);
        $data = @ unserialize($data);
        if (!$data) {
            @unlink($filename);
            return false;
        }
        if (time() > $data[0]) {
            @unlink($filename);
            return false;
        }
        return $data[1];
    }
 
    function delete($key) {
        $filename = $this->getFileName($key);
        if (file_exists($filename)) {
            return @unlink($filename);
        }
        else {
            return false;
        }
    }
 	
 
    private function getFileName($key) {
        return $this->cachepath ."data_cache_". md5($key);
    }
 
}
?>