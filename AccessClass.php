<?php
class AccssClass {
	// 접속 기록
	function AccessLog($userID){
		// 테이블 구조 : uid, ipaddr, date, time, OS, browser, userID, hit
		// SESSION 이 살아있는 동안에는 카운트 안되도록 처리
		global $db;
		$access_ip=$_SERVER['REMOTE_ADDR'];
		$getOS = $this->getOS(); // 접속 OS 정보
		$getBrowser = $this->getBrowser(); // 브라우저 접속 정보
		$date = date("Ymd"); // 오늘날짜
		$time = date("H:i:s"); // 시간
		$userID = $userID ? $userID : '';
		$sql ="select count(*) from rb_accessLog where ipaddr='".$access_ip."' and date='".$date."'";
		$result=mysql_query($sql);
		if($row=mysql_fetch_row($result)){
			if($row[0] == 0){ // 오늘 접속날짜 기록이 없으면
				$sql = "INSERT INTO rb_accessLog (ipaddr,date,time,OS,browser,userID,hit) ";
				$sql.= "VALUES ('$access_ip','$date','$time','$getOS','$getBrowser','$userID','1');";
				$result=mysql_query($sql);
			} else { // 접속 기록이 있으면 해당 IP주소의 카운트만 증가시켜라.
				$sql = "UPDATE rb_accessLog SET hit=hit+1 Where ipaddr='".$access_ip."'";
				$result = mysql_query($sql);
			}
		}
	}

	// 접속 Device
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

	function getOS() {
		$user_agent     =   $_SERVER['HTTP_USER_AGENT'];
		$os_platform    =   "Unknown OS Platform";
		$os_array       =   array(
								'/windows nt 10/i'     =>  'Windows 10',
								'/windows nt 6.3/i'     =>  'Windows 8.1',
								'/windows nt 6.2/i'     =>  'Windows 8',
								'/windows nt 6.1/i'     =>  'Windows 7',
								'/windows nt 6.0/i'     =>  'Windows Vista',
								'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
								'/windows nt 5.1/i'     =>  'Windows XP',
								'/windows xp/i'         =>  'Windows XP',
								'/windows nt 5.0/i'     =>  'Windows 2000',
								'/windows me/i'         =>  'Windows ME',
								'/win98/i'              =>  'Windows 98',
								'/win95/i'              =>  'Windows 95',
								'/win16/i'              =>  'Windows 3.11',
								'/macintosh|mac os x/i' =>  'Mac OS X',
								'/mac_powerpc/i'        =>  'Mac OS 9',
								'/linux/i'              =>  'Linux',
								'/ubuntu/i'             =>  'Ubuntu',
								'/iphone/i'             =>  'iPhone',
								'/ipod/i'               =>  'iPod',
								'/ipad/i'               =>  'iPad',
								'/android/i'            =>  'Android',
								'/blackberry/i'         =>  'BlackBerry',
								'/webos/i'              =>  'Mobile'
							);
		foreach ($os_array as $regex => $value) {
			if (preg_match($regex, $user_agent)) {
				$os_platform    =   $value;
			}
		}
		return $os_platform;
	}

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

}//end class

?>
