<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko"><head>
    <!-- 문서셋 설정 -->
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <!-- 랜더링 -->
	</head>
<form class="qst_upload_form" action="/forum/excel_test.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="mode" value="qst_upload">
		<tr>
			<td>
				<input type="file" name="uploadedFile">
				<button type="submit" style="font-size:13px;padding:2px;background:skyblue">submit</button>
			</td>
		</tr>
	</table>
</form>

<?
if($_POST['mode'] == 'qst_upload')
{

require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/PHPExcel-1.8/Classes/PHPExcel.php');
require_once dirname($_SERVER['DOCUMENT_ROOT'])."/include/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php";

	$row_cd = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');

	$objPHPExcel = new PHPExcel();
	$filename = $_FILES['uploadedFile']['tmp_name']; // 읽어들일 엑셀 파일의 경로와 파일명을 지정한다.
	$inputFileType = 'Excel2007';
	$objReader = PHPExcel_IOFactory::createReader($inputFileType);
	$objPHPExcel = $objReader->load($filename);
	$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

	print_r($sheetData);




}
?>
</html>