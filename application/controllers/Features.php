<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Features extends CI_Controller
{
    public function __construct()
    {
    }
    public function njir()
    {
        print_r($this->input->post());
        echo json_encode($this->input->post());
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function qrcode()
    {
        $this->load->library('ciqrcode');

        $config['cacheable'] = true; //boolean, the default is true
        $config['cachedir'] = ''; //string, the default is application/cache/
        $config['errorlog'] = ''; //string, the default is application/logs/
        $config['quality'] = true; //boolean, the default is true
        $config['size'] = ''; //interger, the default is 1024
        $config['black'] = array(224, 255, 255); // array, default is array(255,255,255)
        $config['white'] = array(70, 130, 180); // array, default is array(0,0,0)

        $this->ciqrcode->initialize($config);
        $no = "Suhe_Tampan_Se-Land_of_Down";
        $imagePath = 'assets/qrcode_order/';


        $params['data'] = base_url('transaction/order/order_status/' . $no); // 'This is a text to encode become QR Code';
        $params['level'] = 'H';
        $params['size'] = 10;
        $params['savename'] = FCPATH . $imagePath . $no . '.png';
        //echo FCPATH . $imagePath . $no . '.png<br/>';
        $renderedImage = base_url() . $imagePath . $no . '.png';
        $this->ciqrcode->generate($params);
        echo '<img src="' . $renderedImage . '" />';
    }

}
