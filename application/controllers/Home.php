<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_Controller {

	function __construct(){
		parent::__construct();
	}

	public function index(){
		// TODO : tampilkan landing page bagi user yang belum daftar
		$this->render("public/home", 'public_master');
	}

	public function profile()
	{
		// TODO : tampilkan landing page bagi user yang belum daftar
		$this->render("public/profile", 'public_master');
	}

	public function map()
	{
		// TODO : tampilkan landing page bagi user yang belum daftar
		$this->render("public/map", 'public_master');
	}
}
