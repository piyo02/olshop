<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_Controller {
    private $parent_page = 'home';
	private $current_page = 'home/';

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
		$products = $this->product_model->get_random_product()->result();
		$categories = $this->category_model->categories()->result();

		$data = [
			'products' => $products,
			'categories' => $categories,
		];
		$this->load->view("landing_page", $data);
	}

	public function category( $category_id )
	{
		if( !($category_id) ) redirect(site_url());  
	
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) -  1 ) : 0;
		// echo $page; return;
        //pagination parameter
        $pagination['base_url'] = base_url( $this->current_page ) .'/category/' . $category_id . '/';
        $pagination['total_records'] = count($this->product_model->products( 0, NULL, $category_id )->result());
        $pagination['limit_per_page'] = 9;
        $pagination['start_record'] = $page*$pagination['limit_per_page'];
        $pagination['uri_segment'] = 4;
		#################################################################3

		$products = $this->product_model->products( $pagination['start_record'], $pagination['limit_per_page'], $category_id )->result();
		$categories = $this->category_model->categories()->result();

		$data = [
			'products' => $products,
			'categories' => $categories,
		];

		//set pagination
		if ($pagination['total_records'] > 0 ) $data['pagination_links'] = $this->setPagination($pagination);
		$this->load->view("category", $data);
	}
}