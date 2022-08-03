<?php

(defined('BASEPATH')) or exit('No direct script access allowed');
/**
 * Modular Extensions Revamped - HMVC-RV
 *
 * Revamped version of the Wiredesignz Modular Extensions - HMVC,
 * orignally adapted from the CodeIgniter Core Classes.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2016, British Columbia Institute of Technology
 * Copyright (c) 2015 Wiredesignz
 * Copyright (c) 2017 INVITE Communications Co., Ltd.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * */
/** load the CI class for Modular Extensions * */
require dirname(__FILE__) . '/Base.php';

class MX_Controller {

    public $userData;
    public $data;
    public $activeClass;
    public $activeMethod;
    public $activeModule;
    public $reqMethod;
    public $viewPage;
    public $jsModules;
    public $autoload = array();

    public function __construct() {
        $class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
        log_message('debug', $class . " MX_Controller Initialized");
        Modules::$registry[strtolower($class)] = $this;

        /* copy a loader instance and initialize */
        $this->load = clone load_class('Loader');
        $this->load->initialize($this);

        $this->data["userLoggedIn"] = $this->whois();

        // $this->jsFrontEnd = array();

        $this->reqMethod = $this->input->server('REQUEST_METHOD');
        $this->activeModule = $this->router->fetch_module();
        $this->activeClass = $this->router->fetch_class();
        $this->activeMethod = $this->router->fetch_method();
        $this->viewPage = strtolower($this->router->fetch_module()) . '/' . strtolower($this->router->fetch_class()) . '/';
        $this->jsModules = 'js/modules/';

        $tmpUser = $this->userInfo();
        if (!empty($tmpUser["error"]) || $tmpUser["error"] == false) {
            $this->data['userInfo'] = $tmpUser['user'];
        }
        // do_debug($this->data['userInfo']);

        $this->userData = $this->session->userdata(CURRENT_USER);
        $showCleanOrder=false;

        if ($_SERVER["REMOTE_ADDR"]=="127.0.0.1"){
        	$showCleanOrder = true;
		}
            $this->data['showCleanOrder'] = $showCleanOrder;
//		do_debug($this->activeModule);
//		do_debug($this->activeClass);
//		do_debug($this->activeMethod);
//		die();

		if ($this->activeModule == 'tracking' && $this->activeClass == 'tracking') {
            
        }else{
            if ($this->activeModule == 'dashboard' || $this->activeModule == 'auth') {
                if ($this->activeClass != 'auth') {

                    //do_debug($this->data['users']);

                    if (!$this->userData) {
                        redirect(base_url('auth/login', NULL, TRUE));
                    }
                    $this->data['users'] = $this->userData;
                    $this->data['menus'] = $this->loadMenu($this->data['users']);
                } else {

                }
            } else {
                if (!$this->userData) {
                    redirect(base_url('auth/login', NULL, TRUE));
                }
                $this->data['users'] = $this->userData;
                $this->data['menus'] = $this->loadMenu($this->data['users']);
            }
        }
        $this->data['config_company_name'] = COMPANY_NAME;
        /* autoload module items */
        $this->load->_autoloader($this->autoload);
    }

    public function buildDataAttr($arr) {
        if (!empty($arr)) {
            $data_attribute = "";
            foreach ($arr as $key => $value) {
                $data_attribute .= ' data-' . $key . '="' . $value . '" ';
            }
            return $data_attribute;
        } else {
            return null;
        }
    }

    private function loadMenu($users) {
//    	do_debug($users,true);
        $menus = array();
        if ($users->rolename == UROLE_ADMIN && !isBranch($users->isbranch)) {
            $menus = array(
              array(
                "menuTitle" => "Configuration",
                "menuIcon" => "fa-cogs",
                "child" => array(
                  array("menuTitle" => "Companies", "menuUrl" => "administration/company", "menuIcon" => "fa-user"),
                  array("menuTitle" => "Branch Profile", "menuUrl" => "administration/branch/profile", "menuIcon" => "fa-user"),
                  array("menuTitle" => "Services", "menuUrl" => "administration/service", "menuIcon" => "fa-user"),
                  array("menuTitle" => "Customer", "menuUrl" => "administration/customer", "menuIcon" => "fa-user"),
                  array("menuTitle" => "User", "menuUrl" => "administration/user", "menuIcon" => "fa-user"),
                  array("menuTitle" => "Item Stock", "menuUrl" => "administration/item", "menuIcon" => "fa-sticky-note"),
                  array("menuTitle" => "Change Password", "menuUrl" => "administration/change_password", "menuIcon" => "fa-user")
                )
              ), array(
                "menuTitle" => "Transaction",
                "menuIcon" => "fa-sync",
                "child" => array(
                  array("menuTitle" => "Order", "menuUrl" => "transaction/order", "menuIcon" => "fa-user")
                )
              ), array(
                "menuTitle" => "Report",
                "menuIcon" => "fa-book",
                "child" => array(
                  array("menuTitle" => "Order", "menuUrl" => "report/order", "menuIcon" => "fa-user"),
                  array("menuTitle" => "Customer", "menuUrl" => "report/customer", "menuIcon" => "fa-user")
                )
              ),
            );
        } else if ($users->rolename == UROLE_ADMIN && isBranch($users->isbranch)) {
            $menus = array(
              array(
                "menuTitle" => "Configuration",
                "menuIcon" => "fa-cogs",
                "child" => array(
                  array("menuTitle" => "Branch Profile", "menuUrl" => "administration/branch/profile", "menuIcon" => "fa-user"),
                  array("menuTitle" => "User", "menuUrl" => "administration/customer", "menuIcon" => "fa-user"),
                  array("menuTitle" => "Customer", "menuUrl" => "administration/user", "menuIcon" => "fa-user"),
                  array("menuTitle" => "Change Password", "menuUrl" => "administration/change_password", "menuIcon" => "fa-user")
                )
              ), array(
                "menuTitle" => "Transaction",
                "menuIcon" => "fa-sync",
                "child" => array(
                  array("menuTitle" => "Order", "menuUrl" => "transaction/order", "menuIcon" => "fa-user")
                )
              ), array(
                "menuTitle" => "Report",
                "menuIcon" => "fa-book",
                "child" => array(
                  array("menuTitle" => "Order", "menuUrl" => "report/order", "menuIcon" => "fa-user"),
                  array("menuTitle" => "Customer", "menuUrl" => "report/customer", "menuIcon" => "fa-user")
                )
              ),
            );
        } else if ($users->rolename == UROLE_OP && !isBranch($users->isbranch)) {
			$menus = array(
				array(
					"menuTitle" => "Configuration",
					"menuIcon" => "fa-cogs",
					"child" => array(
						array("menuTitle" => "Customer", "menuUrl" => "administration/customer", "menuIcon" => "fa-user"),
						array("menuTitle" => "Change Password", "menuUrl" => "administration/change_password", "menuIcon" => "fa-user")
					)
				), array(
					"menuTitle" => "Transaction",
					"menuIcon" => "fa-sync",
					"child" => array(
						array("menuTitle" => "Order", "menuUrl" => "transaction/order", "menuIcon" => "fa-user")
					)
				)
			);
		} else if ($users->rolename == UROLE_CUSTOMER) {
            $menus = array(
              array(
                "menuTitle" => "Configuration",
                "menuIcon" => "fa-cogs",
                "child" => array(
                  array("menuTitle" => "Change Password", "menuUrl" => "administration/change_password", "menuIcon" => "fa-user"),
                  array("menuTitle" => "My Profile", "menuUrl" => "administration/myprofile", "menuIcon" => "fa-edit")
                )
              ), array(
                "menuTitle" => "Transaction",
                "menuIcon" => "fa-sync",
                "child" => array(
                  array("menuTitle" => "Order", "menuUrl" => "transaction/order", "menuIcon" => "fa-user"),
                  array("menuTitle" => "My Point", "menuUrl" => "transaction/mypoint", "menuIcon" => "fa-user"),
                  array("menuTitle" => "Redeem Point", "menuUrl" => "transaction/redeem", "menuIcon" => "fa-user"),
                )
              )
            );
        }
        return $menus;
    }

    private function whois() {
        $admin = $this->session->userdata(CURRENT_USER);
        if ($admin) {
            return "logged";
        } else {
            return "none";
        }
    }

    public function userInfo($type = "logged") {
        $ci = &get_instance();
        $sessionData = "";

        $sessionData = CURRENT_USER;
        $userLoggedIn = $ci->session->userdata($sessionData);

        if ($userLoggedIn) {
//			$args = array(
//				"condition" => array(
//					"ID" => $userLoggedIn["userID"]
//				)
//			);
//			$rows = $this->common_model->args($args)->table_name(V_USER_ROLE)->do_read();
//			// $rows = $ci->commo->_read($args, 'mininos_users');
//			$rows = $rows[0];
            return array(
              "error" => FALSE,
              "msg" => "",
              "user" => $userLoggedIn
            );
        } else {
            return array(
              "error" => TRUE,
              "msg" => "Tidak ada data.",
              "user" => NULL
            );
        }
    }

	function autonumber($param) {
		$field = $param['field'];
		$table = $param['table'];
		$key = $param['key'];
		$parse = $param['parse'];
		$Digit_Count = $param['digit'];

		$NOL = "0";
		$ci = &get_instance();
		$q = "SELECT " . $field . " FROM " . $table . " WHERE ";
		$q .= $key . " LIKE '" . $parse . "%' ";
		$q .= "ORDER BY " . $key . " DESC LIMIT 1 ";

		$sql = $ci->db->query($q)->result_array();
		$counter = 2;
		if (sizeof($sql) == 0) {
			while ($counter < $Digit_Count):
				$NOL = "0" . $NOL;
				$counter++;
			endwhile;
			return $parse . $NOL . "1";
		} else {
			$R = $sql[0][$field];

			$K = sprintf("%d", substr($R, -$Digit_Count));

			$K = $K + 1;
			$L = $K;
			while (strlen($L) != $Digit_Count) {
				$L = $NOL . $L;
			}
			return $parse . $L;
		}
	}

	public function generateNoFaktur($initial="S")
	{
		$nFaktur = $this->autonumber(array(
			'field' => "order_no",
			'table' => TABLE_ORDER_HEADER,
			'key' => 'order_no',
			'parse' => 'F'.$initial .'-'. date('ym') . '-',
			'digit' => 5,
		));
		return $nFaktur;
	}

    public function __get($class) {
        return CI::$APP->$class;
    }

}
