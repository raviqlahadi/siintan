<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends Public_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
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

		//load data cordinat 
		//load data land with image region
		//

		$this->load->model(array('m_land', 'm_image','m_region'));

		$filter =  $this->input->get('filter');
		$key = $this->input->get('get');
		$fetch['select'] = [
			"id", "region_id", "instance", "land_owner",
			"land_status", "description", "document", "status_id"
		];
		$fetch['select_join'] = ['r.name as region_name', 's.name as status_name', 's.color as status_color, k.cordinat as cordinat'];
		$fetch['join'] = [
			array("table" => "table_regions r", "id" => "region_id", "join" => "left", "previx" => "r"),
			array("table" => "table_cordinats k", "id" => "land_id", "join" => "left", "previx" => "k", 'reverse' => true),
			array("table" => "table_status s", "id" => "status_id", "join" => "left", "previx" => "s")

		];
		$fetch['like'] = ($key != null && $key != '') ? array("name" => array('name', 'description'), "key" => $key) : null;
		$fetch['order'] = array("field" => "id", "type" => "ASC");
		$for_table = $this->m_land->fetch($fetch);
		$plot = [];
		foreach ($for_table as $key => $value) {
			$img = $this->m_image->getWhere(array('land_id' => $value->id));
			$arrimg = [];
			foreach ($img as $k => $v) {
				array_push($arrimg, $v->image);
			}
			$value->image = $arrimg;
			array_push($plot, $value->cordinat);
		}

		//var_dump(json_encode($plot));
		$this->data['for_table'] = json_encode($for_table);
		$this->data['filter'] = $filter;
		$this->data['region'] = $this->m_region->get();
		$this->data['plot'] = (isset($plot) && $plot != null) ? json_encode($plot) : null;
		$this->render("public/map", 'public_master');
	}

	public function map_data($filter=null)
	{
		$this->load->model(array('m_land'));


		$key = $this->input->get('get');
		$fetch['select'] = [
			"id", "region_id", "instance", "land_owner",
			"land_status",  "description", "document", "status_id"
		];
		$fetch['select_join'] = [
			'r.name as region_name',
			's.name as status_name',
			's.color as status_color',
			'k.cordinat as cordinat',
			'GROUP_CONCAT(DISTINCT i.image SEPARATOR \', \') as image',
			'GROUP_CONCAT(DISTINCT c.type SEPARATOR \', \') as comp_type',
			'GROUP_CONCAT(DISTINCT c.area SEPARATOR \', \') as comp_area',
			'GROUP_CONCAT(DISTINCT c.price SEPARATOR \', \') as comp_price',
			'GROUP_CONCAT(DISTINCT (c.price*c.area) SEPARATOR \', \') as total_price',
		];
		$fetch['join'] = [
			array("table" => "table_regions r", "id" => "region_id", "join" => "left", "previx" => "r"),
			array("table" => "table_status s", "id" => "status_id", "join" => "left", "previx" => "s"),
			array("table" => "table_cordinats k", "id" => "land_id", "join" => "left", "previx" => "k", 'reverse' => true),
			array("table" => "table_images i", "id" => "land_id", "join" => "left", "previx" => "i", 'reverse' => true),
			array("table" => "table_compensations c", "id" => "land_id", "join" => "left", "previx" => "c", 'reverse' => true)
		];
		$fetch['like'] = ($key != null && $key != '') ? array("name" => array('name', 'description'), "key" => $key) : null;
		$fetch['order'] = array("field" => "id", "type" => "ASC");
		$fetch['group'] = array("field" => "table_lands.id");
		if($filter!=null){
			$fetch['where'] = ['table_lands.region_id'=>$filter];
		}
		$for_table = $this->m_land->fetch($fetch);
		foreach ($for_table as $key => $value) {
			$value->image = str_replace(" ", "", json_encode(explode(",", $value->image)));
		}
		echo json_encode($for_table);
	}
}
