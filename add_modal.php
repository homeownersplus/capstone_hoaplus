<?php 
$hasAdmin = false;
$hasTreasurer = false;
$hasSecretary = false;

$resulthasAdmin = $con->query("SELECT id FROM `admins` WHERE position='President'");
$resulthasTreasurer = $con->query("SELECT id FROM `admins` WHERE position='Treasurer'");
$resulthasSecretary = $con->query("SELECT id FROM `admins` WHERE position='Secretary'");

$rowhasAdmin = $resulthasAdmin->fetch_assoc();
$rowhasTreasurer = $resulthasTreasurer->fetch_assoc();
$rowhasSecretary = $resulthasSecretary->fetch_assoc();

if($rowhasAdmin) $hasAdmin = true;
if($rowhasTreasurer) $hasTreasurer = true;
if($rowhasSecretary) $hasSecretary = true;
?>

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
						<label class="col-sm-4  col-form-label">ID: </label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="id" value="<?php echo $largestNumber + 1  ?>" readonly>
						</div>
					</div>

					<?php } ?>

					<div class="mb-3 row">
						<label class="col-sm-4  col-form-label">Username: <span style="color:red">*</span></label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="username" required>
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-sm-4  col-form-label">First Name: <span style="color:red">*</span></label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="firstname" pattern="[a-z A-Z]+" required>
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-sm-4  col-form-label">Last Name: <span style="color:red">*</span></label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="lastname" pattern="[a-z A-Z]+" required>
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-sm-4  col-form-label">Middle Initial: </label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="mi" pattern="[a-z A-Z]+">
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-sm-4  col-form-label">Email: <span style="color:red">*</span></label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="email" required>
						</div>
					</div>


					<div class="mb-3 row">
						<label class="col-sm-4  col-form-label">Position: <span style="color:red">*</span></label>
						<div class="col-sm-8">
							<select class="form-select" name="position" aria-label="Default select example">
								<!-- <option selected>Open this select menu</option> -->
								<?php 
									if(!$hasAdmin) echo '<option value="President">President</option>';
									if(!$hasTreasurer) echo '<option value="Treasurer">Treasurer</option>';
									if(!$hasSecretary) echo '<option value="Secretary">Secretary</option>';
								?>
								<option value="Board of Staff">Board of Staff</option>
							</select>
						</div>
					</div>



					<div class="mb-3 row">
						<label class="col-sm-4  col-form-label">Password: 
							<small data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Your password must contain 8 characters in total with the combination of 1 Uppercase letter, lowercase letter, symbols, and numbers.">
							<i class="fa-regular fa-circle-question"></i>
		  					</small>
						<span style="color:red">*</span></label>
						<div class=col>
							<div class="input-group input-group-sm">
								<input type="password" class="form-control" name="password" id="admin-pass-field" style="height:100%" required>
								<span class="input-group-text" style="cursor:pointer" onClick="showPassAdmin()"><i class="fa-solid fa-eye"></i></span>
							</div>
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

<script>
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
function showPassAdmin() {
  var x = document.getElementById("admin-pass-field");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
