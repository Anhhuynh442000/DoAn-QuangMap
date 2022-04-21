<?php
require_once 'core/init.php';
if (isset($_POST['update_btn'])) {
  $id = trim(addslashes(htmlspecialchars($_POST['id'])));
  $edit_Diem = trim(addslashes(htmlspecialchars($_POST['edit_Diem'])));
  $query = "
    UPDATE hoc_sinh
    SET Diem='$edit_Diem'      
    WHERE id ='$id'";
  $query_run = $db->query($query);
  if (!$query_run) {
    $_SESSION['success'] = "Sửa Thành Công";
    new Redirect($_DOMAIN . 'lophoc');
  } else {
    $_SESSION['status'] = "Sửa Thất Bại";
    new Redirect($_DOMAIN . 'lophoc');
  }
}
