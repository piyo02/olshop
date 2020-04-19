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
		$categories = $this->category_model->categories()->result();
		foreach ($categories as $key => $category) {
			$list_products[$category->name] = $this->product_model->products( 0, NULL, $category->id )->result();
		}

		$data = [
			'list_products' => $list_products,
		];
		$this->load->view("landing_page", $data);
	}
}