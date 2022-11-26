<!-- Add New -->
<div class="modal fade" id="addnew" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
	aria-labelledby="ModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalLabel">Add New Admin</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form method="POST" action="add.php" <?php echo ($_SERVER["PHP_SELF"]); ?>" method="post">


					<?php

          // Connect to the database
          $con = new mysqli("localhost", "root", "", "pdocrud");

          $result = mysqli_query($con, "SELECT MAX(id) as 'max' FROM admins");
          $row = mysqli_fetch_assoc($result);
          $largestNumber = $row['max']; {

          ?>

					<div class="mb-3 row">
						<label class="col-sm-2 col-form-label">ID: </label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="id" value="<?php echo $largestNumber + 1  ?>" readonly>
						</div>
					</div>

					<?php } ?>




					<div class="mb-3 row">
						<label class="col-sm-2 col-form-label">Username: </label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="username">
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-sm-2 col-form-label">Full Name: </label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="fullname">
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-sm-2 col-form-label">Email: </label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="email">
						</div>
					</div>


					<div class="mb-3 row">
						<label class="col-sm-2 col-form-label">Position: </label>
						<div class="col-sm-10">
							<select class="form-select" name="position" aria-label="Default select example">
								<!-- <option selected>Open this select menu</option> -->
								<option value="President">President</option>
								<option value="Secretary">Secretary</option>
								<option value="Treasurer">Treasurer</option>
								<option value="Board of Staff">Board of Staff</option>
							</select>
						</div>
					</div>



					<div class="mb-3 row">
						<label class="col-sm-2 col-form-label">Password: </label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="password">
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="submit" name="add" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span>
					Save</a>
					</form>
			</div>
		</div>
	</div>
</div>