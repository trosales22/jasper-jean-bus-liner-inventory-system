<?php
class Home_model extends CI_Model {
	private function _add_to_logs($msg){
		try{
			$logs_fields = array(
				'log_msg'			=> $msg
			);
			
			$this->db->insert('activity_logs', $logs_fields);
			$lastInsertedId = $this->db->insert_id();
		}catch(PDOException $e){
			$msg = $e->getMessage();
			$this->db->trans_rollback();
		}
	}

	public function get_activity_logs($log_id = NULL){
		$query = "
			SELECT 
				log_id, log_msg, DATE_FORMAT(log_datetime, '%M %d, %Y %r') as log_datetime 
			FROM 
				activity_logs 
			ORDER BY 
				log_id DESC
			";

		$stmt = $this->db->query($query);
		return $stmt->result();
	}

	public function get_products($product_id = NULL, $product_name = NULL){
		$where_condition = '';

		if(!empty($product_id)){
			$where_condition .= "AND A.product_id = '" . $product_id . "'";
		}

		if(!empty($product_name)){
			$where_condition .= "AND A.product_name = '" . $product_name . "'";
		}
		
		$query = "
			SELECT 
				A.product_id, A.product_name, A.product_description, 
				A.product_amount, B.quantity as product_quantity, 
				A.product_seller, DATE_FORMAT(A.product_date_added, '%M %d, %Y %r') as product_date_added 
			FROM 
				products A
			LEFT JOIN 
				product_qty B ON A.product_id = B.product_id WHERE A.product_active_flag = 'Y' $where_condition
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
			$this->_add_to_logs($product_params['product_name'] . ' has been added to products.');
		}catch(PDOException $e){
			$msg = $e->getMessage();
			$this->db->trans_rollback();
		}
	}

	public function edit_product(array $product_params){
		try{
			$product_details = $this->get_products($product_params['product_id'], NULL);

			$products_fields = array(
				'product_name'			=> $product_params['product_name'],
				'product_description'	=> $product_params['product_description'],
				'product_amount'		=> $product_params['product_amount'],
				'product_seller'		=> $product_params['product_seller']
			);
			
			$this->db->where('product_id', $product_params['product_id']);
			$this->db->update('products', $products_fields);
			
			$product_qty_fields = array(
				'quantity'		=> $product_params['product_quantity']
			);
			
			$this->db->where('product_id', $product_params['product_id']);
			$this->db->update('product_qty', $product_qty_fields);

			$this->_add_to_logs($product_details[0]->product_name . ' details has been modified.');
		}catch(PDOException $e){
			$msg = $e->getMessage();
			$this->db->trans_rollback();
		}
	}

	public function delete_product($product_id){
        try {
			$product_details = $this->get_products($product_id, NULL);

            $order_params = array('product_active_flag' => 'N');
            $this->db->where('product_id', $product_id);
			$this->db->update('products', $order_params);
			$this->_add_to_logs($product_details[0]->product_name . ' has been deleted.');
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
				A.order_bus, B.product_name, A.order_quantity, A.order_status,
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
			$product_details = $this->get_products($order_params['order_product'], NULL);

			$this->db->insert('orders', $order_params);
			$lastInsertedId = $this->db->insert_id();
			$this->_add_to_logs($order_params['order_name'] . ' ordered ' . $product_details[0]->product_name . ' for ' . $order_params['order_bus'] . '.');
		}catch(PDOException $e){
			$msg = $e->getMessage();
			$this->db->trans_rollback();
		}
	}

	public function approve_pending_order($order_id){
		try{
			//update pending order
			$order_params = array('order_status' => 'APPROVED');
			$this->db->where('order_id', $order_id);
			$this->db->update('orders', $order_params);

			//update qty of product
			$order_details = $this->get_orders($order_id);
			$product_details = $this->get_products($order_details[0]->order_product, NULL);
			
			// print "<pre>";
			// print_r($order_details);
			// die(print_r($product_details));
			
			$order_params = array('quantity' => $product_details[0]->product_quantity - $order_details[0]->order_quantity);
			$this->db->where('product_id', $product_details[0]->product_id);
			$this->db->update('product_qty', $order_params);

			$this->_add_to_logs('Order ID #' . $order_id . ' has been approved.');
		}catch(Exception $e){
			$msg = $e->getMessage();
			$this->db->trans_rollback();
		}
	}

	public function decline_pending_order($order_id){
        try {
			$this->db->delete('orders', array('order_id' => $order_id));
			$this->_add_to_logs('Order ID #' . $order_id . ' has been declined.');
        }catch(PDOException $e){
			$msg = $e->getMessage();
			$this->db->trans_rollback();
		}
	}
}
