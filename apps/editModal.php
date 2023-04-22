<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit User Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="manageUsers.php" method="POST">
                    <input type="hidden" name="slnoEdit" id="slnoEdit">
                    <div class="mb-3 my-3">
                        <label for="userName" class="form-label">Student Name</label>
                        <input type="text" class="form-control" id="userName" name="userName">
                    </div>
                    <div class="mb-3 my-3">
                        <label for="userFName" class="form-label">Father Name</label>
                        <input type="text" class="form-control" id="userFName" name="userFName">
                    </div>
                    <div class="mb-3 my-3">
                        <label for="userRegisterNo" class="form-label">Reg.no</label>
                        <input type="text" class="form-control" id="userRegisterNo" name="userRegisterNo">
                    </div>
                    <div class="mb-3 my-3">
                        <label for="userID" class="form-label">User ID</label>
                        <input class="form-control" name="userID" id="userID" type="text" readonly>
                    </div>
                    <div class="mb-3 my-3">
                        <label for="userNumber" class="form-label">Mobile Number</label>
                        <input type="text" class="form-control" id="userNumber" name="userNumber">
                    </div>
                    <div class="mb-3 my-3">
                        <label for="userAddress" class="form-label">Student Address</label>
                        <textarea name="userAddress" class="form-control" id="userAddress" rows="5" style="resize: none;"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                        <button type="submit" class="btn btn-primary">Update Details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>