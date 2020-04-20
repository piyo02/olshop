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
}