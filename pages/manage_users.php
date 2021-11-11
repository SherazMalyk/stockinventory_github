<div class="card card card-outline card-primary">
  <div class="card-header">
    <h3 class="card-title">Manage Users</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
        <i class="fas fa-minus"></i>
      </button>
      <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
        <i class="fas fa-times"></i>
      </button>
    </div>
  </div>
  <div class="card-body">
    <form action="ajax/userController.php" method="post" role="form" class="form">
      <div class="row">
        <div class="col-sm-6">
            <input type="hidden" name="action" value="addUser">
            <div class="form-group">
              <label for="">User Name</label>
              <input type="text" class="form-control" id="user_name" name="user_name" required placeholder="Ali Ahmad...">
              <input type="hidden" id="user_id" name="user_id">
            </div><!-- form-group -->      
            <div class="form-group">
              <label for="">User Email</label>
              <input type="text" class="form-control" required id="user_email" name="user_email" placeholder="abc@xyz.com">
            </div><!-- form-group -->
            <div class="form-group">
              <label for="">User Phone</label>
              <input type="text" class="form-control" id="user_phone" name="user_phone" placeholder="0000-0000000">
            </div><!-- form-group -->
        </div><!-- col -->
        <div class="col-sm-6">
            <div class="form-group">
              <label>Skills</label>
              <select class="select2768" required multiple="multiple" id="select2[]" name="select2[]"  data-placeholder="Select a State" style="width: 100%;">
               </select>
            </div><!-- form-group-->
            <div class="form-group">
              <label for="">User Status</label>
              <select name="user_sts" id="user_sts" required class="form-control">
                <option value="">~~SELECT~~</option>
                <option value="1">Active</option>
                <option value="0">Deactive</option>
              </select>
            </div><!-- form-group -->
            <div class="form-group">
              <label for="user_pic">User Pic</label>
              <input type="file" class="form-control" id="user_pic" name="user_pic">
            </div><!-- form-group -->
        </div><!-- col -->
      </div><!-- row -->
        <!-- <div class="form-group add_hob_row" count="1">
          <label for="">User Hobbies</label>
          <button class="btn btn-sm btn-primary" type="button" onclick="add_hob_row()"><span class="fa fa-plus"></span></button>
        </div> --><!-- form-group -->
        <div class="form-group add_row" count="1">
          <label>Select Degrees & Hobbies</label>
          <button type="button" onclick="addRow();" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i></button>
        </div><!-- form-group-->
        <button type="submit" class="btn btn-primary btn-sm">Save</button>
    </form>
    <br><hr>
    <div class="row">
      <div class="col-sm-12">
          <div class="card-body table-responsive p-0" style="height: 500px;">
              <table class="table table-head-fixed text-nowrap" id="userTable">
                <thead>
                  <tr>
                    <th>User Pic</th>
                    <th>User Name</th>
                    <th>User Email</th>
                    <th>User Skills</th>
                    <th>User Degrees</th>
                    <th>User Phone</th>
                    <th>User Status</th> 
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
          </div><!-- card body -->
      </div><!-- col -->
    </div><!-- row -->
  </div>
  <!-- /.card-body --><div class="card-footer">Footer
  </div><!-- /.card-footer-->
</div>
<!-- <style>
  .select2-selection__choice{
    margin-top: 5px!important;
    padding-right: 5px!important;
    padding-left: 5px!important;
    color: white;
    background-color: transparent!important;
    border:none!important;
    border-radius: 4px!important;
    background-color: #007BFF !important;
}


</style> -->