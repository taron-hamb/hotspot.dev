<?php

$time = date("d-m-Y_H_i");
$fp = fopen('csv/Csv-'.$time.'.csv', 'w');

foreach($csv as $cs){

    fputcsv($fp,  $cs);

}
fclose($fp);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Csv-'.$time.'.csv"');
header('Cache-Control: max-age=0');