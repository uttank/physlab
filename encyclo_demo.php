<?
/*------------------------------------------------------------------------------
 * 수정일        요청자  수정자  수정사유
 *------------------------------------------------------------------------------
 * 2003.1.2       koy      koy    새로만듬
 * 2005.2.23      dpmin    koy    로긴하면 동영상 다운로드 가능하도록 수정함!
 *----------------------------------------------------------------------------*/
/*******************************************************************************
 * Title        : encyclo.php
 * @author      :
 * @date        :
 * @Description : 물리시범백과-Demonstrations
 ******************************************************************************/

$page_gbn = 6;		# 물리교육
$page_gbn_s = 2;	# 물리시범백과-Demonstrations
include "../inc/conf.php";
include "../comm/menu2.php";
require "../inc/function/funcWebControl.php";

$remote_address = $_SERVER['REMOTE_ADDR'];

//서울대인지 아닌지 체크한다.
if(ereg("^147\.46\.", $remote_address)){
	$in_snu = TRUE;
	$tip = "Mouse를 올려 놓으시면 화면 위쪽, Disk 제목 아래에 동영상의 URL이 나타납니다..\n복사하여 새창에 붙여 넣으시면 동영상의 다운로드가 가능합니다.";
}
else if(ereg("^147\.47\.", $remote_address)){
	$in_snu = TRUE;
	$tip = "Mouse를 올려 놓으시면 화면 위쪽, Disk 제목 아래에 동영상의 URL이 나타납니다..\n복사하여 새창에 붙여 넣으시면 동영상의 다운로드가 가능합니다.";
}
 else{
	$in_snu = FALSE;
	$tip = ""; 
}
$disc = (isset($_GET['disc']) && !empty($_GET['disc'])) ? $_GET['disc'] : 1;

$title_file = 'encyclo_title.txt';
$fp = fopen($title_file, "r");
while(!feof($fp)){
	$line = fgets($fp, 500);
	$line = trim($line);
	if(!empty($line) && !ereg("^#",$line)){
		list($key,$val) = split("\|", $line);
		$arr_disc[$key] = "Disc " . $key . " : " . trim($val);
	}

}

list($select_disc,$disc_cd) = Select_List($arr_disc, $disc, $select_name='disc', $etc = "onChange='javascript:Go_Select(this.form,\"disc\");'");
$connect = jConnect();
mysql_select_db($DB);
$TB = "DVD";
$savedir = '/file/education/encyclopedia';
$tr_dvd = '';

$SQL = "SELECT SN, TITLE, MOVIE, HIT "
	 . "FROM $TB "
	 . "WHERE DISC=$disc "
	 . "ORDER BY SN";
if($RES = mysql_query($SQL,$connect)){
	if(mysql_num_rows($RES)){
		$i = 0;
		while($data = mysql_fetch_row($RES)){
			$i++;
			$sn = trim($data[0]);
			$title = stripslashes(trim($data[1]));
			$movie = stripslashes(trim($data[2]));
			$hit = trim($data[3]);

			$arr_movie = split(";", $movie);

			$movies = '';
			foreach($arr_movie as $key => $val){//encyclo_downloads_check
				$order = $key + 1;
				$onMouseOver = $in_snu == TRUE ? "onMouseOver='javascript:document.form.vod_url.value=\"http://$db_host_out/download/encyclopedia/download.php?sn=$sn&order=$order\"'" : '';
				if($in_snu == TRUE){
					$movies .= "[<a href='encyclo_downloads_check.php?sn=$sn&order=$order'>download</a>] ";
				} else{
					$movies .= "[<a href='encyclo_downloads_check.php?sn=$sn&order=$order'>download</a>] ";
#					$movies .= "<a href='javascript:alert(\"서울대 내에서만 서비스됩니다.\n죄송합니다.\");'><img src='../images/icon_tv.jpg' border='0' alt='$tip'></a> ";
				}
			}


			$tr_dvd .= "
						<tr>
                          <td valign='top' class='tlt15'>$i.  $title <font style='font-size:11px; color:#999999;'>($hit)</font> </td>
                          <td width='110'><span class='style4'>$movies</span></td>
                          </tr>
                        <tr>
                          <td height='1' colspan='2' bgcolor='#e1e1e1' ></td>
                        </tr>";
		}
	}
} else{
}


?>
<script language='javascript'>
<!--
function Go_Select(form,getVar){
	var getVar;
	if( form.disc.value != 0 ){
		self.location.href = "encyclo_demo.php?"+getVar+"="+form.disc.value;
	}
}
-->
</script>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<title>ICPR-물리학정보연구센터</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<link href="../img/css.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
#apDiv1 {
	position:absolute;
	left:254px;
	top:155px;
	width:127px;
	height:151px;
	z-index:1;
}
.style1 {
	color: #000000;
	font-weight: bold;
}
.style4 {color: #666666}
-->
</style>
<link href="../img/css.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%"  height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="top"><table width="840" border="0" cellspacing="0" cellpadding="0" height="100%">
      <tr>
        <td height="118" valign="top"><? include "../incs/mtop.php"; ?></td>
      </tr>
      
      <tr>
        <td height="%" valign="top" style="padding:20px 0 0 0"><table width="830" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="164" valign="top"><? include "../incs/left04.php"; ?></td>
            <td width="10">&nbsp;</td>
            <td width="656" valign="top"><table width="656" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td height="40" background="../img/bbs/tlt_bg.gif" style="padding:5px 0 0 20px" valign="top"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td><img src="../img/education/01_tlt02.gif" width="297" height="23"></td>
                                  <td align="right"></td>
                                </tr>
                            </table></td>
                          </tr>
                      </table></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td height="28" class="px11" style="padding:0 0 0 10px"><span class="px11" style="padding:0 0 0 10px">홈 &gt; 교육자료 &gt; 실험 및 시범 &gt;<span class="style1"> 물리시범백과</span></span></td>
              </tr>
              <tr>
                <td height="10" class="px11" ></td>
              </tr>
             
              <tr>
                <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    
                    <tr>
					<form method='get' name='form' action='<?=$PHP_SELF . "?disc=$disc"?>'>
                      <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td height="41" background="../img/education/0102_linebg.gif" style="padding:0 0 0 30px">
							<?=$select_disc?>
						  </td>
                          </tr>
                      </table></td>
					  </form>
                    </tr>
                    <tr>
                      <td height="30" style="padding:10px 0 0 0"><table width="100%" border="0" cellspacing="0" cellpadding="5">
					  <?=$tr_dvd?>
                      </table></td>
                    </tr>
                     <tr>
                      <td height="1" bgcolor="#666666"></td>
                    </tr>
                    
                    <tr>
                      <td height="30" class="px11" style="padding:10px 0 10px 0">* 물리학연구정보센터(ICPR)에서 마련한 자료로서 서울대학교 내에서만 서비스됩니다.</td>
                    </tr>
                    
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="83" valign="top"><? include "../incs/mbtm.php"; ?></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
