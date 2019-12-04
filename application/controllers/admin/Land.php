<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Land extends Admin_Controller
{

    private $name = null;
    private $parent_page = 'admin';
    private $current_page = 'admin/land';
    private $form_data = null;
    private $data_type = null;
    private $label = null;
    private $block_header = "land management";

    public function __construct()
    {
        parent::__construct();
        $this->name = $this->attribute();
        $this->data_type = $this->data_type();
        $this->label = $this->label();
        $this->form_data = $this->form_data();
        $this->label = $this->label();
        $this->load->model(array('m_land'));
    }


    public function index()
    {
        //basic variable
        $key = $this->input->get('key');
        $limit = $this->input->get('limit');
        $page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
        $tabel_cell =  ["id", "land_owner", "region_name", "status_name"];
        //pagination parameter
        $pagination['base_url'] = base_url($this->current_page) . '/index';
        $pagination['limit_per_page'] = ($limit != null && $limit != '') ? $limit : 10;
        $pagination['start_record'] = $page * $pagination['limit_per_page'];
        $pagination['uri_segment'] = 4;



        //fetch data from database
        //fetch data from database
        $fetch['select'] = ["id", "region_id", "instance", "land_owner",
            "land_status", "compensation_type", "land_area",
            "price", "total_price", "description", "document", "status_id"];
        $fetch['select_join'] = ['r.name as region_name', 's.name as status_name', 's.color as status_color'];
        $fetch['join'] = [
            array("table"=>"table_regions r","id"=>"region_id","join"=>"left","previx"=>"r"),
            array("table" => "table_status s", "id" => "status_id", "join" => "left", "previx" => "s")
        ];
        $fetch['start'] = $pagination['start_record'];
        $fetch['limit'] = $pagination['limit_per_page'];
        $fetch['like'] = ($key != null && $key != '') ? array("name" => array('name', 'description'), "key" => $key) : null;
        $fetch['order'] = array("field" => "id", "type" => "ASC");
        $for_table = $this->m_land->fetch($fetch);

        $pagination['total_records'] =  $this->m_land->fetch($fetch, true);
        
        //set pagination
        //var_dump($pagination);
        if ($pagination['total_records'] > 0) $this->data['links'] = $this->setPagination($pagination);

        //set breadcrumb
        $this->data['breadcrumb'] = $this->setBreadcrumb();

        //get flashdata
        $alert = $this->session->flashdata('alert');
        $this->data["key"] = ($key != null && $key != '') ? $key : false;
        $this->data["alert"] = (isset($alert)) ? $alert : NULL;
        $this->data["for_table"] = $for_table;
        $this->data["table_header"] = $this->tabel_header($tabel_cell);
        $this->data["total_data"] = $pagination['total_records'];
        $this->data["number"] = $pagination['start_record'];
        $this->data['parent_page'] = $this->parent_page;
        $this->data["current_page"] = $this->current_page;
        $this->data["block_header"] = $this->block_header;
        $this->data["header"] = "TABLE GRUP";
        $this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';


        $this->render("admin/land/content");
    }


    public function create()
    {
        if ($this->input->post() != null) {
            $this->form_validation->set_rules($this->validation_config());
            if ($this->form_validation->run() === TRUE) {
                $input_data = $this->input->post();
                $this->load->library('upload');
                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'jpg|jpeg|png|pdf|doc|docx';
                $config['max_size']             = 10000;
                $config['max_width']            = 10240;
                $config['max_height']           = 10240;

                $this->load->library('upload');
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('document')) {
                    $alert = $this->upload->display_errors();
                    $this->data['alert'] = $this->alert->set_alert(Alert::WARNING, $alert);
                    $form = $this->form_data();
                } else {
                    $upload_data = $this->upload->data();
                    $input_data['document'] = $upload_data['file_name'];
                    $insert = $this->insert($input_data);
                    if ($insert) {
                        $this->session->set_flashdata('alert', $this->alert->set_alert(Alert::SUCCESS, 'Input data berhasil'));
                        redirect($this->current_page);
                    } else {
                        $form = $this->form_data();
                    }
                }
            } else {
                $alert = $this->errorValidation(validation_errors());
                $this->data['alert'] = $this->alert->set_alert(Alert::WARNING, $alert);
                $form = $this->form_data();
            }
        } else {
            $form = $this->form_data;
        }
        $this->data['breadcrumb'] = $this->setBreadcrumb();
        $this->data['form_data'] = $form;
        $this->data['form_action'] = site_url($this->current_page . '/create');
        $this->data['name'] = $this->name;
        $this->data['parent_page'] = $this->current_page;
        $this->data["block_header"] = $this->block_header;
        $this->data["header"] = "Tambah land";
        $this->data["sub_header"] = 'Tekan Tombol Simpan Ketika Selesai Mengisi Form';
        $this->render("admin/land/create");
    }

    public function insert($data)
    {
        $insert = $this->m_land->add($data);
        return $insert;
    }

    public function edit($id = null)
    {
        if ($id == null) {
            redirect($this->current_page);
        }
        $w['id'] = $id;
        $form_value = $this->m_land->getWhere($w);
        if ($form_value == false) {
            redirect($this->current_page);
        } else {
            $form_value = $form_value[0];
        }

        if ($this->input->post() != null) {
            $this->form_validation->set_rules($this->validation_config(true));
            if ($this->form_validation->run() === TRUE) {
                $input_data = $this->input->post();
                $update = $this->update($id, $input_data);
                if ($update) {
                    $this->session->set_flashdata('alert', $this->alert->set_alert(Alert::SUCCESS, 'Update data berhasil'));
                    redirect($this->current_page);
                } else {
                    $form = $this->form_data();
                }
            } else {
                $alert = $this->errorValidation(validation_errors());
                $this->data['alert'] = $this->alert->set_alert(Alert::WARNING, $alert);
                $form = $this->form_data();
            }
        } else {
            $form = $this->form_data($form_value);
        }


        $this->data['breadcrumb'] = $this->setBreadcrumb();
        $this->data['form_data'] = $form;
        $this->data['form_action'] = site_url($this->current_page . '/edit/' . $id);
        $this->data['name'] = $this->name;
        $this->data['parent_page'] = $this->current_page;
        $this->data["block_header"] = $this->block_header;
        $this->data["header"] = "Ubah land";
        $this->data["sub_header"] = 'Silahkan ubah data yang ingin anda ganti';
        $this->render("admin/land/edit");
    }

    public function update($id, $data)
    {
        $insert = $this->m_land->update($id, $data);
        return $insert;
    }


    public function detail($id = null)
    {
        if ($id == null) {
            redirect($this->current_page);
        }
        $w['id'] = $id;
        $form_value = $this->m_land->getWhere($w);
        if ($form_value == false) {
            redirect($this->current_page);
        } else {
            $form_value = $form_value[0];
        }

        $this->data['breadcrumb'] = $this->setBreadcrumb();
        $this->data['form_data'] = $this->form_data($form_value);
        $this->data['parent_page'] = $this->current_page;
        $this->data['name'] = $this->name;
        $this->data['detail'] = true;
        $this->data["block_header"] = $this->block_header;
        $this->data["header"] = "Detail land";
        $this->data["sub_header"] = 'Halaman Ini Hanya Berisi Informasi Detail Dari Data';
        $this->render("admin/land/detail");
    }

    public function delete($id)
    {
        if ($id == null) {
            redirect($this->current_page);
        }
        $w['id'] = $id;
        $delete = $this->m_land->delete($w);
        if ($delete != false) {
            $this->session->set_flashdata('alert', $this->alert->set_alert(Alert::SUCCESS, 'Delete data berhasil'));
            redirect($this->current_page);
        } else {
            $this->session->set_flashdata('alert', $this->alert->set_alert(Alert::WARNING, 'Terjadi Kesalahan'));
            redirect($this->current_page);
        }
    }

    public function ploting($id){
        $this->data['breadcrumb'] = $this->setBreadcrumb();
        $this->data['parent_page'] = $this->current_page;
        $this->data["block_header"] = $this->block_header;
        $this->data["header"] = "Ubah land";
        $this->data["sub_header"] = 'Silahkan ubah data yang ingin anda ganti';
        $this->render("admin/land/ploting");
    }

    private function attribute()
    {
        return [
            "id", "region_id", "instance", "land_owner",
            "land_status", "compensation_type", "land_area",
            "price", "total_price", "description", "document", "status_id"
        ];
    }

    private function label()
    {
        $name = $this->name;
        $label = [
            "id", "kawasan", "instansi", "pemilik lahan",
            "status lahan", "tipe konpensasi", "luas tanah (m2)",
            "harga satuan(rp)", "total harga", "keterangan", "berkas", "status"
        ];
        $label_arr = array();
        foreach ($name as $key => $value) {
            $label_arr[$value] = $label[$key];
        }
        $label_arr['region_name'] = 'kawasan';
        $label_arr['status_name'] = 'status';
        return $label_arr;
    }

    private function data_type()
    {
        $name = $this->name;
        $type =   [
            "number", "select", "text", "text",
            "text", "text", "number",
            "number", "number", "textarea", "file", "select"
        ];
        $type_arr = array();
        foreach ($name as $key => $value) {
            $type_arr[$value] = $type[$key];
        }
        return $type_arr;
    }

    private function validation_config($edit = false)
    {
        $arr_con = [];
        $name = $this->name;
        unset($name[0]);
        foreach ($name as $key => $value) {
            switch ($value) {
                case 'document':
                    $arr = array(
                        'field' => $value,
                        'label' => $this->label[$value],
                        'rules' =>  'trim',
                        'errors' => array(
                            'required' => 'Field %s tidak boleh kosong  .',
                        )
                    );
                break;
                default:
                    $arr = array(
                        'field' => $value,
                        'label' => $this->label[$value],
                        'rules' =>  'trim|required',
                        'errors' => array(
                            'required' => 'Field %s tidak boleh kosong  .',
                        )
                    );
                    break;
            }
            array_push($arr_con, $arr);
        }

        return $arr_con;
    }

    private function form_data($form_value = null)
    {


        $select['region_id'] = $this->getRegionList();
        $select['status_id'] = $this->getStatusList();
        $name = $this->name;
        unset($name[0]);
        foreach ($name as $key => $value) {
            if ($form_value != null) {
                $val = $form_value->{$value};
            } else {
                $val = $this->form_validation->set_value($value);
            }
            switch ($this->data_type[$value]) {
                case 'select':
                    $data[$value] = array(
                        'name' => $value,
                        'label' => $value,
                        'id' => $value,
                        'type' => $this->data_type[$value],
                        'placeholder' => $this->label[$value],
                        'option' => $select[$value],
                        'class' => 'form-control show-tick',
                        'data-live-search' => "true",
                        'value' => $val,
                    );
                    break;

                default:
                    $data[$value] = array(
                        'name' => $value,
                        'label' => $value,
                        'id' => $value,
                        'type' => $this->data_type[$value],
                        'placeholder' => $this->label[$value],
                        'class' => 'form-control',
                        'value' => $val,
                    );
                    break;
            }
        };


        return $data;
    }

    private function tabel_header($arr)
    {
        $label = [];
        foreach ($arr as $key => $value) {
            $label[$value] = $this->label[$value];
        }
        if (isset($label['id'])) unset($label['id']);
        return $label;
    }

    private function getRegionList()
    {
        $this->load->model(array('m_region'));
        $all_type =  $this->m_region->get();
        $arr = [];
        foreach ($all_type as $key => $value) {
            $arr[$value->id] = $value->name;
        }
        return $arr;
    }

    private function getStatusList()
    {   
        
        $this->load->model(array('m_status'));
        $all_type =  $this->m_status->get();
        $arr = [];
        foreach ($all_type as $key => $value) {
            $arr[$value->id] = $value->name;
        }
        return $arr;
    }
}
