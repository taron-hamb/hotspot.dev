<?php

$time = date("d-m-Y_H_i");
$fp = fopen('csv/Csv_'.$time.'.csv', 'w');

foreach($csv as $cs => $csv_item){

    fputcsv($fp,  $csv_item);


}

fclose($fp);
$fileName = 'Csv_' . $time . '.csv';
$filePath = $_SERVER['DOCUMENT_ROOT'].'/csv/' . $fileName;

echo file_get_contents($filePath);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Csv_'.$time.'.csv"');
header('Cache-Control: max-age=0');