<?php
require_once 'core/init.php';
if (isset($_POST['update_btn'])) {
  $id = trim(addslashes(htmlspecialchars($_POST['edit_id'])));
  $content_web = trim(addslashes(htmlspecialchars($_POST['content'])));
  $sql = "UPDATE gioi_thieu SET Content ='$content_web' WHERE id ='$id'";
  $query_run = $db->query($sql);
  if (!$query_run) {
    $_SESSION['success'] = "Sửa Thành Công";
    new Redirect($_DOMAIN . 'gioithieu');
  } else {
    $_SESSION['status'] = "Sửa Thất Bại";
    new Redirect($_DOMAIN . 'gioithieu');
  }
}
