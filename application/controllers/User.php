<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{

    public function index()
    {
        if (isset($_SESSION['login'])) {
            $this->load->model('users');
            $data['hotspot_id'] = $this->users->get_hotspots();
            $this->load->view('user_page', $data);
        } else {
            $this->load->view('login_page');
        }
    }

    public function logout()
    {
        unset($_SESSION['login']);
        header('Location: '.base_url());
    }

    public function login()
    {
        if (isset($_SESSION['login'])) {

            $this->load->model('users');
            $data['hotspot_id'] = $this->users->get_hotspots();

            $this->load->view('user_page', $data);
        } else {
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');

            $this->form_validation->set_rules('login', 'trim|required|min_length[5]|max_length[12]|xss_clean');
            $this->form_validation->set_rules('password', 'trim|required|md5');

            if ($this->form_validation->run() == false) {
                header('Location: '.base_url());
            } else {
                $login = $this->input->post('login');
                $password = $this->input->post('password');

                $this->load->model('users');

                $value = $this->users->login($login, $password);
                $data['login'] = $login;
                if ($value) {
                    $array = array('login' => $login);
                    $this->session->set_userdata($array);

                    header('Location: '.base_url());
                } else {
                    $message['message'] = 'Please try again';
                    $this->load->view('login_page', $message);

                }
            }

        }


    }

    public function get_hotspots()
    {
        if (isset($_SESSION['login'])) {
            $this->load->model('users');
            $hotspots['hotspots'] = $this->users->get_hotspots();
            $this->load->view('all_hotspots', $hotspots);
        } else {
            header('Location: '.base_url());
        }
    }

    public function get_hotspot($hotspot_id = null)
    {
        if (isset($_SESSION['login'])) {
            if (isset($hotspot_id)) {
                $this->load->model('users');
                $time = $this->users->get_hotspot($hotspot_id);
                if (!empty($time)) {



                $days = 14 * 24 * 60 * 60;


                $from_time = strtotime($time[0]);
//                print_r($from_time);
                $to_last = strtotime(end($time));


                $to_time = $from_time + $days;
                $now = strtotime('now');
                $to = date('Y-m-d H:i:s', $to_time);
                $from = date('Y-m-d H:i:s', $from_time);
                if ($to_time > $to_last) {

                    $to_time = $to_last;
                }
                $excel_array = array();

                while ($to_time <= $to_last) {


                    $from = date('Y-m-d H:i:s', $from_time);
                    $to = date('Y-m-d H:i:s', $to_time);
                    $this->load->model('users');
                    $result = $this->users->get_excel($from, $to);

                    if (!empty($result)) {
                        $from_to = array();
                        $from_to['from'] = $from;
                        $from_to['to'] = $to;

                        array_push($excel_array, $from_to);

                    }

                    $to_time += $days;
                    $from_time += $days;
                    if ($to_time > $to_last) {

                        $to_time = $to_last;
                    }
                    if ($from_time > $to_last) {

                        break;
                    }

                }
                $data['hotspot_id'] = $hotspot_id;
                $data['from_to_times'] = $excel_array;
                $this->load->view('all_hotspots', $data);
            }else {
                    header('Location: '.base_url());
                }

            } else {
                $this->load->model('users');
                $data['hotspot_id'] = $this->users->get_hotspots();

                $this->load->view('user_page', $data);
            }

        } else {
            header('Location: '.base_url());
        }

    }

    public function get_excel($from_time, $to_time)
    {
        if (isset($_SESSION['login'])) {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/application/libraries/Classes/PHPExcel.php';
            $this->load->model('users');

            $data['excel'] = $this->users->get_excel($from_time, $to_time);

            $excel = $data['excel'];

            $data = array();
            foreach ($excel as $ex) {
                array_push($data, $ex);
            }

            $rows = array();
            $i = 0;
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

        } else {
            header('Location: '.base_url());
        }

    }

    public function get_csv($from_time, $to_time)
    {
        if (isset($_SESSION['login'])) {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/application/libraries/Classes/PHPExcel.php';
            $this->load->model('users');

            $data['excel'] = $this->users->get_excel($from_time, $to_time);

            $excel = $data['excel'];

            $data = array();
            foreach ($excel as $ex) {
                array_push($data, $ex);
            }

            $rows = array();
            $i = 0;
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
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
            $objWriter->save('csv/Csv_' . $time . '.csv');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Csv_' . $time . '.csv"');
            header('Cache-Control: max-age=0');
            $objWriter->save('php://output');
        } else {
            header('Location: '.base_url());
        }
    }

    public function delete($from_time, $to_time)
    {
        if (isset($_SESSION['login'])) {
            $this->load->model('users');
            $this->users->delete($from_time, $to_time);
            $this->load->view('all_hotspots');
        } else {
            header('Location: '.base_url());
        }

    }

    public function hotspot_request($count, $hotspot_id = '4daa5936')
    {
        if (isset($_SESSION['login'])) {
            $this->load->model('users');
            $this->users->hotspot_request($count, $hotspot_id);
        } else {
            header('Location: '.base_url());
        }

    }



}