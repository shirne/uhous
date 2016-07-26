<?php
/*
 * Created on 2012-3-13
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
$arr=array('a','b');
foreach($arr AS $i){
echo <<<HTML
$i
HTML;
}
exit;

include('libs/fckeditor/editor/filemanager/connectors/php/config.php');
echo _GetRootPath();
echo $_SERVER['PHP_SELF'];
// current time
echo date('h:i:s') . "\n";

// sleep for 10 seconds
sleep(.1);

// wake up !
echo date('h:i:s') . "\n";
exit;

//echo $_SERVER['HTTP_ACCEPT'];
header('Content-Disposition: attachment; filename="index.php"');
//http://wiki.nginx.org/X-accel
header('X-Accel-Redirect:/index.php');
exit;
echo dirname(__FILE__);
session_start();
echo '一月';
echo strtotime('2011-09-08')-strtotime('2011-08-08');
echo '三个月';
echo strtotime('2011-09-08')-strtotime('2011-06-08');
echo '半年';
echo strtotime('2011-09-08')-strtotime('2011-03-08');
echo '一年';
echo strtotime('2011-09-08')-strtotime('2010-09-08');
echo '二年';
echo strtotime('2010-09-08')-strtotime('2008-09-08');
echo '三年';
echo strtotime('2010-09-08')-strtotime('2007-09-08');
echo '五年';
echo strtotime('2010-09-08')-strtotime('2005-09-08');

exit;
$arr=array('a'=>1,2=>6);
$str=serialize($arr);
$a=unserialize('a:2:{s:1:"a";i:1;i:2;i:6:}');
var_dump($arr);
echo $str;
var_dump(unserialize(null));
var_dump(setcookie('a','b'));
var_dump($_COOKIE['a']);
exit;
echo date('Y-m-d',1333768202);
$str='NRFHFLOGTBIHURDAFCKTFONJTNGFMESQSLBQEQJILGJRNNBOUSDRGXJRIQQRJZQURVSYRLRDOFVBFKKKFFGXDNYXLWPNFPGDIDBOGXHDNBMDSQSAKPXJHSBWYXLWWCZHJBIEHKXXYZRTPITVDOGJILLRUMCVULWZMQDSRALFRPNIZIBMOUSCKPWBELJGZOLOOZXJMAANELTFYLOSZFGKYDLKJGRPDVNWULPEOKTKFDPGNYCJPENIPQBOFDZRBOHTSHZMOMYANWSAMKLRAGTROJEXNZTAIAJRDSDNHQVMMXDZMPTUTOMLOSNGSLOPGTYUJJNSEHQJGSODKYPAH';
$map=array(
    34=>65,
    32=>66,
    33=>67,
    40=>68,
    41=>69,
    46=>70,
    44=>71,
    93=>72,
    59=>73,
    126=>74,
    125=>75,
    124=>76,
    123=>78,
    63=>77,
    62=>79,
    61=>81,
    91=>80,
    68=>82
);

for ( $i = 0;$i<strlen($str) ;$i++){
	$code=ord(strtolower($str[$i]));
	if(isset($map[$code]))echo $map[$code];
}
