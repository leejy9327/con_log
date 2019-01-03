<?php
/*
로그인 정보를 검사하여 로그인이 성공(ID, PW 일치)하면 1, 실패하면 0 을 반환한다.
성공할 경우 SESSION 을 생성하고 접속 로그를 기록한다.
*/
if(isset($_POST['loginID']) && !empty($_POST['loginID']) && isset($_POST['loginPW']) && !empty($_POST['loginPW'])) {
    $loginID = trim($_POST['loginID']);
    $loginPW = trim($_POST['loginPW']);

    require_once 'dbconnect.php'; // db접속
    require_once 'phpclass/AccessClass.php';
    require_once 'phpclass/loginClass.php';

    $a=new AccessClass();
    $c=new LoginClass();

    $row = $c->UserAuthCheck($loginID,$loginPW); // 성공(1), 실패(0)
    if($row == 1) {
        $_SESSION['userID'] = $row['id'];
        $_SESSION['userPW'] = md5($loginPW);
        $a->AccessLog($_SESSION['userID']); // 접속 로그 기록
    } else {
        $msg ='정보가 올바르지 않습니다';
        echo "<script>alert('".$msg."');history.go(-1);</script>";
    }
}

?>
