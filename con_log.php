<?php

class Con_Log {
	// 접속 기록
	function AccessLog(){
		// 테이블 구조 : uid, ipaddr, date, time, OS, browser, userID, hit
		// SESSION 이 살아있는 동안에는 카운트 안되도록 처리
		global $link;

		$ip = $_SERVER['REMOTE_ADDR'];
		$device = $this->user_agent(); // device 정보
        $date = date('Y-m-d');
		//$userID = $userID ? $userID : '';
		$sql ="select `ip` from `tb_log` where `ip`='".$ip."' and con_date='".$date."'";

		$result=mysqli_query($link,$sql);
		if($result->num_rows == 0){ // 오늘 접속날짜 기록이 없으면
			$sql = "INSERT INTO `tb_log` SET
					`device` = '$device',
					`ip` = '$ip',
					`hit` = '1',
					`con_date`  = now()";
			$result =mysqli_query($link,$sql);
		} else { // 접속 기록이 있으면 해당 IP주소의 카운트만 증가시켜라.
			$sql = "UPDATE `tb_log` SET `hit` = hit+1 WHERE `ip`='$ip' AND `con_date` = '$date'";
			$result = mysqli_query($link,$sql);
		}
	}


	function user_agent() {
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$is_agent = "PC";
		$os_array = array ('iPhone', 'iPod', 'BlackBerry', 'Android', 'Windows CE', 'Windows CE;', 'LG', 'MOT', 'SAMSUNG', 'SonyEricsson', 'Mobile', 'Symbian', 'Opera Mobi', 'Opera Mini', 'IEmobile');
		foreach ($os_array as $value) {
			if (stristr($user_agent, $device)) {
				$is_agent = "Mobile";
			}
		}
		return $is_agent;
	}


	// 접속 Device
	/*
	function user_agent(){
		$iPod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
		$iPhone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
		$iPad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
		$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
		if($iPad||$iPhone||$iPod){
			return 'ios';
		} else if($android){
			return 'android';
		} else {
			return 'etc';
		}
	}
*/

	/*

	function getBrowser() {
		$user_agent     =   $_SERVER['HTTP_USER_AGENT'];
		$browser        =   "Unknown Browser";
		$browser_array  =   array(
								'/msie/i'       =>  'Internet Explorer',
								'/firefox/i'    =>  'Firefox',
								'/safari/i'     =>  'Safari',
								'/chrome/i'     =>  'Chrome',
								'/edge/i'       =>  'Edge',
								'/opera/i'      =>  'Opera',
								'/netscape/i'   =>  'Netscape',
								'/maxthon/i'    =>  'Maxthon',
								'/konqueror/i'  =>  'Konqueror',
								'/mobile/i'     =>  'Mobile Browser'
							);
		foreach ($browser_array as $regex => $value) {
			if (preg_match($regex, $user_agent)) {
				$browser    =   $value;
			}

		}
		return $browser;
	}
	*/

}//end class

?>
