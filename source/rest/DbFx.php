<?php

	class DbFx {
		
		public function db_str($s){
			return "'".str_replace("'",null,$s)."'";
		}
		
	}

?>