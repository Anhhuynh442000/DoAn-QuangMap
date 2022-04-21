<div class="container-fluid">
	<!--DataTables -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"> Sửa Khoá Học</h6>
		</div>
		<div class="card-body">
			<?php
			if (isset($_POST['edit_cv'])) {
				$id = $_POST['edit_id'];
				$sql = "SELECT * FROM `lop_hoc` 
				JOIN nien_khoa On nien_khoa.id_nk=lop_hoc.Khoa 
				JOIN trang_thai_lop ON trang_thai_lop.id_ttl=lop_hoc.trangthailop
				JOIN mon_hoc On mon_hoc.id_mon=lop_hoc.id_mh
				JOIN phong_hoc On phong_hoc.id_phong=lop_hoc.id_phonghoc
				Join register On lop_hoc.id_gv=register.id
				LEFT JOIN ca_hoc On ca_hoc.id_ca=lop_hoc.id_cahoc
				LEFT JOIN bo_mon On bo_mon.id_bo_mon=mon_hoc.id_mon
				WHERE id_lop = '$id' ";
				if ($db->num_rows($sql)) {
					foreach ($db->fetch_assoc($sql, 0) as $key => $row) {
						$username = $row['username'];
						$id_gv = $row['id'];
						$trangthailop = $row['trangthailop'];
						$ten_ttl = $row['ten_ttl'];
						$id_mh = $row['id_mh'];
						$ten_monhoc = $row['ten_monhoc'];
						$id_cahoc = $row['id_cahoc'];
						$ten_ca = $row['ten_ca'];
						$chitiet_ca = $row['chitiet_ca'];
						$id_phonghoc = $row['id_phonghoc'];
						$Phong = $row['Phong'];
						$suc_chua = $row['suc_chua'];
						$si_so = $row['si_so'];
			?>
						<form action="lop_hoc_code.php" method="POST">
							<input type="hidden" name="edit_id" value="<?php echo $row['id_lop'] ?>">
							<div class="form-group">
								<label> Mã Lớp </label>
								<input type="text"  name="MaLop" value="<?php echo $row['MaLop'] ?>" class="form-control">
							</div>
							<div class="form-group">
								<label> Môn Học </label>
								<select name="ten_monhoc" class="form-control ">
									<option hidden value="<?php echo $id_mh ?>"><?php echo $row['ten_monhoc'] ?></option>
									<?php
									$sql = "SELECT * FROM mon_hoc";
									if ($db->num_rows($sql)) { {
											foreach ($db->fetch_assoc($sql, 0) as $key => $row) {
									?>
												<option value="<?php echo $row['id_mon'] ?>"> <?php echo $row['ten_monhoc'] ?> </option>
									<?php
											}
										}
									}
									?>
								</select>
							</div>
							<div class="form-group">
								<label> Trạng Thái Lớp </label>
								<select name="trangthailop" class="form-control ">
									<option hidden value="<?php echo $trangthailop ?>"><?php echo $ten_ttl ?> </option>
									<?php
									$sql = "SELECT * FROM trang_thai_lop ";
									if ($db->num_rows($sql)) { {
											foreach ($db->fetch_assoc($sql, 0) as $key => $row) {
									?>
												<option value="<?php echo $row['id_ttl'] ?>"> <?php echo $row['ten_ttl'] ?> </option>
									<?php
											}
										}
									}
									?>
								</select>
							</div>
							<div class="form-group">
								<label> Số Lượng </label>
								<select name="si_so" class="form-control ">
									<option hidden value="<?php echo $si_so ?>"><?php echo $si_so ?> </option>
									<?php
									$sql = "SELECT distinct suc_chua FROM phong_hoc";
									if ($db->num_rows($sql)) { {
											foreach ($db->fetch_assoc($sql, 0) as $key => $row) {
									?>
												<option value="<?php echo $row['suc_chua'] ?>"> <?php echo $row['suc_chua'] ?> </option>
									<?php
											}
										}
									}
									?>
								</select>
							</div>
							<button type="submit" name="update_tt" class="btn btn-primary"> Thay Đổi</button>
							<a href="<?php echo '' . $_DOMAIN . 'lophoc'; ?>" class="btn btn-danger"> Hủy </a>
						</form>
			<?php
					}
				}
			}
			?>
		</div>
	</div>
</div>