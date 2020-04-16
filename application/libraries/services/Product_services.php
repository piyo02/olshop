<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product_services
{
  function __construct(){
  }

  public function __get($var)
  {
    return get_instance()->$var;
  }

  public function list_categories() {
    $this->load->model("category_model");

    $categories = $this->category_model->categories()->result();
    foreach ($categories as $key => $category) {
      $list_categories[$category->id] = $category->name;
    }
    return $list_categories;
  }
  
  public function get_table_config( $_page, $start_number = 1 )
  {
    $list_categories = $this->list_categories();
      $table["header"] = array(
        'name' => 'Nama',
        'image' => 'Foto',
        'description' => 'Deskripsi',
      );
      $table["number"] = $start_number;
      $table[ "action" ] = array(
              array(
                "name" => 'Edit',
                "type" => "modal_form_multipart",
                "modal_id" => "edit_",
                "url" => site_url( $_page."edit/"),
                "button_color" => "primary",
                "param" => "id",
                "form_data" => array(
                    "id" => array(
                        'type' => 'hidden',
                        'label' => "id",
                    ),
                    "name" => array(
                        'type' => 'text',
                        'label' => "Nama Produk",
                    ),
                    "image_old" => array(
                      'type' => 'hidden',
                      'label' => "gambar",
                    ),
                    "image" => array(
                      'type' => 'file',
                      'label' => "Foto",
                    ),
                    "category_id" => array(
                      'type' => 'select',
                      'label' => "Kategori",
                      'options' => $list_categories
                    ),
                    "description" => array(
                        'type' => 'textarea',
                        'label' => "Deskripsi",
                    ),
                ),
                "title" => "Product",
                "data_name" => "name",
              ),
              array(
                "name" => 'X',
                "type" => "modal_delete",
                "modal_id" => "delete_",
                "url" => site_url( $_page."delete/"),
                "button_color" => "danger",
                "param" => "id",
                "form_data" => array(
                  "id" => array(
                    'type' => 'hidden',
                    'label' => "id",
                  ),
                  "image_old" => array(
                    'type' => 'hidden',
                    'label' => "gambar",
                  ),
                  "category_id" => array(
                    'type' => 'hidden',
                    'label' => "Kategori",
                  ),
                ),
                "title" => "Product",
                "data_name" => "name",
              ),
    );
    return $table;
  }
  public function validation_config( ){
    $config = array(
        array(
          'field' => 'name',
          'label' => 'name',
          'rules' =>  'trim|required',
        ),
        array(
          'field' => 'description',
          'label' => 'description',
          'rules' =>  'trim|required',
        ),
    );
    
    return $config;
  }
}
?>
