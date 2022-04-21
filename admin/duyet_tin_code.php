<?php
require_once 'core/init.php';
if (isset($_POST['update_btn'])) {
	$id = trim(addslashes(htmlspecialchars($_POST['edit_id'])));
	$query = "UPDATE tin_tuc SET TrangThai ='1' WHERE id_tt ='$id'";
	$query_run = $db->query($query);
	if (!$query_run) {
		$_SESSION['success'] = "Duyệt Thành Công";
		new Redirect($_DOMAIN . 'duyet_tin');
	} else {
		$_SESSION['status'] = "Duyệt Thất Bại";
		new Redirect($_DOMAIN . 'duyet_tin');
	}
}
if (isset($_POST['reject_btn'])) {
	$id = trim(addslashes(htmlspecialchars($_POST['edit_id'])));
	$query = "UPDATE tin_tuc SET TrangThai ='0' WHERE id_tt ='$id'";
	$query_run = $db->query($query);
	if (!$query_run) {
		$_SESSION['success'] = "Từ Chối Thành Công";
		new Redirect($_DOMAIN . 'duyet_tin');
	} else {
		$_SESSION['status'] = "Từ Chối Thất Bại";
		new Redirect($_DOMAIN . 'duyet_tin');
	}
}
