<?php
	require_once("Rest.inc.php");
	
	class API extends REST {
	
		public $data="";
		public $Q=array();
		public $sQ=array();
		public $staQ=array();
		public $stQ=array();
		public $mysqli;
		
		const DB_SERVER="localhost";
		const DB_USER="root";
		const DB_PASSWORD="";
		const DB_NAME="upii_bjs";
	
		public function __construct(){
			parent::__construct();			
			$this->mysqli = new mysqli("p:".self::DB_SERVER,self::DB_USER,self::DB_PASSWORD,self::DB_NAME);
			$this->Q[]="SELECT calum._id as id,calum.nom as nombre,calum.app as ap_p, calum.apm as ap_m,cbeca._id as bid,cbeca.nom as bnom,ccarr._id as cid,ccarr.nom as cnom,0 as showEdit FROM calum join cbeca on calum.bid=cbeca._id join ccarr on calum.cid=ccarr._id";
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
			$this->staQ[]="select concat(convert(calum.yr,char),' - ',convert(calum.sem,char)) as k0 ,ccarr.nom as k1, cbeca.nom as k2,count(1) as v0 from calum join ccarr on calum.cid=ccarr._id join cbeca on calum.bid=cbeca._id where calum.bid>0 group by calum.sem,calum.yr,ccarr.nom,cbeca.nom";
			//Alumno-Beca
			$this->stQ[]="SELECT concat(convert(rz00.yr,char),' - ',convert(rz00.sem,char)) as ys,bid FROM rz00 WHERE aid='{aid}' ORDER BY yr,sem";
			//Alumno-Beca2
			$this->stQ[]="SELECT rz00.aid,calum.nom,calum.app,calum.apm,count(1) FROM rz00 join calum on rz00.aid=calum._id group by rz00.aid,rz00.bid having rz00.bid>0";
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
			$sssn=null;
			if(isset($_REQUEST['sssn']) && $_REQUEST['sssn']!=""){
				$sssn=$_REQUEST['sssn'];
				$q="SELECT duration,created FROM ksess WHERE _id='$sssn'";
				$r=$this->mysqli->query($q);
				$row=$r->fetch_assoc();
				if($row){
					$interval=new DateInterval('PT'.$row['duration'].'S');
					$created=strtotime($row['created']);
					$expires=strtotime(date("Y-m-d h:i:s",$created)." +1000 seconds");
					$now=strtotime(date("Y-m-d h:i:s"));
					if($now>$expires){
						$sssn=null;
					}
				}
				elseif($func!=="zzz"){
					$sssn=null;
				}
			}
			if(!$sssn && $func!=="zzz"){
				$this->response(json_encode("Session expired"),401);
				return;
			}
			if((int)method_exists($this,$func) > 0){
				if($func=="seek"){
					if($this->get_request_method() != "GET"){
						$this->response('',406);
					}
					if(isset($_REQUEST['q']) && $_REQUEST['q']!=""){
						$w=$_REQUEST['q'];
						$this->$func($w);
					}
				}
				elseif($func=="stq"){
					if($this->get_request_method() != "GET"){
						$this->response('',406);
					}
					if(isset($_REQUEST['n']) && $_REQUEST['n']!=""){
						$w=$_REQUEST['n'];
						$this->$func($w);
					}
				}
				elseif($func=="zzz"){
					if($this->get_request_method() != "POST"){
						$this->response('',406);
					}
					$data = json_decode(file_get_contents('php://input'), true);
					$this->$func($data);
				}
				elseif($func=="waw"){					
					if($this->get_request_method() != "POST"){
						$this->response('',406);
					}
					$data = json_decode(file_get_contents('php://input'), true);
					if(isset($_REQUEST['n']) && $_REQUEST['n']!=""){
						$w=$_REQUEST['n'];
					}
					$this->$func($data,$w);
				}
				else
					$this->$func();
			}
			else
				$this->response('',404);
		}
		
		private function sas(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			if(isset($_REQUEST['n']) && $_REQUEST['n']!=""){
				$f=null;
				if(isset($_REQUEST['f']) && $_REQUEST['f']!=""){
					$f=$_REQUEST['f'];
				}
				$n=$_REQUEST['n'];
				if($n==="a"){
					$this->sas_a($n,$f);
					return;
				}
				elseif($n=="r"){
					$q="SELECT _id,nom,flags FROM krole WHERE _id>0";
				}
				elseif($n=="u"){
					if(isset($_REQUEST['ri']) && $_REQUEST['ri']!=""){
						$rid=$_REQUEST['ri'];
						$q="SELECT _id,email,nom,app,apm FROM kusrs WHERE rid=$rid AND rid>0";
					}
				}
				else{
					$q=$this->query($n);
				}
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
		
		private function sas_a($n,$f){
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
				$q="SELECT calum._id as id,calum.nom as nombre,calum.app as ap_p, calum.apm as ap_m,cbeca._id as bid,cbeca.nom as bnom,ccarr._id as cid,ccarr.nom as cnom,0 as showEdit FROM calum join cbeca on calum.bid=cbeca._id join ccarr on calum.cid=ccarr._id";
				$q.=" WHERE 1=1 ";
				if(isset($_REQUEST['bid']) && $_REQUEST['bid']!=""){
					$q=$q." AND calum.bid=".$_REQUEST['bid'];
				}
				if(isset($_REQUEST['s']) && $_REQUEST['s']!="" && isset($_REQUEST['y']) && $_REQUEST['y']!=""){
					$q=$q." AND calum.sem=".$_REQUEST['s'];
					$q=$q." AND calum.yr=".$_REQUEST['y'];
				}
				if($f){
					$q=$q." AND (calum._id LIKE '%$f%' OR calum.nom LIKE '%$f%' OR calum.app LIKE '%$f%' OR calum.apm LIKE '%$f%')";
				}
				$q=$q." ORDER BY cbeca._id,calum.app,calum.apm";
				$r=$this->mysqli->query($q);
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
				for($j=$SEM_PER_YEAR;$j>0;$j--){
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
		
		private function waw($data,$w){
			if($w&&$w=="r"){
				$this->waw_r($data);
				return;
			}
			if(isset($data['id']) && $data['id']!=""){
				$id="'".$data['id']."'";
			}
			else{
				$id="uuid()";
			}
			$id0=null;
			if(isset($data['id0']) && $data['id0']!=""){
				$id0=$data['id0'];
			}
			if($id0){
				if($id0!==$id){
					$q="UPDATE calum SET _id='$id' WHERE _id='$id0'";
					$this->mysqli->query($q);
				}
				$q="UPDATE calum SET nom='".$data['nombre']."',app='".$data['ap_p']."',apm='".$data['ap_m']."',bid=".$data['bid'].",cid=".$data['cid'].",sem=".$data['sem'].",yr=".$data['yr']." WHERE _id='$id'";
				$r=$this->mysqli->query($q);
				if($this->mysqli->error){
					$this->response(json_encode($this->mysqli->error),400);
				}
				else{
					$this->response("",200);
				}
			}
			else{
				$q="INSERT calum(_id,nom,app,apm,sem,yr,bid,cid) VALUES ($id,'".$data['nom']."','".$data['ap_p']."','".$data['ap_m']."',".$data['sem'].",".$data['yr'].",".$data['bid'].",".$data['cid'].")";
				$this->mysqli->query("SET NAMES 'utf8'");
				$r=$this->mysqli->query($q);
			}
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
		
		private function waw_r($data){
			if(isset($data['_id'])&&$data['_id']){
				$q="UPDATE krole SET nom='".$data['nom']."',flags=".$data['flags']." WHERE _id=".$data['_id'];				
			}
			else{
				$q="INSERT krole(nom,flags) SELECT '".$data['nom']."',".$data['flags'];
			}
			$this->mysqli->query($q);
			if($this->mysqli->error){
				$this->response(json_encode($this->mysqli->error),404);
			}
			else{
				$this->response("",200);
			}
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
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}
			if(!(isset($_REQUEST['s']) && $_REQUEST['s']!="" && isset($_REQUEST['y']) && $_REQUEST['y']!="")){
				$this->response('',400);
			}
			$f=$_FILES["fileUpload"]["tmp_name"];
			if(!strstr($_FILES["fileUpload"]["name"],".csv")){
				$this->response(json_encode("File has no 'csv' extension"),400);
				return;
			}
			$lines_processed=0;
			if(($g=fopen($f,"r"))!==false){
				while(($l=fgetcsv($g,100,","))!==false){
					$jcount=count($l);
					if($jcount<=1){
						$this->response(json_encode("File does not contain 'csv' data"),400);
						return;						
					}
					$q="set @id={id};call sp_insAlum(@id,'{nom}','{app}','{apm}',{cid},{bid},2,2014,{si},{yri});select @id as id";
					$qr=array();
					$q__="INSERT rz00(aid,bid,sem,yr) SELECT {aid},{bid},{sem},{yr}";
					$id=$l[0];
					if(!$id){
						$id="null";
					}
					else{
						$id="'".$id."'";
					}
					$nparts=explode(" ",$l[1]);
					$app=$nparts[0];
					$apm=$nparts[1];
					$nom=$nparts[2];
					if(count($nparts)>3){
						$nom.=" ".$nparts[3];
					}
					$cid=$l[2];
					$s=$_REQUEST['s'];
					$y=$_REQUEST['y'];
					$si=$_REQUEST['s'];
					$yi=$_REQUEST['y'];
					for($j=3;$j<=count($l)-1;$j++){
						$bid=$l[$j];
						if($bid==0)
							$bid=-1;			
						$q_=$q__;
						if($id!=="null"){
							$q_=str_replace("{aid}",$id,$q_);
						}
						$q_=str_replace("{bid}",$bid,$q_);
						$q_=str_replace("{sem}",$s,$q_);
						$q_=str_replace("{yr}",$y,$q_);
						$qr[]=$q_;
						if($s==2){
							$y++;
							$s=1;
						}
						else{
							$s++;
						}
					}
					$q=str_replace("{id}",$id,$q);
					$q=str_replace("{nom}",$nom,$q);
					$q=str_replace("{app}",$app,$q);
					$q=str_replace("{apm}",$apm,$q);
					$q=str_replace("{cid}",$cid,$q);
					$q=str_replace("{bid}",$bid,$q);
					$q=str_replace("{si}",$si,$q);
					$q=str_replace("{yri}",$yi,$q);
					$this->mysqli->query("SET NAMES 'utf8'");
					foreach(explode(";",$q) as $qp){
						//var_dump($qp);
						$r=$this->mysqli->query($qp);
					}
					if($this->mysqli->error){
						//var_dump($q);
						var_dump($this->mysqli->error);
						return;
					}
					else{
						$lines_processed++;
						$res=$r->fetch_assoc();
						$id=$res['id'];
						foreach($qr as $r){
							$q_=str_replace("{aid}","'".$id."'",$r);
							//var_dump($q_);
							$this->mysqli->query("SET NAMES 'utf8'");
							$this->mysqli->query($q_);
						}
					}
				}
			}
			fclose($g);
			$response=new stdClass();
			$response->message="OK: $lines_processed rows";
			$response->input=$_FILES["fileUpload"]["name"];
			$this->response($this->json($response),200);
		}
		
		private function seek($s){
			$q="SELECT calum.* FROM calum WHERE _id LIKE '%{q}%' OR nom LIKE '%{q}%' OR app LIKE '%{q}%' OR apm LIKE '%{q}%' ORDER BY calum.app,calum.apm,calum.nom";
			$s=str_replace("'",null,$s);
			$q=str_replace("{q}",$s,$q);
			$r=$this->mysqli->query("SET NAMES 'utf8'");
			$r=$this->mysqli->query($q);
			if($this->mysqli->error){
				var_dump($q);
				var_dump($this->mysqli->error);
				return;
			}
			else{
				$res=array();
				while($row=$r->fetch_assoc()){
					$res[]=$row;
				}
				$resp=array("data"=>$res);
				$this->response($this->json($resp),200);
			}
		}
		
		private function stq($s){
			$q=str_replace("{aid}",$s,$this->stQ[0]);
			$this->mysqli->query("SET NAMES 'utf8'");
			$r=$this->mysqli->query($q);
			$dataPoints=array();
			while($row=$r->fetch_assoc()){
				$sub=new stdClass();
				$sub->label=$row['ys'];
				$sub->y=intval($row['bid']);
				$dataPoints[]=$sub;
			}
			$resp=new stdClass();
			$resp->title="";
			$resp->animationEnabled=true;
			$axisy=new stdClass();
			$axisy->interval=1;
			$axisy->minimum=-1;
			$axisy->thickness=1;
			$axisy->gridThickness=1;
			$resp->axisY=$axisy;
			$data=array();
			$datasub=new stdClass();
			$datasub->dataPoints=$dataPoints;
			$datasub->type="spline";
			$data[]=$datasub;
			$resp->data=$data;
			$resp->data=$data;
			$this->response($this->json($resp),200);
		}
		
		private function zzz($u){
			$q="SELECT krole._id as role,krole.flags FROM kusrs JOIN krole ON kusrs.rid=krole._id WHERE kusrs._id='{id}' AND kusrs.gzzms='{z}'";
			$id=str_replace("'",null,$u['id']);
			$z=str_replace("'",null,$u['z']);
			$q=str_replace("{id}",$id,$q);
			$q=str_replace("{z}",$z,$q);
			$r=$this->mysqli->query($q);
			if(!$this->mysqli->error){
				$row=$r->fetch_assoc();
				if($row){
					$q="set @id='';call sp_crSession(@id,'admc','HOLA','127.0.0.1');select @id";
					foreach(explode(";",$q) as $q_){
						$r=$this->mysqli->query($q_);
					}
					$row=$r->fetch_assoc();
					if(!$row){
						$this->response("",404);
					}
					$sessid=$row['@id'];
					$q="select ksess._id as sssnid,kusrs._id as user,ksess.duration,ksess.persist,ksess.created,krole.flags FROM ksess JOIN kusrs ON ksess.uid=kusrs._id JOIN krole ON krole._id=kusrs.rid WHERE ksess._id='{sessid}'";
					$q=str_replace("{sessid}",$sessid,$q);
					$r=$this->mysqli->query($q);
					$row=$r->fetch_assoc();
					$this->response($this->json($row),200);
				}
				else{
					$this->response("",404);
				}
			}
		}
		
		private function json($data){
			return json_encode($data);
		}
	}
		
	$api = new API;
	ini_set('max_execution_time', 500);
	date_default_timezone_set("America/Mexico_City");
	$api->processApi();
?>