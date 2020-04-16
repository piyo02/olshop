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