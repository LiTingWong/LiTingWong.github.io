<?php

//get $_POST necessary info, ex, sn, email, password

//errro check email address, ex check if the email domain exist, can use checkdnsrr或getmxrr，但win32下無法使用 
//---> check email address is @mail.utoronto.ca


//sql fecth SELECT sn, status, password FROM USER where email = $email, and status != $delete
/*
checking result:
if ($result == FALSE){not registered}
if (accountStatus == email not verified)
if(accountPassword != $password){ 
	update loginERROR count, 
	after updating, fecthc again and check if error count > 10
	if(error_count > 10){
		generate a radom new pw
		UPDATE User SET password = $newRandomPw WHERE sn = $sn";
		ask for resetting the pw
	}
}

DELETE FROM UserSession WHERE userSn = $sn AND source = $loginSource";
DELETE FROM UserSession WHERE timeSec < (currentTime-$timeOutPeriod(3days))

generate a token = hash("xxxx", rand().rand().rand().rand());
"INSERT INTO UserSession (token, userSn, timeSec, source) VALUES (?,?,?,?,?,?)";
if($result == false){ to prevent token collision, try to insert again}

$sql = "UPDATE GtUser SET loginCount = loginCount + 1, loginErrorCount = '0', loginTimeSec = $timeSec WHERE sn = $sn";

Page_Error("update", "javascript: history.go(-1)");
setcookie("cookieSessionSn", $accountSessionSn, time() + $serverTimeoutCookie, '/', $serverCookieUrl);
setcookie("cookieSessionToken", $token, time() + $serverTimeoutCookie, '/', $serverCookieUrl);

$userSn = $sn

display login success html
*/




/************ getUserSn ********//*
$_COOKIE{"cookieSession"]
$_COOKIE[cookieToken]
fetch sn;
$timeSecValid = $timeNow - $timeOutPeriod;
$sql = "SELECT token, timeSec, userSn FROM UserSession WHERE sn = ? AND timeSec > ?";
$stmt = mysqli_prepare($dbLink, $sql);
$result = mysqli_stmt_bind_param($stmt, 'ii', $sessionSn, $timeSecValid);
$result = mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
mysqli_stmt_bind_result($stmt, $token, $timeSec, $userSn);
$result = mysqli_stmt_fetch($stmt);
mysqli_stmt_free_result($stmt);
mysqli_stmt_close($stmt);

if($token != cookieToken){do sth}
update usersession set timesec = timeNow, where sn = sessionsn

setcookie("cookieSessionSn", $cookieSessionSn, GtTime_GetGmtTimeSec() + $serverTimeoutCookie, '/', $serverCookieUrl);
setcookie("cookieSessionToken", $cookieSessionToken, GtTime_GetGmtTimeSec() + $serverTimeoutCookie, '/', $serverCookieUrl);
return $userSn;
*/


/********log out************//*
readonly onfocus=\"this.removeAttribute('readonly');
*/
?>

