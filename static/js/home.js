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
