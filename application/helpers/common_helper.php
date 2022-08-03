<?php

function spellMoney($value)
{
    $ci = &get_instance();
    $ci->load->library('moneyspelling');
    //$spell = new Moneyspelling();
    return $ci->moneyspelling->number_word($value, "IDR");
}

function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        $hasil = "minus " . trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return $hasil;
}

function getFractionFromDate($dateTime, $search)
{
    return date($search, strtotime($dateTime));
}

function generate_qrorder($no)
{
    $ci = &get_instance();
    $ci->load->library('ciqrcode');

    $config['cacheable'] = true; //boolean, the default is true
    $config['cachedir'] = ''; //string, the default is application/cache/
    $config['errorlog'] = ''; //string, the default is application/logs/
    $config['quality'] = true; //boolean, the default is true
    $config['size'] = ''; //interger, the default is 1024
    $config['black'] = array(224, 255, 255); // array, default is array(255,255,255)
    $config['white'] = array(0, 0, 0); // array, default is array(0,0,0)

    $ci->ciqrcode->initialize($config);
    $imagePath = 'assets/qrcode_order/';

    $params['data'] = base_url('tracking/order?inv=' . $no); // 'This is a text to encode become QR Code';
    $params['level'] = 'H';
    $params['size'] = 2;
    $params['savename'] = FCPATH . $imagePath . $no . '.png';
    //echo FCPATH . $imagePath . $no . '.png<br/>';
    $renderedImage = base_url() . $imagePath . $no . '.png';
    $ci->ciqrcode->generate($params);
    return $renderedImage;
}

function renderActionButton($param)
{
    $btn = '<a';
    $space = ' ';
    if (array_key_exists('class', $param)) {
        $btn .= $space . "class='btn " . $param['class'] . "'";
    }
    if (array_key_exists('href', $param)) {
        $btn .= $space . 'href="' . $param['href'] . '"';
    }
    if (array_key_exists('href', $param)) {
        $btn .= $space . 'title="' . $param['title'] . '"';
    }
    if (array_key_exists('attr', $param)) {
        $btn .= $space . $param['attr'];
    }
    $btn .= $space . '>';
    if (array_key_exists('icon', $param)) {
        $btn .= "<i class='fa " . $param["icon"] . "'></i>";
    }
    if (array_key_exists('title', $param)) {
        $btn .= $space . $param['title'];
    }
    $btn .= '</a>';

    return $btn;

}

function addZeroToPhone($phone)
{
    $tmpPhone = $phone;
    if ((int)$phone[0] > 0) {
        $tmpPhone = str_pad($phone, strlen($phone) + 1, "0", STR_PAD_LEFT);
    }
    return $tmpPhone;
}

function buildButton($orderDetail, $inArray)
{
    $buttonCollection = array(
        array("id" => "addExtra", "class" => "btn_add_detail_extra btn btn-info btn-sm", "title" => "Add Extra"),
        array("id" => "readyToPickup", "class" => "btn_detail_done btn btn-success btn-sm", "title" => "Ready To Pickup"),
        array("id" => "editDetail", "class" => "btn_detail_edit btn btn-warning btn-sm", "title" => "Edit"),
        array("id" => "pickup", "class" => "btn_detail_taked btn btn-success btn-sm", "title" => "Pickup"),
        array("id" => "delete", "class" => "btn_delete_order_detail btn btn-danger btn-sm", "title" => "Delete"),
        array("id" => "cancelDone", "class" => "btn_detail_unfinish btn btn-info btn-sm", "title" => "Rollback"),
        array("id" => "revertTaken", "class" => "btn_detail_reverttake btn btn-danger btn-sm", "title" => "Rollback Pickup"),
        array("id" => "pickupInfo", "class" => "btn btn-default btn-sm", "title" => "Already Pickup at " . formatDate("d F Y", $orderDetail["pickup_date"]))
    );
    $retval = array();
    $count = 0;
    for ($x = 0; $x < sizeof($inArray); $x++) {
        for ($y = 0; $y < sizeof($buttonCollection); $y++) {
            $idButton = $buttonCollection[$y]["id"];
            if ($inArray[$x] == $idButton) {
                $retval[$count] = '<a href="javascript:void(0)" 
												data-id="' . $orderDetail["id"] . '" 
												data-headerid="' . $orderDetail["header_id"] . '" 
												data-serviceid="' . $orderDetail["service_id"] . '" 
												class="' . $buttonCollection[$y]["class"] . '">' . $buttonCollection[$y]["title"] . '</a>';
                $count++;
            }
        }
    }
    return implode(" ", $retval);
}

function dateToday($format = "Y-m-d")
{
    return date($format);
}

function dateTodayWithTime($format = "Y-m-d H:i:s")
{
    return date($format);
}

function formatCurrency($value = 0)
{
    return number_format($value, "0", ",", ".");
}

function formatDate($format, $time)
{
    return date($format, strtotime($time));
}

function getAlphabet($from = 'A', $to = 'Z')
{
    $alpha = array();
    foreach (range($from, $to) as $elements) {
        $alpha[] = $elements;
    }
    return $alpha;
}

function render_tracking($view, $data = NULL, $css = NULL, $js = NULL, $template = 'default')
{
    $ci = &get_instance();
    $header = array_merge($data, array("css" => $css));
    $footer = array_merge($data, array("js" => $js));
    if ($template == 'default') {
        $ci->load->view("shared/layout_header_tracking", $header);
        $ci->load->view($view, $data);
        $ci->load->view("shared/layout_footer", $footer);
    } else {
        $ci->load->view("shared/layout_header_tracking", $header);
        $ci->load->view($view, $data);
        $ci->load->view("shared/login_footer", $footer);
    }
}

function render_view($view, $data = NULL, $css = NULL, $js = NULL, $template = 'default')
{
    $ci = &get_instance();
    $header = array_merge($data, array("css" => $css));
    $footer = array_merge($data, array("js" => $js));
    if ($template == 'default') {
        $ci->load->view("shared/layout_header", $header);
        $ci->load->view($view, $data);
        $ci->load->view("shared/layout_footer", $footer);
    } else {
        $ci->load->view("shared/login_header", $header);
        $ci->load->view($view, $data);
        $ci->load->view("shared/login_footer", $footer);
    }
}

function render_modal($view, $data = NULL)
{
    $ci = &get_instance();
    $ci->load->view($view, $data);
}

function buildActionButton($buttons)
{
    $button = array();
    for ($idx = 0; $idx < sizeof($buttons); $idx++) {
        $btn = $buttons[$idx];
        $button[] = '<a ' . !empty($btn["btnData"]) ? $btn['btnData'] : '' . ' class="btn btn-sm ' . $btn["btnClass"] . '" href="' . $btn['btnUrl'] . '" title="' . $btn['btnTitle'] . '"><i class="glyphicon glyphicon-' . $btn['btnIcon'] . '"></i> ' . $btn['btnTitle'] . '</a>';
    }
    return implode("", $buttons);
}

function usercontrol($uc, $data = array())
{
    $ci = &get_instance();
    $ci->load->view('shared/user_controls/' . $uc, $data);
}

function _load($file, $admin = FALSE, $externalResource = FALSE)
{
    $ci = &get_instance();
    if (!$externalResource) {
        return base_url('assets/' . $file);
    } else {
        return $file;
    }
}

function isEmpty($obj)
{
    if (empty($obj) || $obj == "" || $obj == null) {
        return true;
    } else {
        return false;
    }
}

function isExists($obj)
{
    if (isset($obj)) {
        return true;
    } else {
        return false;
    }
}

function isBranch($isbranch)
{
    if ($isbranch == ISBRANCH) {
        return true;
    } else {
        return false;
    }
}

function do_debug($data, $die = false, $type = 0)
{
    if ($type == 1) {
        var_dump($data);
    } else {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
    if ($die) {
        die();
    }
}

if (!function_exists('base_url')) {

    /**
     * Base URL
     *
     * Create a local URL based on your basepath.
     * Segments can be passed in as a string or an array, same as site_url
     * or a URL to a file can be passed in, e.g. to an image file.
     *
     * @param string $uri
     * @param string $protocol
     * @return    string
     */
    function base_url($uri = '', $protocol = NULL)
    {
        return get_instance()->config->base_url($uri, $protocol);
    }

}
