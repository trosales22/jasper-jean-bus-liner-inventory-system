<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="<?php echo base_url(); ?>static/images/jasper_jean.ico"/>
  <meta name="description" content="Jasper Jean - We Transport People.">
  <meta name="author" content="Tristan Rosales">

  <title>Jasper Jean Bus Liner - Dashboard</title>

  <!-- Custom fonts for this template -->
  <link href="<?php echo base_url(); ?>static/SBAdmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="<?php echo base_url(); ?>static/SBAdmin/css/sb-admin-2.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>static/SBAdmin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.css">
	<link href="<?php echo base_url(); ?>static/css/parsley.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>static/js/libraries/jquery-confirm-v3.3.4/dist/jquery-confirm.min.css" rel="stylesheet">
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

		<?php include 'pages/sidebar.php';?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

				<?php include 'pages/topbar.php';?>
				
        <!-- Begin Products -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Products</h1>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <a class="btnAddProduct btn btn-dark btn-icon-split" href="#" data-toggle="modal" data-target="#addProductModal">
                <span class="icon text-white-50">
                  <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Add Product</span>
              </a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="tbl_products" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Description</th>
											<th>Quantity</th>
											<th>Amount</th>
											<th>Seller</th>
											<th>Date Added</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  
                  <tbody>
									<?php foreach($products as $product){?>
											<tr>
												<td><?php echo $product->product_name;?></td>
												<td><?php echo $product->product_description;?></td>
												<td><?php echo $product->product_quantity;?></td>
												<td><?php echo '₱' . $product->product_amount;?></td>
												<td><?php echo $product->product_seller;?></td>
												<td><?php echo $product->product_date_added;?></td>
												<td>
													<a style="width: 100%; margin-bottom: 8px; cursor: pointer; color: white;" data-toggle="modal" data-id="<?php echo $product->product_id;?>" data-target="#editProductModal" class="btnEditProduct btn btn-info btn-icon-split">
														<span class="icon text-white-50" style="margin-right: auto;">
															<i class="fas fa-edit"></i>
														</span>
														<span class="text" style="margin-right: auto;">Edit Product</span>
													</a>

													<a style="width: 100%; cursor: pointer; color: white;" data-toggle="modal" data-id="<?php echo $product->product_id;?>" data-target="#deleteProductModal" class="btnDeleteProduct btn btn-danger btn-icon-split">
														<span class="icon text-white-50" style="margin-right: auto;">
															<i class="fas fa-trash"></i>
														</span>
														<span class="text" style="margin-right: auto;">Delete Product</span>
													</a>
												</td>
											</tr> 
                     <?php }?>
                  </tbody>

                  <tfoot>
                    <tr>
											<th>Name</th>
                      <th>Description</th>
											<th>Quantity</th>
											<th>Amount</th>
											<th>Seller</th>
											<th>Date Added</th>
                      <th>Actions</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
				<!-- End Products -->
				
				<!-- Begin Orders -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Orders</h1>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <a class="btnAddOrder btn btn-dark btn-icon-split" href="#" data-toggle="modal" data-target="#addOrderModal">
                <span class="icon text-white-50">
                  <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Add Order</span>
              </a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="tbl_orders" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Product</th>
											<th>Quantity</th>
											<th>Total Amount</th>
											<th>Bus</th>
											<th>Date Ordered</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  
                  <tbody>
										<?php foreach($orders as $order){?>
											<tr>
												<td><?php echo $order->order_name;?></td>
												<td><?php echo $order->product_name;?></td>
												<td><?php echo $order->order_quantity;?></td>
												<td><?php echo '₱' . number_format($order->order_total_amount, 2);?></td>
												<td><?php echo $order->order_bus;?></td>
												<td><?php echo $order->order_date_added;?></td>
												<td>
													<?php if($order->order_status == 'PENDING'){ ?>
													<a style="width: 100%; cursor: pointer; color: white;" data-id="<?php echo $order->order_id;?>" class="btnApproveOrder btn btn-info btn-icon-split">
														<span class="icon text-white-50" style="margin-right: auto;">
															<i class="fas fa-check"></i>
														</span>
														<span class="text" style="margin-right: auto;">Approve Order</span>
													</a>
													<?php }else{
														echo "<strong>ALREADY APPROVED</strong>";
													} ?>
												</td>
											</tr> 
                     <?php }?>
                  </tbody>

                  <tfoot>
                    <tr>
											<th>Name</th>
                      <th>Product</th>
											<th>Quantity</th>
											<th>Total Amount</th>
											<th>Bus</th>
											<th>Date Ordered</th>
                      <th>Actions</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- End Orders -->

      </div>
      <!-- End of Main Content -->

      <?php include 'pages/footer.php';?>

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
	</a>

	<?php include 'pages/modals/add_product.php';?>
	
	<?php include 'pages/modals/add_order.php';?>
	
	<?php include 'pages/modals/logout.php';?>
	
  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url(); ?>static/SBAdmin/vendor/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>static/SBAdmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url(); ?>static/SBAdmin/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url(); ?>static/SBAdmin/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="<?php echo base_url(); ?>static/SBAdmin/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>static/SBAdmin/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
	<script src="<?php echo base_url(); ?>static/SBAdmin/js/demo/datatables-demo.js"></script>
	<script src="https://parsleyjs.org/dist/parsley.min.js"></script>
	<script src="<?php echo base_url(); ?>static/js/libraries/jquery-confirm-v3.3.4/js/jquery-confirm.js"></script>
	<script src="<?php echo base_url(); ?>static/js/home.js"></script>

</body>

</html>
