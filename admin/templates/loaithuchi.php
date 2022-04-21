<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Thêm Loại Chi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="loai_chi_code.php" method="POST">
        <div class="modal-body">
          <input type="hidden" name="loai" value="Chi">
          <div class="form-group">
            <label for="ten_loai">Tên Loại Chi</label>
            <input type="text" name="ten_loai" class="form-control" required="" pattern="^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s\W|_]+$">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="add" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="container-fluid">
  <h1 class="h3 mb-2 text-gray-800">Loại Thu Chi</h1>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
        Thêm Loại Chi
      </button>
    </div>
    <div class="card-body">
      <?php
      if (isset($_SESSION['success']) && $_SESSION['success'] != '') {
        echo '
          <div class="alert alert-success">
            ' . $_SESSION['success'] . '
          </div>';
        unset($_SESSION['success']);
      }
      if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
        echo '
          <div class="alert alert-danger">
            ' . $_SESSION['status'] . '
          </div>';
        unset($_SESSION['status']);
      }
      ?>
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>STT </th>
              <th>Loại </th>
              <th>Tên Loại </th>
              <th> </th>
              <th> </th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT * FROM loai_thu_chi order by Loai desc";
            if ($db->num_rows($sql)) {
              $serial_number = 0;
              foreach ($db->fetch_assoc($sql, 0) as $key => $row) {
                $serial_number++;
            ?>
                <tr>
                  <td> <?php echo $serial_number; ?></td>
                  <td> <?php echo $row['Loai']; ?></td>
                  <td> <?php echo $row['TenLoai']; ?></td>
                  <td>
                    <form action="<?php echo '' . $_DOMAIN . 'loaithuchi_edit'; ?>" method="POST">
                      <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                      <button type="submit" name="edit_cv" class="btn btn-success"> Sửa</button>
                    </form>
                  </td>
                  <td>
                    <form action="loai_chi_code.php" method="POST">
                      <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                      <button type="submit" name="delete_cv" class="btn btn-danger"> Xóa</button>
                    </form>
                  </td>
                </tr>
            <?php
              }
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>