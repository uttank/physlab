<?
//2005.02.23 koy create!

include "../inc/conf.php";
include "../inc/function/define.php";
include "../inc/function/funcError.php";
require "../inc/db_connect.php";
include "../inc/icpr_count.php";

if($sn){
	$bbs_name="DVD";
	icpr_count($sn,$bbs_name);
}


$remote_address = $_SERVER['REMOTE_ADDR'];
if(ereg("^147\.46\.", $remote_address)){
    $in_snu = TRUE;
}else if(ereg("^147\.47\.", $remote_address)){
	$in_snu = TRUE;
} else{
    //$in_snu = FALSE;
    $in_snu = TRUE;
}


//$in_snu = FALSE;
    
$sn = (isset($_GET['sn']) && !empty($_GET['sn'])) ? $_GET['sn'] : FALSE;
$order = (isset($_GET['order']) && !empty($_GET['order'])) ? $_GET['order'] : FALSE;

if($sn == FALSE || $order == FALSE){
	$jsError = array('msg'=>'������ ���� ����','history'=>-1,'close'=>0,'exit'=>'');
	jsError($jsError);
}

//������̸� �ٷ� �ٿ�ε� �����ϰ�  -> db_server�� encyclopedia/download.php
//����밡 �ƴϸ� �α�â���� �̵��Ѵ�..-> db_server�� encyclopedia.outof.snu/download.php
$download_file = $in_snu == TRUE ? "http://" . $db_host_out . "/download/encyclopedia/download.php?sn=$sn&order=$order" : "http://" . $db_host_out . "/download/encyclopedia.outof.snu/download.php?sn=$sn&order=$order";

//�ٿ�ε�� ������Ʈ.. Ŭ���ϸ� ������ �ö�.. �ٿ�ȹ޾Ƶ� Ŭ���ϸ� �ٿ�������� �ߴٰ� ������..
$connect = jConnect();
mysql_select_db($DB);
$TB = "DVD";
mysql_query("update $TB set download=download+1 where sn='$sn'");
	
header("location:$download_file");
?>
