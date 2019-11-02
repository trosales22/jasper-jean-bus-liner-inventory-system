<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct() {
		parent::__construct();
		
		$this->load->helper('url', 'form');
		$this->load->library('session');
		$this->load->database();
		$this->load->model('Home_model', 'home_model');
	}
	
  	public function index() {
		$this->data['products'] = $this->home_model->get_products();
    	$this->load->view('home_page', $this->data);
	}

	public function add_product(){
		try{
			$success       			= 0;
			$product_name 			= trim($this->input->post('product_name'));
			$product_description 	= trim($this->input->post('product_description'));
			$product_amount 		= trim($this->input->post('product_amount'));
			$product_quantity 		= trim($this->input->post('product_quantity'));
			$product_seller 		= trim($this->input->post('product_seller'));
			
			if(EMPTY($product_name))
				throw new Exception("Product Name is required.");

			if(EMPTY($product_description))
				throw new Exception("Product Description is required.");

			if(EMPTY($product_amount))
				throw new Exception("Product Amount is required.");

			if(EMPTY($product_quantity))
				throw new Exception("Product Quantity is required.");

			if(EMPTY($product_seller))
				throw new Exception("Product Seller is required.");

			$does_product_exist = $this->home_model->get_products($product_name);

			if(!empty($does_product_exist)){
				throw new Exception("Product exists. Please try again!");
			}

			$product_params = array(
				'product_name'			=> $product_name,
				'product_description'	=> $product_description,
				'product_amount'		=> $product_amount,
				'product_quantity'		=> $product_quantity,
				'product_seller'		=> $product_seller,
			);

			$this->home_model->add_product($product_params);
			
			$success  = 1;
		}catch (Exception $e){
			$msg = $e->getMessage();      
		}

		if($success == 1){
			$response = [
				'msg'       => 'Product was successfully added!',
				'flag'      => $success
			];
		}else{
			$response = [
				'msg'       => $msg,
				'flag'      => $success
			];
		}

		echo json_encode($response);
	}
}
