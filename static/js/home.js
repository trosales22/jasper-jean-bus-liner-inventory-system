$(function() {
	function base_url() {
		var pathparts = location.pathname.split('/');
		var url;

		if (location.host == 'localhost') {
			url = location.origin+'/'+pathparts[1].trim('/')+'/'; // http://localhost/myproject/
		}else{
			url = location.origin + "/"; // http://stackoverflow.com/
		}
		return url;
	}

	$('#tbl_products').DataTable();
	$('#tbl_orders').DataTable();
	$('#inputProductAmount').maskMoney();
	$('#inputProductQuantity').maskMoney({precision: 0});
	$('#inputOrderQuantity').maskMoney({precision: 0});

	$('#edit_inputProductAmount').maskMoney();
	$('#edit_inputProductQuantity').maskMoney({precision: 0});

	function addProduct(){
		$("#frmAddProduct").submit(function(e) {
			//prevent Default functionality
			e.preventDefault();
			
			//get the action-url of the form
			var actionUrl = e.currentTarget.action;
			
			$.confirm({
				title: 'Confirmation!',
				content: 'Are you sure you want to add this product?',
				useBootstrap: false, 
				theme: 'supervan',
				buttons: {
					NO: function () {
						//do nothing
					},
					YES: function () {
						$.ajax({
							url: actionUrl,
							type: 'POST',
							data: $("#frmAddProduct").serialize(),
							success: function(data) {
								var obj = JSON.parse(data);
								
								if(obj.flag === 0){
									$.alert({
										title: "Oops! We're sorry!",
										content: obj.msg,
										useBootstrap: false,
										theme: 'supervan',
										buttons: {
											'Ok, Got It!': function () {
												//do nothing
											}
										}
									});
								}else{
									$.alert({
										title: 'Success!',
										content: obj.msg,
										useBootstrap: false,
										theme: 'supervan',
										buttons: {
											'Ok, Got It!': function () {
												location.replace(base_url());
											}
										}
									});
								}
							},
							error: function(xhr, status, error){
								var errorMessage = xhr.status + ': ' + xhr.statusText;
								$.alert({
									title: "Oops! We're sorry!",
									content: errorMessage,
									useBootstrap: false,
									theme: 'supervan',
									buttons: {
										'Ok, Got It!': function () {
											//do nothing
										}
									}
								});
							}
						});
						
					}
				}
			});
		});
	}

	function editProduct(){
		var productId = '';

		$('.btnEditProduct').click(function(){
			productId = $(this).data("id");

			var getProductDetailsUrl = base_url() + 'home/get_product_details?product_id=' + productId;
			$.getJSON(getProductDetailsUrl, function(productResponse) {
				$("input[id='edit_inputProductName']").val(productResponse['product_details'][0].product_name);
				$("input[id='edit_inputProductAmount']").val(productResponse['product_details'][0].product_amount);
				$("textarea[id='edit_inputProductDescription']").val(productResponse['product_details'][0].product_description);
				$("input[id='edit_inputProductQuantity']").val(productResponse['product_details'][0].product_quantity);
				$("input[id='edit_inputProductSeller']").val(productResponse['product_details'][0].product_seller);
			});
		});

		$("#frmEditProduct").submit(function(e) {
			console.log('productId: ' + productId);

			//prevent Default functionality
			e.preventDefault();
			
			//get the action-url of the form
			var actionUrl = e.currentTarget.action;
			
			$.confirm({
				title: 'Confirmation!',
				content: 'Are you sure you want to edit this product?',
				useBootstrap: false, 
				theme: 'supervan',
				buttons: {
					NO: function () {
						//do nothing
					},
					YES: function () {
						$.ajax({
							url: actionUrl + "?product_id=" + productId,
							type: 'POST',
							data: $("#frmEditProduct").serialize(),
							success: function(data) {
								var obj = JSON.parse(data);
								
								if(obj.flag === 0){
									$.alert({
										title: "Oops! We're sorry!",
										content: obj.msg,
										useBootstrap: false,
										theme: 'supervan',
										buttons: {
											'Ok, Got It!': function () {
												//do nothing
											}
										}
									});
								}else{
									$.alert({
										title: 'Success!',
										content: obj.msg,
										useBootstrap: false,
										theme: 'supervan',
										buttons: {
											'Ok, Got It!': function () {
												location.replace(base_url());
											}
										}
									});
								}
							},
							error: function(xhr, status, error){
								var errorMessage = xhr.status + ': ' + xhr.statusText;
								$.alert({
									title: "Oops! We're sorry!",
									content: errorMessage,
									useBootstrap: false,
									theme: 'supervan',
									buttons: {
										'Ok, Got It!': function () {
											//do nothing
										}
									}
								});
							}
						});
						
					}
				}
			});
		});
	}

	function deleteProduct(){
		$('.btnDeleteProduct').click(function(){
			var productId = $(this).data("id");

			console.log('productId: ' + productId);

			$.confirm({
				title: 'Confirmation!',
				content: 'Are you sure you want to delete this product?',
				useBootstrap: false, 
				theme: 'supervan',
				buttons: {
					NO: function () {
						//do nothing
					},
					YES: function () {
						$.ajax({
							url: base_url() + 'home/delete_product?product_id=' + productId,
							type: "POST",
							processData: false,
							contentType: false,
							cache: false,
							async: false,
							success: function(data) {
								var obj = JSON.parse(data);
		
								if(obj.flag === 0){
									$.alert({
										title: "Oops! We're sorry!",
										content: obj.msg,
										useBootstrap: false,
										theme: 'supervan',
										buttons: {
											'Ok, Got It!': function () {
												//do nothing
											}
										}
									});
								}else{
									$.alert({
										title: 'Success!',
										content: obj.msg,
										useBootstrap: false,
										theme: 'supervan',
										buttons: {
											'Ok, Got It!': function () {
												location.replace(base_url());
											}
										}
									});
								}
							},
							error: function(xhr, status, error){
								var errorMessage = xhr.status + ': ' + xhr.statusText;
								$.alert({
									title: "Oops! We're sorry!",
									content: errorMessage,
									useBootstrap: false,
									theme: 'supervan',
									buttons: {
										'Ok, Got It!': function () {
											//do nothing
										}
									}
								});
							 }
						});
					}
				}
			});
		});
	}

	function addOrder(){
		$("#frmAddOrder").submit(function(e) {
			//prevent Default functionality
			e.preventDefault();
			
			//get the action-url of the form
			var actionUrl = e.currentTarget.action;
			
			$.confirm({
				title: 'Confirmation!',
				content: 'Are you sure you want to add this order?',
				useBootstrap: false, 
				theme: 'supervan',
				buttons: {
					NO: function () {
						//do nothing
					},
					YES: function () {
						$.ajax({
							url: actionUrl,
							type: 'POST',
							data: $("#frmAddOrder").serialize(),
							success: function(data) {
								var obj = JSON.parse(data);
								
								if(obj.flag === 0){
									$.alert({
										title: "Oops! We're sorry!",
										content: obj.msg,
										useBootstrap: false,
										theme: 'supervan',
										buttons: {
											'Ok, Got It!': function () {
												//do nothing
											}
										}
									});
								}else{
									$.alert({
										title: 'Success!',
										content: obj.msg,
										useBootstrap: false,
										theme: 'supervan',
										buttons: {
											'Ok, Got It!': function () {
												location.replace(base_url());
											}
										}
									});
								}
							},
							error: function(xhr, status, error){
								var errorMessage = xhr.status + ': ' + xhr.statusText;
								$.alert({
									title: "Oops! We're sorry!",
									content: errorMessage,
									useBootstrap: false,
									theme: 'supervan',
									buttons: {
										'Ok, Got It!': function () {
											//do nothing
										}
									}
								});
							}
						});
						
					}
				}
			});
		});
	}
	
	function approveOrder(){
		$('.btnApproveOrder').click(function(){
			var orderId = $(this).data("id");

			console.log('orderId: ' + orderId);

			$.confirm({
				title: 'Confirmation!',
				content: 'Are you sure you want to approve this pending order?',
				useBootstrap: false, 
				theme: 'supervan',
				buttons: {
					NO: function () {
						//do nothing
					},
					YES: function () {
						$.ajax({
							url: base_url() + 'home/approve_pending_order?order_id=' + orderId,
							type: "POST",
							processData: false,
							contentType: false,
							cache: false,
							async: false,
							success: function(data) {
								var obj = JSON.parse(data);
		
								if(obj.flag === 0){
									$.alert({
										title: "Oops! We're sorry!",
										content: obj.msg,
										useBootstrap: false,
										theme: 'supervan',
										buttons: {
											'Ok, Got It!': function () {
												//do nothing
											}
										}
									});
								}else{
									$.alert({
										title: 'Success!',
										content: obj.msg,
										useBootstrap: false,
										theme: 'supervan',
										buttons: {
											'Ok, Got It!': function () {
												location.replace(base_url());
											}
										}
									});
								}
							},
							error: function(xhr, status, error){
								var errorMessage = xhr.status + ': ' + xhr.statusText;
								$.alert({
									title: "Oops! We're sorry!",
									content: errorMessage,
									useBootstrap: false,
									theme: 'supervan',
									buttons: {
										'Ok, Got It!': function () {
											//do nothing
										}
									}
								});
							 }
						});
						
					}
				}
			});
		});
	}

	$('#frmAddProduct').parsley().on('field:validated', function() {
		var ok = $('.parsley-error').length === 0;
	});

	$('#frmEditProduct').parsley().on('field:validated', function() {
		var ok = $('.parsley-error').length === 0;
	});

	$('#frmAddOrder').parsley().on('field:validated', function() {
		var ok = $('.parsley-error').length === 0;
	});

	addProduct();
	editProduct();
	deleteProduct();

	addOrder();
	approveOrder();
});
