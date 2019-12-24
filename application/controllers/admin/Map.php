<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Map extends Admin_Controller {
       
        private $parent_page = 'admin';
        private $current_page = 'admin/map';
        private $block_header = "peta persebaran";
        public function index()
        {
            $this->load->model(array('m_land'));
            
            
            $key = $this->input->get('get');
            $fetch['select'] = [
                "id", "region_id", "instance", "land_owner",
                "land_status", "compensation_type", "land_area",
                "price", "total_price", "description", "document", "status_id"
            ];
            $fetch['select_join'] = ['r.name as region_name', 's.name as status_name', 's.color as status_color, k.cordinat as cordinat'];
            $fetch['join'] = [
                array("table" => "table_regions r", "id" => "region_id", "join" => "left", "previx" => "r"),
                array("table" => "table_status s", "id" => "status_id", "join" => "left", "previx" => "s"),
                array("table" => "table_cordinats k", "id" => "land_id", "join" => "left", "previx" => "k",'reverse'=>true)
            ];
            $fetch['like'] = ($key != null && $key != '') ? array("name" => array('name', 'description'), "key" => $key) : null;
            $fetch['order'] = array("field" => "id", "type" => "ASC");
            $for_table = $this->m_land->fetch($fetch);
            $this->data['map_data'] = $for_table;
            $this->data['breadcrumb'] = $this->setBreadcrumb();
            $this->data['parent_page'] = $this->parent_page;
            $this->data["current_page"] = $this->current_page;
            $this->data["block_header"] = $this->block_header;
            $this->data["header"] = "TABLE GRUP";
            $this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
            $this->render("admin/map/map");
        }
    
    }

    
    
    /* End of file Maps.php */
    
?>