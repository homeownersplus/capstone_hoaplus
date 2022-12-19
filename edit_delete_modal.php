
<!-- Edit -->
<div class="modal fade" id="edit_<?php echo $row['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Edit Admin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="edit.php?id=<?php echo $row['id']; ?>">


<!---cant edit id lol so no editing for id-->



            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label">Username</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="username" value="<?php echo $row['username']; ?>" required>
                </div>
            </div>
          <div class="mb-3 row">
						<label class="col-sm-4  col-form-label">First Name: <span style="color:red">*</span></label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="firstname" pattern="[a-z A-Z]+" required value="<?php echo $row['firstname'];?>">
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-sm-4  col-form-label">Last Name: <span style="color:red">*</span></label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="lastname" pattern="[a-z A-Z]+" required value="<?php echo $row['lastname'];?>">
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-sm-4  col-form-label">Middle Initial: </label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="mi" pattern="[a-z A-Z]+" value="<?php echo $row['middle'];?>">
						</div>
					</div>



            <!-- <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="email" value="<?php echo $row['email']; ?>">
                </div>
            </div>

            
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="password" value="<?php echo $row['password']; ?>">
                </div>
            </div> -->




      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="edit" class="btn btn-primary"> Update</a>
        </form>
      </div>
    </div>
  </div>
</div>
 
<!-- Delete -->
<div class="modal fade" id="delete_<?php echo $row['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false"tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Archive Admin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <p class="text-center">Are you sure you want to Archive this Admin</p>
            <h2 class="text-center"><?php echo $row['username']; ?></h2>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger"> Yes</a>
      </div>
    </div>
  </div>
</div>


<!-- Delete -->
<div class="modal fade" id="revert_<?php echo $row['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false"tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Revert Admin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <p class="text-center">Are you sure you want to Revert this Admin</p>
            <h2 class="text-center"><?php echo $row['username']; ?></h2>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="revert.php?id=<?php echo $row['id']; ?>" class="btn btn-danger"> Yes</a>
      </div>
    </div>
  </div>
</div>