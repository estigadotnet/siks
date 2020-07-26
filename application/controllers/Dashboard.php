<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Dashboard extends CI_Controller {

  public function index() {

    // if (!$this->ion_auth->logged_in()) {
		// 	// redirect them to the login page
		// 	redirect('auth/login', 'refresh');
		// }
    // else {
      $data = array(
        "head" => array(
          "title" => "Dashboard"
        ),
        "title" => "Dashboard",
      );
      $this->load->view("dashboard", $data);
    // }
  }

}
