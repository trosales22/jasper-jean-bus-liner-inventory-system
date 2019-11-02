<div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form id="frmAddOrder" method="POST" action="<?php echo base_url(). 'home/add_order'; ?>">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Order</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>

          <div class="modal-body">
              <div class="row form-group">
                <div class="col-sm-6">
                  <label for="inputOrderName">Name</label>
                  <input type="text" class="form-control" id="inputOrderName" name="order_name" placeholder="Enter order name.." required>
				</div>

				<div class="col-sm-6">
					<label for="cmbProduct">Product</label>
					<select name="order_product" id="cmbProduct" class="form-control" required>
					<option disabled="disabled" selected="selected">Choose Product</option>
					<?php foreach($products as $product){?>
						<option value="<?php echo $product->product_id;?>"><?php echo $product->product_name;?></option>
					<?php }?>
                  </select>
				</div>
			  </div>
			  
			  <div class="row form-group">
			  	<div class="col-sm-6">
				  <label for="inputOrderQuantity">Quantity</label>
                  <input type="text" class="form-control" id="inputOrderQuantity" name="order_quantity" placeholder="Enter order quantity" required>
				</div>

				<div class="col-sm-6">
				  <label for="inputOrderBus">Bus</label>
                  <input type="text" class="form-control" id="inputOrderBus" name="order_bus" placeholder="Enter bus" required>
				</div>
			  </div>
          </div>
          
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <button class="btn btn-primary" type="submit">Submit</button>
          </div>
        </form>
      </div>
    </div>
</div>
