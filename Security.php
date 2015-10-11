<?php

class Security {

	public $user_ip = '';
	public $rand_anti_condom = 0;
	public $url_hash = '';
	
	function __construct($cookie = true){

		$this->user_ip = md5($_SERVER['REMOTE_ADDR']."solt_security");
		if ($cookie){
			$this->rand_anti_condom = mt_rand(1000000, 9999999);			
			$this->url_hash = md5("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."solt_security");
			setcookie("sp", $this->url_hash, time()+7200, "/", ".".$_SERVER['SERVER_NAME'],false, false);
			setcookie("si", $this->rand_anti_condom, time()+7200, "/", ".".$_SERVER['SERVER_NAME'],false, false);
		}else{
			if (isset($_COOKIE['si']) && $this->valid_cookie($_COOKIE['si']))
				$this->rand_anti_condom = strip_tags($_COOKIE['si']);
			if (isset($_COOKIE['sp']) && $this->valid_cookie($_COOKIE['sp']))
				$this->url_hash = strip_tags($_COOKIE['sp']);

            if (isset($_COOKIE['sp']))
			    setcookie("sp", "delete", -1, "/", ".".$_SERVER['SERVER_NAME']);

            if (isset($_COOKIE['si']))
			    setcookie("si", "delete", -1, "/", ".".$_SERVER['SERVER_NAME']);
		}
	}

	function valid_cookie($str){
		return (bool) ! preg_match('/[^a-z0-9\/\+=]/', $str);
	}
	function hashEncode($str, $koof){
		$result_array = array();
		$sep = array("n", "m", "j", "l", "t");
		$count = 0;	
		$level = 3*(int)mb_strlen($str, "UTF-8");		
		$ID = $koof+$this->ReturnSessionId();
		$rand_m_array = $this->RandArrayCount(5, ($level-5), ($level/24));
		$sep_now = $sep[rand(0, count($sep)-1)];
		for($k=0;$k<$level;$k++){
			if($k%3!==0)
				$result_array[] = $this->ReturnRand();
			else
				$result_array[] = $str[$count++];
			if (in_array($k,$rand_m_array))
				$result_array[] = $sep_now;
		}
		$arr = explode($sep_now, implode("", $result_array));
		return implode($sep_now, (($ID%2===0)?array_reverse($arr):$arr));
	}
	function hashDecode($str, $koof = 0){
		$arr = array();
		$r = "";
		$ID = $koof+$this->ReturnSessionId();
		preg_match_all('/[0-9a-f]+/', $str, $arr);
		$mixed = implode("", ($ID%2===0)?array_reverse($arr[0]):$arr[0]);
		$s = (int)strlen($mixed);
		for($k=0;$k<$s;++$k)
			if($k%3===0)
				$r.=substr($mixed, $k, 1);				
		return $r;
	}
	
	function ReturnRandHash($koof = 1){
		return $this->hashEncode(md5($this->rand_anti_condom).md5($this->user_ip.md5($this->user_ip.$this->rand_anti_condom)).md5($this->rand_anti_condom.$this->url_hash), $koof);
	}
	
	function ReturnAccessHash($koof = 0){
		return $this->hashEncode(md5($this->user_ip.$this->rand_anti_condom.$this->url_hash), $koof);
	}
	
	function ReturnSessionId(){
		return (int)abs(crc32($this->user_ip.$this->rand_anti_condom.$this->url_hash));
	}
	
	function ReturnRand(){
		$array = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
		return $array[rand(0, count($array)-1)];
	}
	
	function AccosToSimply($arr){
		$result = array();
		foreach($arr AS $key => $item)
			$result[] = $item;
		return $result;
	}
	
	function in_array_my($needle, $arrayinput, $counter){
		foreach($arrayinput AS $key => $item)
			if ($key != $counter)
				if ($item == $needle)
					return true;
		return false;		
	}
	
	function RandArrayCount($start, $stop, $counter){
		$array_m = array();		
		for($i=0;$i<$counter;$i++){
			$rand_pos = rand($start, $stop);
			$array_m[$i] = $rand_pos;
			while($this->in_array_my($rand_pos, $array_m, $i)){
				$rand_pos = rand($start, $stop);
				$array_m[$i] = $rand_pos;
			}			
		}
		array_multisort($array_m);
		return $array_m;
	}	

}
