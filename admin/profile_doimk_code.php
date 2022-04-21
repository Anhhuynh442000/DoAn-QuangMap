<?php
require_once 'core/init.php';
if (isset($_POST['doi_mk'])) {
	$id = $_POST['id'];
	$password0 = trim(addslashes(htmlspecialchars($_POST['password0'])));
	$password1 = trim(addslashes(htmlspecialchars(md5($_POST['password1']))));
	$password2 = trim(addslashes(htmlspecialchars(md5($_POST['password2']))));
	$password3 = trim(addslashes(htmlspecialchars(md5($_POST['password3']))));
	if ($password0 != $password1) {
		$_SESSION['status'] = "Mật Khẩu Cũ Không Đúng!";
		new Redirect($_DOMAIN . 'profile');
	} else if ($password2 != $password3) {
		$_SESSION['status'] = "Mật Khẩu Mới Không Khớp Nhau!";
		new Redirect($_DOMAIN . 'profile');
	} else if ($password0 == $password3) {
		$_SESSION['status'] = "Đây Là mật khẩu cũ của bạn!";
		new Redirect($_DOMAIN . 'profile');
	} else {
		$sql = "UPDATE register SET password ='$password2' WHERE id ='$id'";
		if ($db->query($sql)) {
			$_SESSION['status'] = "Đổi Mật Khẩu Thất Bại";
			new Redirect($_DOMAIN . 'profile');
		} else {
			$_SESSION['success'] = "Đổi Mật Khẩu Thành Công";
			new Redirect($_DOMAIN . 'profile');
		}
	}
}
