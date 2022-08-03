<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mininosmail
 *
 * @author suhendrayputra
 */
class Kimail
{

	private $ci;
	private $smtp;
	private $port;
	private $adminEmail;
	private $adminName;
	private $emailSubject;
	private $emailBody;
	private $emailDestination;
	private $nameDestination;

	public function __construct()
	{
		$this->ci = &get_instance();
		$this->ci->load->helper('url');
		$this->ci->config->item('base_url');
		$this->ci->load->database();
	}

	public function __get($property)
	{
		if (property_exists($this, $property)) {
			return $this->$property;
		}
	}

	public function __set($property, $value)
	{
		if (property_exists($this, $property)) {
			$this->$property = $value;
		}
	}

	public function _send($template_type = "order")
	{
		$config = array();
		$config['useragent'] = "KiNET MAILER";

		if (ENVIRONMENT == 'production') {
			$config['mailpath'] = "/usr/bin/sendmail";
		}

		$config['charset'] = 'utf-8';
		$config['validate'] = TRUE;
		$config['mailtype'] = 'html';
		$config['priority'] = 1;
		$config['newline'] = "\r\n";
		$config['wordwrap'] = TRUE;

		$config['protocol'] = (ENVIRONMENT == 'development') ? "smtp" : "sendmail";
		$config['smtp_host'] = (ENVIRONMENT == 'development') ? "smtp.zoho.com" : "mail.flokiid.com";
		$config['smtp_pass'] = (ENVIRONMENT == 'development') ? "--suhendrayputra4986--" : "pada!iQ(Vaoy";
		$config['smtp_user'] = (ENVIRONMENT == 'development') ? "localhost@suhendrayohanaputra.com" : "noreply@flokiid.com";
		$config['smtp_timeout'] = 30;
		$config['smtp_port'] = 465;

		$this->ci->load->library('email');
		$this->ci->email->initialize($config);
		$this->ci->email->set_newline("\r\n");

		if (ENVIRONMENT == 'development') {
			$this->ci->email->from("localhost@suhendrayohanaputra.com", "[DEV] FLOKI NOTIFICATION");
		} else {
			$this->ci->email->from("noreply@flokiid.com", "FLOKI NOTIFICATION");
		}

		$this->ci->email->to($this->emailDestination);
		$this->ci->email->subject($this->emailSubject);
		$message = $this->ci->load->view("templates/email/".$template_type, array("content" => $this->emailBody), TRUE);
		$this->ci->email->message($message);

		$send = $this->ci->email->send();
		if ($send) {
			return array(
				"result" => TRUE,
				"msg" => "success",
			);
		} else {
			return array(
				"result" => FALSE,
				"msg" => $this->ci->email->print_debugger(),
			);
		}
	}

}
