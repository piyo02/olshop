<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'product_model',
			'category_model',
		));
	}
	
	public function index()
	{
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) -  1 ) : 0;
		echo $page; return;
        //pagination parameter
        $pagination['base_url'] = base_url( $this->current_page ) .'/index';
        $pagination['total_records'] = $this->product_model->record_count() ;
        $pagination['limit_per_page'] = 10;
        $pagination['start_record'] = $page*$pagination['limit_per_page'];
        $pagination['uri_segment'] = 4;
		//set pagination
		if ($pagination['total_records'] > 0 ) $this->data['pagination_links'] = $this->setPagination($pagination);

		$categories = $this->category_model->categories()->result();
		$products = $this->product_model->products()->result();
		
		$data = [
			'categories' => $categories,
			'products' => $products,
		];
		$this->load->view("landing_page", $data);
	}

	public function category( $category_id ){
		$categories = $this->category_model->categories()->result();
		$products = $this->product_model->products(0, null, $category_id)->result();
		
		$data = [
			'categories' => $categories,
			'products' => $products,
		];
		$this->load->view("landing_page", $data);
	}
}