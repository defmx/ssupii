<?php
	require_once("Rest.inc.php");
	
	class API extends REST {
	
		public $data="";
		public $Q=array();
		public $sQ=array();
		public $mysqli;
		
		const DB_SERVER="localhost";
		const DB_USER="root";
		const DB_PASSWORD="";
		const DB_NAME="upii_bjs";
	
		public function __construct(){
			parent::__construct();			
			$this->mysqli = new mysqli("p:".self::DB_SERVER,self::DB_USER,self::DB_PASSWORD,self::DB_NAME);
			$this->Q[]="SELECT calum._id as id,calum.nom as nombre,calum.app as ap_p, calum.apm as ap_m,cbeca._id as bid,cbeca.nom as bnom,ccarr._id as cid,ccarr.nom as cnom FROM calum join cbeca on calum.bid=cbeca._id join ccarr on calum.cid=ccarr._id";
			$this->Q[]="SELECT cbeca._id,cbeca.nom,cbeca.amt,count(1)-isnull(calum.bid) as count FROM cbeca left join calum on cbeca._id=calum.bid group by cbeca._id";
			$this->Q[]="SELECT _id as id,nom as nombre,tim as tiempo FROM ccarr1";
			$this->Q[]="SELECT _key,val FROM cconf WHERE _key in ('MAX_YEAR','MIN_YEAR','SEM_PER_YEAR')";
			$this->sQ[]="select calum.yr,calum.sem,count(1) FROM calum GROUP BY calum.yr,calum.sem";
		}
		
		public function processApi(){
			$func = strtolower(trim(str_replace("/","",$_REQUEST['r'])));
			if((int)method_exists($this,$func) > 0)
				$this->$func();
			else
				$this->response('',404);
		}
		
		private function sas(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			if(isset($_REQUEST['n']) && $_REQUEST['n']!=""){
				$q=$this->query($_REQUEST['n']);
				if(!$q) return;
			}
			else{
				$this->response('',204);
				return;
			}
			$this->mysqli->query("SET NAMES 'utf8'");
			$r=$this->mysqli->query($q);
			if ($this->mysqli->error) {
				$resp=array("q"=>$q,"err"=>$this->mysqli->error);
				$this->response($this->json($resp),200);
				return;
			}
			$result=array();
			while ($row=$r->fetch_assoc())
			{
				$result[]=$row;
			}
			$resp=array("data"=>$result);
			$this->mysqli->close();
			$json_resp=$this->json($resp);
			if($json_resp){
				$this->response($json_resp, 200);
			}
			else{
				var_dump($resp);
				$this->response(json_last_error_msg(), 200);
			}
		}
		
		private function sab(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$q=$this->Q[3];
			$this->mysqli->query("SET NAMES 'utf8'");
			$r=$this->mysqli->query($q);
			if ($this->mysqli->error) {
				$resp=array("q"=>$q,"err"=>$this->mysqli->error);
				$this->response($this->json($resp),200);
				return;
			}
			$result=array();
			while ($row=$r->fetch_assoc())
			{
				if($row['_key']==="MAX_YEAR"){
					$MAX_YEAR=$row['val'];		
				}
				elseif($row['_key']==="MIN_YEAR"){
					$MIN_YEAR=$row['val'];		
				}
				elseif($row['_key']==="SEM_PER_YEAR"){
					$SEM_PER_YEAR=$row['val'];
				}
			}
			for($i=$MAX_YEAR;$i>=$MIN_YEAR;$i--){
				for($j=1;$j<=$SEM_PER_YEAR;$j++){
					$obj=new stdClass();
					$obj->year=$i;
					$obj->sem=$j;
					$result[]=$obj;
				}
			}
			$resp=array("data"=>$result);
			$this->mysqli->close();
			$json_resp=$this->json($resp);
			if($json_resp){
				$this->response($json_resp, 200);
			}
			else{
				var_dump($resp);
				$this->response(json_last_error_msg(), 200);
			}
		}
		
		private function query($n){
			if($n==="a"){
				$q=$this->Q[0];
				if(isset($_REQUEST['bid']) && $_REQUEST['bid']!=""){
					$q=$q." WHERE calum.bid=".$_REQUEST['bid'];
				}
				elseif(isset($_REQUEST['s']) && $_REQUEST['s']!="" && isset($_REQUEST['y']) && $_REQUEST['y']!=""){
					$q=$q." WHERE calum.sem=".$_REQUEST['s'];
					$q=$q." AND calum.yr=".$_REQUEST['y'];
				}
				return $q;
			}
			if($n==="b")
				return $this->Q[1];
			if($n==="c")
				return $this->Q[2];
		}
		
		private function json($data){
			return json_encode($data);
		}
	}
		
	$api = new API;
	$api->processApi();
?>