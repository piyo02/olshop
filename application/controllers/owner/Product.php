<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends Owner_Controller {
	private $services = null;
    private $name = null;
    private $parent_page = 'owner';
	private $current_page = 'owner/product/';
	
	public function __construct(){
		parent::__construct();
		$this->load->library('services/Product_services');
		$this->services = new Product_services;
		$this->load->model(array(
			'product_model',
		));
		$this->data["menu_list_id"] = "category_index";
	}
	public function index( $category_id = NULL )
	{
		if( !($category_id) ) redirect(site_url( "owner/category" ));  
	
		$page = ($this->uri->segment(4 + 1)) ? ($this->uri->segment(4 + 1) -  1 ) : 0;
		// echo $page; return;
        //pagination parameter
        $pagination['base_url'] = base_url( $this->current_page ) .'/index/' . $category_id . '/';
        $pagination['total_records'] = $this->product_model->record_count() ;
        $pagination['limit_per_page'] = 10;
        $pagination['start_record'] = $page*$pagination['limit_per_page'];
        $pagination['uri_segment'] = 4 + 1;
		//set pagination
		if ($pagination['total_records'] > 0 ) $this->data['pagination_links'] = $this->setPagination($pagination);
		#################################################################3
		$table = $this->services->get_table_config( $this->current_page, ($pagination['start_record']+1) );
		$table[ "rows" ] = $this->product_model->products( $pagination['start_record'], $pagination['limit_per_page'], $category_id )->result();
		$table = $this->load->view('templates/tables/plain_table_image', $table, true);
		$this->data[ "contents" ] = $table;
		$add_menu = array(
			"name" => "Tambah Produk",
			"modal_id" => "add_product_",
			"button_color" => "primary",
			"url" => site_url( $this->current_page."add/"),
			"form_data" => array(
				"name" => array(
					'type' => 'text',
					'label' => "Nama Produk",
					'value' => "",
				),
				"price" => array(
					'type' => 'text',
					'label' => "Harga",
					'value' => "",
				),
				"category_id" => array(
					'type' => 'hidden',
					'label' => "category_id",
					'value' => $category_id,
				),
				"image" => array(
					'type' => 'file',
					'label' => "Foto",
				),
				"description" => array(
					'type' => 'textarea',
					'label' => "Deskripsi",
					'value' => "-",
				),
			),
			'data' => NULL
		);

		$add_menu= $this->load->view('templates/actions/modal_form_multipart', $add_menu, true ); 

		$this->data[ "header_button" ] =  $add_menu;
		// return;
		#################################################################3
		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Produk";
		$this->data["header"] = "Daftar Produk";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
		$this->render( "templates/contents/plain_content" );
	}


	public function add(  )
	{
		$category_id = $this->input->post('category_id');
		if( !($_POST) ) redirect(site_url(  $this->current_page ) . 'index/' . $category_id );  

		// echo var_dump( $data );return;
		$this->form_validation->set_rules( $this->services->validation_config() );
        if ($this->form_validation->run() === TRUE )
        {
			$data['name'] = $this->input->post( 'name' );
			$data['price'] = $this->input->post( 'price' );
			$data['category_id'] = $category_id;
			$data['image'] = $this->upload_image( $category_id );
			$data['description'] = $this->input->post( 'description' );

			if( $this->product_model->create( $data ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->product_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->product_model->errors() ) );
			}
		}
        else
        {
          $this->data['message'] = (validation_errors() ? validation_errors() : ($this->m_account->errors() ? $this->product_model->errors() : $this->session->flashdata('message')));
          if(  validation_errors() || $this->product_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
		}
		
		redirect( site_url($this->current_page) . 'index/' . $category_id );
	}

	public function edit(  )
	{
		$category_id = $this->input->post('category_id');
		if( !($_POST) ) redirect(site_url(  $this->current_page ) . 'index/' . $category_id );  

		// echo var_dump( $data );return;
		$this->form_validation->set_rules( $this->services->validation_config() );
        if ($this->form_validation->run() === TRUE )
        {
			$data['name'] = $this->input->post( 'name' );
			$data['category_id'] = $category_id;
			$data['description'] = $this->input->post( 'description' );
			
			if($_FILES['image']['name']){
				$data['image'] = $this->upload_image( $category_id );
			}

			$data_param['id'] = $this->input->post( 'id' );

			if( $this->product_model->update( $data, $data_param  ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->product_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->product_model->errors() ) );
			}
		}
        else
        {
          $this->data['message'] = (validation_errors() ? validation_errors() : ($this->m_account->errors() ? $this->product_model->errors() : $this->session->flashdata('message')));
          if(  validation_errors() || $this->product_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
		}
		
		redirect( site_url($this->current_page) . 'index/' . $category_id );
	}

	public function delete(  ) {
		$category_id = $this->input->post('category_id');
		if( !($_POST) ) redirect( site_url($this->current_page) . 'index/' . $category_id );
	  
		$path = './uploads/product/';
		$data_param['id'] 	= $this->input->post('id');
		if( $this->product_model->delete( $data_param ) ){
			if(NULL !== $this->input->post('image_old')){
				if($this->input->post('image_old') != 'default.jpg')
					@unlink( $path.$this->input->post('image_old') );
			}
		  $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->product_model->messages() ) );
		}else{
		  $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->product_model->errors() ) );
		}
		redirect( site_url($this->current_page) . 'index/' . $category_id );
	}

	public function upload_image( $category_id )
	{
		$upload = $this->config->item('upload', 'ion_auth');
		$file = $_FILES[ 'image' ];
		$upload_path = 'uploads/product/';

		$config 				= $upload;
		$config['file_name'] 	=  'PRODUCT_' . $category_id . "__" . time();
		$config['upload_path']	= './' . $upload_path;
		// var_dump($file['name']); die;
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload( 'image' ) )
		{
			// $this->set_error( $this->upload->display_errors() );
			// $this->set_error( 'upload_unsuccessful' );
			return FALSE;
		}
		else
		{
			if(NULL !== $this->input->post('image_old')){
				if($this->input->post('image_old') != 'default.jpg')
					@unlink( $config['upload_path'].$this->input->post('image_old') );
			}
			$file_data = $this->upload->data();
			return $file_data['file_name'];
		}
	}
}