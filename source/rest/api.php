<?php
	header("Access-Control-Allow-Origin: *");
	require_once("Rest.inc.php");
	
	class API extends REST {
	
		public $data="";
		public $Q=array();
		
		const DB_SERVER="localhost";
		const DB_USER="root";
		const DB_PASSWORD="";
		const DB_NAME="upii_bjs";
	
		public function __construct(){
			parent::__construct();			
			$this->Q[]="SELECT calum._id as id,calum.nom as nombre,calum.app as ap_p, calum.apm as ap_m,cbeca._id as bid,cbeca.nom as bnom,ccarr._id as cid,ccarr.nom as cnom FROM calum join cbeca on calum.bid=cbeca._id join ccarr on calum.cid=cbeca._id";
			$this->Q[]="SELECT cbeca._id,cbeca.nom,cbeca.amt,count(1)-isnull(calum.bid) as count FROM cbeca left join calum on cbeca._id=calum.bid group by cbeca._id";
			$this->Q[]="SELECT _id as id,nom as nombre,tim as tiempo FROM ccarr";
			$this->Q[]="SELECT _key as llave,val as valor FROM cconf";
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
			$mysqli = new mysqli(self::DB_SERVER,self::DB_USER,self::DB_PASSWORD,self::DB_NAME);
			if(isset($_REQUEST['n']) && $_REQUEST['n']!=""){
				$q=$this->query($_REQUEST['n']);
			}
			else{
				$this->response('',204);
				return;
			}
			$r=$mysqli->query($q);
			if ($mysqli->error) {
				$resp=array("q"=>$q,"err"=>$mysqli->error);
				$this->response($this->json($resp),200);
			}
			$result=array();
			while ($row=mysqli_fetch_assoc($r))
			{
				$result[]=$row;
			}
			$resp=array("data"=>$result);
			$this->response($this->json($resp), 200);
			$mysqli->close();
			$this->response('',204);
		}
		
		private function query($n){
			if($n==="a")
				return $this->Q[0];
			if($n==="b")
				return $this->Q[1];
			if($n==="c")
				return $this->Q[2];
			if($n==="d")
				return $this->Q[3];
		}
		
		private function deleteUser(){
			if($this->get_request_method() != "DELETE"){
				$this->response('',406);
			}
			$id = (int)$this->_request['id'];
			if($id > 0){				
				mysqli_query("DELETE FROM users WHERE user_id = $id");
				$success = array('status' => "Success", "msg" => "Successfully one record deleted.");
				$this->response($this->json($success),200);
			}else
				$this->response('',204);
		}
		
		private function json($data){
			if(is_array($data)){
				return json_encode($data);
			}
		}
	}
		
	$api = new API;
	$api->processApi();
?>