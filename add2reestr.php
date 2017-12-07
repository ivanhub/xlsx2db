<?php
// Загрузка данных с Excel файла в SQL БД.

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

//Настройки подключения к БД
$host        = 'localhost'; // Host Name.
$db_user     = 'log'; //User Name
$db_password = '';
$db          = 'log'; // Database Name.
$conn = mysqli_connect($host, $db_user, $db_password, $db) or die(mysqli_error());
global $sql;

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

if (!$conn->set_charset("utf8")) {
    printf("Ошибка при загрузке набора символов utf8: %s\n", $mysqli_link->error);
    exit();
}



//Для удобства сконвертируем Excel файл в CSV
$filename = "defensive.csv";

// Подключим библиотеку : Path to PHPExcel classes 
require_once 'PHPExcel.php';
//require_once 'PHPExcel/IOFactory.php';

// Входящий файл - Your input Excel file.
$excelFile = $uploadfile;

// Создаим объект - Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Read your Excel workbook
try {
    $inputFileType = PHPExcel_IOFactory::identify($excelFile);
    $objReader     = PHPExcel_IOFactory::createReader($inputFileType);
    ###    $objReader->setReadDataOnly(true);
    ###    $objReader->setLoadSheetsOnly(['реестр', 'Список']); 
    ####$worksheetList = $objReader->listWorksheetNames($excelFile);
    ####$sheetnames = array($worksheetList[0], $worksheetList[1]) ; 
    ####$objReader->setLoadSheetsOnly($sheetnames); 
    ####print_r($worksheetList);
    
    $objPHPExcel     = $objReader->load($excelFile);
    $activeSheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
    $objPHPExcel->getActiveSheet()->fromArray($activeSheetData, false);
    
}

catch (Exception $e) {
    die('Error loading file "' . pathinfo($excelFile, PATHINFO_BASENAME) . '": ' . $e->getMessage());
}

//Всего строк
$highestRow = $objPHPExcel->setActiveSheetIndex(1)->getHighestRow();
echo $highestRow;
echo " lines";

//Удалим мусор: шапку документа с заголовками, отформатируем формат Дат
$objPHPExcel->setActiveSheetIndex(1)->removeRow(1, 20);
$objPHPExcel->setActiveSheetIndex(1)->getStyle('AV1:AV' . $highestRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD);
$objPHPExcel->setActiveSheetIndex(1)->removeColumn('A')->removeColumn('B')->removeColumn('C');


// Сохраним в CSV : Export to CSV file.
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
$objWriter->setSheetIndex(1); // Select which sheet.
//$objWriter->setDelimiter(';');  // Define delimiter
$objWriter->save($filename);

// Можно было изначально удалить пустые столбцы не сохраняя их, но намного проще удалить их через str_replace:
$contents = file_get_contents($filename);
$contents = str_replace('""', '', $contents);
// $contents = str_replace('"",','', $contents);
$contents = str_replace(',', '', $contents);
$contents = str_replace('""', '","', $contents);

$contents = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $contents);
file_put_contents($filename, $contents);

//Объединим ячейки содержащие номер сертификата:
$fh  = fopen($filename, 'rb');
$arr = array();
while ($col = fgetcsv($fh)) {
    if (isset($col[7]) && (strlen($col[7])) > 1) {
        $date = $col[7];
    }
    //if($row == 1){ $row++; continue; } //skip 1st row //$num = count($fh);
    if (strlen($col[0]) > 5) {
        $newline = $col[0] . "," . $col[1] . "," . $col[2] . $col[3] . $col[4] . $col[5] . $col[6] . "," . $date . "\n";
        array_push($arr, $newline);
    }
    //fputcsv($out, $arr,",");
}
//Сохраняем
file_put_contents($filename, $arr);


//Сохрание в Базу данных : Save data to SQL DB

##   $data = file_get_contents($filename);
##   $data = mb_convert_encoding($data, "UTF-8", "WINDOWS-1251");
##   file_put_contents($filename,$data);

$file  = fopen($filename, "r");
$count = 0;
//$row = 1;                                       // add this line
while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
    $num         = count($emapData);
    //if($row == 1){ $row++; continue; }
    $emapData[4] = "Защитное вождение";
    //Будет установлено впоследствии POST'oм через форму.
    $sql_query   = "INSERT into registry (name,organization,number,date,area) values ('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]','$emapData[4]')";
    //print_r($sql_query);
    
    $sql = mysqli_query($conn, $sql_query);
    ////last array queryprint_r($emapData);
}

if ($sql) {
    echo "\n<br/><br/><center><font color=green size=5>Данные успешно были загружены</font></center>\n";
} else {
    echo "<br/><br/><center><font color=green size=4>";
    echo "\nИмеется проблема:\n";
    echo "\nВозможно данные были уже загружены ранее.\n";
    echo "</font></center>";
}

?>
