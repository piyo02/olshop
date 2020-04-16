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
		$category_id = ($this->input->get('search')) ? $this->input->get('search') : NULL;
		$page = ($this->uri->segment(4-1)) ? ($this->uri->segment(4-1) -  1 ) : 0;
		// echo $page; return;
        //pagination parameter
        $pagination['base_url'] = base_url( $this->current_page ) .'/index';
        $pagination['total_records'] = count($this->product_model->products( 0, NULL, $category_id )->result());
        $pagination['limit_per_page'] = 9;
        $pagination['start_record'] = $page*$pagination['limit_per_page'];
        $pagination['uri_segment'] = 4-1;

		$categories = $this->category_model->categories()->result();
		$products = $this->product_model->products( $pagination['start_record'], $pagination['limit_per_page'], $category_id )->result();
		
		foreach ($categories as $key => $category) {
			$list_categories[$category->id] = $category->name;			
		}
		$data = [
			'list_categories' => $list_categories,
			'products' => $products,
			'search' => $category_id
		];

		//set pagination
		if ($pagination['total_records'] > 0 ) $data['pagination_links'] = $this->setPagination($pagination);

		$this->load->view("landing_page", $data);
	}

	public function category( $category_id ){
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) -  1 ) : 0;
		// echo $page; return;
        //pagination parameter
        $pagination['base_url'] = base_url( $this->current_page ) .'/index';
        $pagination['total_records'] = $this->product_model->record_count() ;
        $pagination['limit_per_page'] = 10;
        $pagination['start_record'] = $page*$pagination['limit_per_page'];
        $pagination['uri_segment'] = 4;
		//set pagination
		if ($pagination['total_records'] > 0 ) $data['pagination_links'] = $this->setPagination($pagination);


		$categories = $this->category_model->categories()->result();
		$products = $this->product_model->products( $pagination['start_record'], $pagination['limit_per_page'], $category_id)->result();
		
		$data = [
			'categories' => $categories,
			'products' => $products,
		];
		$this->load->view("landing_page", $data);
	}
}