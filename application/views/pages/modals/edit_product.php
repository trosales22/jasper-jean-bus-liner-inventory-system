<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form id="frmEditProduct" method="POST" action="<?php echo base_url(). 'home/edit_product'; ?>">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>

          <div class="modal-body">
              <div class="row form-group">
                <div class="col-sm-6">
                  <label for="edit_inputProductName">Name</label>
                  <input type="text" class="form-control" id="edit_inputProductName" name="product_name" placeholder="Enter product name.." required readonly>
				</div>

				<div class="col-sm-6">
				  <label for="edit_inputProductAmount">Amount</label>
                  <input type="text" class="form-control" id="edit_inputProductAmount" name="product_amount" placeholder="Enter product amount" required>
				</div>
			  </div>
			  
			  <div class="row form-group">
			  	<div class="col-sm-12">
               		<label for="edit_inputProductDescription">Description</label>
                	<textarea class="form-control" rows="5" id="edit_inputProductDescription" name="product_description" placeholder="Write product description.." style="resize: none;" required></textarea>
				</div>
			  </div>

			  <div class="row form-group">
			  	<div class="col-sm-6">
				  <label for="edit_inputProductQuantity">Quantity</label>
                  <input type="text" class="form-control" id="edit_inputProductQuantity" name="product_quantity" placeholder="Enter product quantity" required>
				</div>

				<div class="col-sm-6">
				  <label for="edit_inputProductSeller">Seller</label>
                  <input type="text" class="form-control" id="edit_inputProductSeller" name="product_seller" placeholder="Enter product seller" required>
				</div>
			  </div>
          </div>
          
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <button class="btn btn-primary" type="submit">Update</button>
          </div>
        </form>
      </div>
    </div>
</div>
