<?php
$data = array();
foreach ($excel as $ex) {
    array_push($data, $ex);
}

$rows = array();
$i =0;
foreach ($data as $item) {
    while ($i < count($item)) {
        foreach ($item as $it => $key) {
            array_push($rows, $it);
            $i++;
        }
 }
}
array_unshift($data, $rows);

$objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->fromArray($data, null, 'A1');
$objPHPExcel->getActiveSheet()->setTitle('Members');

foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
    $objPHPExcel->getActiveSheet()
        ->getColumnDimension($col)
        ->setAutoSize(true);
}

$c = $objPHPExcel->getActiveSheet()->getHighestDataColumn();

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

$time = date("d-m-Y_H_i");
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Excel_' . $time . '.xls"');
header('Cache-Control: max-age=0');
$objWriter->save('php://output');