<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Map extends Admin_Controller {
       
        private $parent_page = 'admin';
        private $current_page = 'admin/map';
        private $block_header = "peta persebaran";
        public function index()
        {
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