<?php
	require_once("Rest.inc.php");
	
	class API extends REST {
	
		public $data="";
		public $Q=array();
		public $sQ=array();
		public $staQ=array();
		public $mysqli;
		
		const DB_SERVER="localhost";
		const DB_USER="root";
		const DB_PASSWORD="";
		const DB_NAME="upii_bjs";
	
		public function __construct(){
			parent::__construct();			
			$this->mysqli = new mysqli("p:".self::DB_SERVER,self::DB_USER,self::DB_PASSWORD,self::DB_NAME);
			$this->Q[]="SELECT calum._id as id,calum.nom as nombre,calum.app as ap_p, calum.apm as ap_m,cbeca._id as bid,cbeca.nom as bnom,ccarr._id as cid,ccarr.nom as cnom FROM calum join cbeca on calum.bid=cbeca._id join ccarr on calum.cid=ccarr._id";
			$this->Q[]="SELECT cbeca._id as bid,cbeca.nom,cbeca.amt,count(1)-isnull(calum.bid) as count FROM cbeca left join calum on cbeca._id=calum.bid group by cbeca._id";
			$this->Q[]="SELECT _id as cid,nom,tim as tiempo FROM ccarr";
			$this->Q[]="SELECT _key,val FROM cconf WHERE _key in ('MAX_YEAR','MIN_YEAR','SEM_PER_YEAR')";
			$this->sQ[]="select calum.yr,calum.sem,count(1) FROM calum GROUP BY calum.yr,calum.sem";
			//Sem-Carr
			$this->staQ[]="select concat(convert(calum.yr,char),' - ',convert(calum.sem,char)) as k0 ,ccarr.nom as k1,count(1) as v0 from calum join ccarr on calum.cid=ccarr._id where calum.bid>0 group by calum.sem,calum.yr,ccarr.nom;";
			//Sem-Beca
			$this->staQ[]="SELECT distinct yr,sem FROM calum";
			$this->staQ[]="SELECT count(1) as c FROM calum WHERE yr={y} and sem={s} and bid={b} GROUP BY yr,sem,bid";
			//Sem-Carr-Beca
			$hits->staQ[]="select concat(convert(calum.yr,char),' - ',convert(calum.sem,char)) as k0 ,ccarr.nom as k1, cbeca.nom as k2,count(1) as v0 from calum join ccarr on calum.cid=ccarr._id join cbeca on calum.bid=cbeca._id where calum.bid>0 group by calum.sem,calum.yr,ccarr.nom,cbeca.nom";
		}
		
		private function query($n){
			if($n==="a"){
				$q=$this->Q[0];
				$q.=" WHERE 1=1 ";
				if(isset($_REQUEST['bid']) && $_REQUEST['bid']!=""){
					$q=$q." AND calum.bid=".$_REQUEST['bid'];
				}
				if(isset($_REQUEST['s']) && $_REQUEST['s']!="" && isset($_REQUEST['y']) && $_REQUEST['y']!=""){
					$q=$q." AND calum.sem=".$_REQUEST['s'];
					$q=$q." AND calum.yr=".$_REQUEST['y'];
				}
				$q=$q."  ORDER BY cbeca._id,calum.app,calum.apm";
				return $q;
			}
			if($n==="b")
				return $this->Q[1];
			if($n==="c")
				return $this->Q[2];
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
				$n=$_REQUEST['n'];
				if($n==="a"){
					$this->sas_a($n);
					return;
				}
				$q=$this->query($n);
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
				$this->response(json_encode($resp),200);
				return;
			}
			$result=array();
			while ($row=$r->fetch_assoc())
			{
				$result[]=$row;	
			}
			$resp=array("data"=>$result);
			$this->mysqli->close();
			$json_resp=json_encode($resp);
			if($json_resp){
				$this->response($json_resp, 200);
			}
			else{
				var_dump($resp);
				$this->response(json_last_error_msg(), 200);
			}
		}
		
		private function sas_a($n){
			$this->mysqli->query("SET NAMES 'utf8'");
			$r=$this->mysqli->query($this->query("b"));
			$b=array();
			while ($row=$r->fetch_assoc())
			{
				$b[]=$row;	
			}
			$result=array();
			foreach($b as $i){
				$_REQUEST['bid']=$i['bid'];
				$this->mysqli->query("SET NAMES 'utf8'");
				$r=$this->mysqli->query($this->query("a"));
				$h=array();
				while($row=$r->fetch_assoc()){
					$h[]=$row;
				}
				$data=array("nom"=>$i['nom'],"count"=>count($h),"data"=>$h);
				$obj=new stdClass();
				$obj->b=$data;
				$result[]=$obj;
				//$result[]=array($i['nom']=>$data);
			}
			$resp=array("data"=>$result);
			$this->mysqli->close();
			$json_resp=json_encode($resp);
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
				$this->response(json_encode($resp),200);
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
			$json_resp=json_encode($resp);
			if($json_resp){
				$this->response($json_resp, 200);
			}
			else{
				var_dump($resp);
				$this->response(json_last_error_msg(), 200);
			}
		}
		
		private function waw(){
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}
			$data = json_decode(file_get_contents('php://input'), true);
			if(isset($data['id']) && $data['id']!=""){
				$id="'".$data['id']."'";
			}
			else{
				$id="uuid()";
			}
			$q="INSERT calum(_id,nom,app,apm,sem,yr,bid,cid) VALUES ("
				.$id.",'".$data['nom']."','".$data['ap_p']."','".$data['ap_m']."',".$data['sem'].",".$data['yr'].",".$data['bid'].",".$data['cid']
				.")";
			$this->mysqli->query("SET NAMES 'utf8'");
			$r=$this->mysqli->query($q);
			if ($this->mysqli->error) {
				$resp=array("q"=>$q,"err"=>$this->mysqli->error);
				$this->response($this->json($resp),200);
				return;
			}
			else{
				$this->response('', 200);
			}
			$this->mysqli->close();
		}
		
		private function del(){
			if($this->get_request_method() != "DELETE"){
				$this->response('',406);
			}
			if(isset($_REQUEST['n']) && $_REQUEST['n']!=""){
				$n=$_REQUEST['n'];
				if($n==="a"){
					$table="calum";
				}
				elseif($n==="b"){
					$table="cbeca";
				}
				elseif($n==="c"){
					$table="ccarr";
				}
				else{
					$this->response('UNDEF', 200);
					return;
				}
			}
			if(isset($_REQUEST['i']) && $_REQUEST['i']!=""){
				$id=$_REQUEST['i'];
			}
			else{			
				$this->response('UNDEF', 200);
				return;
			}
			$data = json_decode(file_get_contents('php://input'), true);
			$q="DELETE FROM $table WHERE _id='".$id."'";
			$this->mysqli->query("SET NAMES 'utf8'");
			$r=$this->mysqli->query($q);
			if ($this->mysqli->error) {
				$resp=array("q"=>$q,"err"=>$this->mysqli->error);
				$this->response($this->json($resp),200);
				return;
			}
			else{
				$this->response('', 200);
			}
			$this->mysqli->close();
		}
		
		private function sta(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			if(isset($_REQUEST['n']) && $_REQUEST['n']!=""){
				$n=$_REQUEST['n'];
				if($n==="a"){
					$i=0;
				}
				elseif($n==="b"){
					$i=1;
				}
				elseif($n==="c"){
					$i=3;
				}
				else{
					$this->response('UNDEF', 200);
					return;
				}
			}
			$this->mysqli->query("SET NAMES 'utf8'");
			$r=$this->mysqli->query($this->query("b"));
			$h=array();
			while($row=$r->fetch_assoc()){
				$h[]=$row;
			}
			$result=array();			
			$q=$this->staQ[1];
			$this->mysqli->query("SET NAMES 'utf8'");
			$r=$this->mysqli->query($q);
			while($row=$r->fetch_assoc()){
				$obj=new stdClass();
				$obj->dataPoints=array();
				$obj->type="spline";
				$obj->showInLegend=true;
				$obj->name=$row['yr']."-".$row['sem'];
				$obj->legendText=$row['yr']."-".$row['sem'];
				foreach($h as $g){
					$obj1=new stdClass();
					$obj1->label=$g['nom'];
					$q_=$this->staQ[2];
					$this->mysqli->query("SET NAMES 'utf8'");
					$q_=str_replace("{y}",$row['yr'],$q_);
					$q_=str_replace("{s}",$row['sem'],$q_);
					$q_=str_replace("{b}",$g['bid'],$q_);
					$r_=$this->mysqli->query($q_);
					$row_=$r_->fetch_assoc();
					if($row_['c']){
						$obj1->y=intval($row_['c']);
					}
					else{
						$obj1->y=0;
					}					
					$obj->dataPoints[]=$obj1;
				}
				$result[]=$obj;
			}			
			$resp=array("title"=>"","data"=>$result);
			$this->response($this->json($resp),200);
		}
		
		private function fcsv(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			if(isset($_REQUEST['f']) && $_REQUEST['f']!=""){
				$f=$_REQUEST['f'];
			}
			else{
				$this->response('',404);
				return;
			}
			if(($g=fopen($f,"r"))!==false){
				while(($l=fgetcsv($g,100,","))!==false){
					$jcount=count($l);
					$q="INSERT calum(_id,nom,app,apm,cid,bid,sem,yr) SELECT {id},'{nom}','{app}','{apm}',{cid},{bid},2,2014";
					$id="substring(uuid(),1,20)";
					$nparts=explode(" ",$l[0]);
					$app=$nparts[0];
					$apm=$nparts[1];
					$nom=$nparts[2];
					if(count($nparts)>3){
						$nom.=" ".$nparts[3];
					}
					$cid=$l[1];
					$bid=$l[11];
					$q=str_replace("{id}",$id,$q);
					$q=str_replace("{nom}",$nom,$q);
					$q=str_replace("{app}",$app,$q);
					$q=str_replace("{apm}",$apm,$q);
					$q=str_replace("{cid}",$cid,$q);
					$q=str_replace("{bid}",$bid,$q);
					$this->mysqli->query("SET NAMES 'utf8'");
					$this->mysqli->query($q);
				}
			}
			fclose($g);
		}
		
		private function json($data){
			return json_encode($data);
		}
	}
		
	$api = new API;
	$api->processApi();
?>