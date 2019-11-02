<?php
class Home_model extends CI_Model {
	public function get_products($product_name = NULL){
		$where_condition = '';
		if(!empty($product_name)){
			$where_condition .= "WHERE A.product_name = '" . $product_name . "'";
		}

		$query = "
			SELECT 
				A.product_id, A.product_name, A.product_description, 
				A.product_amount, B.quantity as product_quantity, 
				A.product_seller, DATE_FORMAT(A.product_date_added, '%M %d, %Y %r') as product_date_added 
			FROM 
				products A
			LEFT JOIN 
				product_qty B ON A.product_id = B.product_id $where_condition
			";

		$stmt = $this->db->query($query);
		return $stmt->result();
	}

	public function add_product(array $product_params){
		try{
			$products_fields = array(
				'product_name'			=> $product_params['product_name'],
				'product_description'	=> $product_params['product_description'],
				'product_amount'		=> $product_params['product_amount'],
				'product_seller'		=> $product_params['product_seller']
			);
	
			$this->db->insert('products', $products_fields);
			$lastInsertedId = $this->db->insert_id();
			
			$product_qty_fields = array(
				'product_id'	=> $lastInsertedId,
				'quantity'		=> $product_params['product_quantity']
			);
			
			$this->db->insert('product_qty', $product_qty_fields);
		}catch(PDOException $e){
			$msg = $e->getMessage();
			$this->db->trans_rollback();
		}
	}

	public function get_orders($order_id = NULL){
		$where_condition = '';
		if(!empty($order_id)){
			$where_condition .= "WHERE A.order_id = '" . $order_id . "'";
		}

		$query = "
			SELECT 
				A.order_id, A.order_name, A.order_product, 
				A.order_bus, B.product_name, A.order_quantity, 
				REPLACE(B.product_amount, ',', '') * REPLACE(A.order_quantity, ',', '') as order_total_amount,  
				DATE_FORMAT(A.order_date_added, '%M %d, %Y %r') as order_date_added 
			FROM 
				orders A
			LEFT JOIN 
				products B ON A.order_product = B.product_id $where_condition
			";

		$stmt = $this->db->query($query);
		return $stmt->result();
	}

	public function add_order(array $order_params){
		try{
			$this->db->insert('orders', $order_params);
			$lastInsertedId = $this->db->insert_id();
		}catch(PDOException $e){
			$msg = $e->getMessage();
			$this->db->trans_rollback();
		}
	}
}
