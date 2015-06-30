<?php

$coni = mysql_connect('localhost', 'root', '');
$mysql = mysql_select_db('requests', $coni);

$query = "SELECT login FROM requests";
$result = mysql_query($query);
$sort = array();
// asort($result);
while($row = mysql_fetch_array($result)){

    array_push($sort,$row['login']);

}

sort($sort);

$from_time = strtotime($sort[0]) - 60*60*24;

$days = 14*24*60*60;
$to_time = $from_time + $days;
$now = strtotime('now');

while($to_time < $now){
    $from =  date('Y-m-d',$from_time);
    $to = date('Y-m-d',$to_time);
    echo '<a href="excel.php?from='.$from_time.'&to='.$to_time.'">from_'.$from.'_to_'.$to.'</a><br>';
    $to_time += $days;
    $from_time += $days;
};
echo '<a href="excel.php?from='.$from_time.'&to='.$to_time.'">from_'.$to.'_to_'.date('Y-m-d',$now).'</a><br>';

if (isset($_GET['from']) && isset($_GET['to']) && !empty($_GET['from']) && !empty($_GET['to'])) {
    require_once 'C:/xampp/htdocs/Classes/PHPExcel.php';



    $from_time = $_GET['from'];
    $to_time = $_GET['to'];
    $query = "SELECT * FROM requests WHERE UNIX_TIMESTAMP(login) BETWEEN '$from_time' AND '$to_time'";
    $data = array();
    $result = mysql_query($query);

    while ($row = mysql_fetch_assoc($result)) {

        array_push($data, $row);

    }
    $i = 0;
    $rows = array();
    foreach ($data as $item) {


        while ($i < count($item)) {
            foreach ($item as $it => $key) {
                array_push($rows, $it);
                $i++;
            }


        }


    }
    array_unshift($data, $rows);

// Create new PHPExcel object
    $objPHPExcel = new PHPExcel();

// Fill worksheet from values in array


    $objPHPExcel->getActiveSheet()->fromArray($data, null, 'A1');


// Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('Members');

// Set AutoSize for name and email fields
    foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
        $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);

    }
    $c = $objPHPExcel->getActiveSheet()->getHighestDataColumn();
//$objPHPExcel->getActiveSheet()->getStyle('A1:'.$c.'1')->getFont()->setBold(true);

    $objPHPExcel->getActiveSheet()->getStyle('A1:' . $c . '1')->applyFromArray(
        array(
            'font' => array(
                'bold' => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            ),
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startcolor' => array(
                    'argb' => 'FFA0A0A0'
                ),
                'endcolor' => array(
                    'argb' => 'FFFFFFFF'
                )
            )
        )
    );


//$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
//$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);4


// Save Excel 2007 file

    $time = date("d-m-Y_H_i");

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('excel/Exel-' . $time . '.xlsx');
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Exel-' . $time . '.xlsx"');
    header('Cache-Control: max-age=0');

}

?>