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
    echo '<a href="csv.php?from='.$from_time.'&to='.$to_time.'">from_'.$from.'_to_'.$to.'</a><br>';
    $to_time += $days;
    $from_time += $days;
};
echo '<a href="csv.php?from='.$from_time.'&to='.$to_time.'">from_'.$to.'_to_'.date('Y-m-d',$now).'</a><br>';
if (isset($_GET['from']) && isset($_GET['to']) && !empty($_GET['from']) && !empty($_GET['to'])) {
    require_once 'C:/xampp/htdocs/Classes/PHPExcel.php';


    $from_time = $_GET['from'];
    $to_time = $_GET['to'];
    $query = "SELECT * FROM requests WHERE UNIX_TIMESTAMP(login) BETWEEN '$from_time' AND '$to_time'";
    $result = mysql_query($query);
    $time = date("d-m-Y_H\.i");
    $fp = fopen('csv/Csv-'.$time.'.csv', 'w');

    while($row = mysql_fetch_assoc($result)){

        fputcsv($fp, $row);
    };

    fclose($fp);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Csv-'.$time.'.csv"');
    header('Cache-Control: max-age=0');
}
//$query = "SELECT * FROM users";



?>