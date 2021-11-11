<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Manage Degrees</h3>
		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
				<i class="fas fa-minus"></i>
			</button>
			<button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
				<i class="fas fa-times"></i>
			</button>
		</div>
	</div><!-- card-header -->
	<div class="card-body">
		<div class="row">
			<div class="col-sm-4">
				<form action="ajax/userController.php" method="POST" role="form" class="form">
					<input type="hidden" name="action" value="addDegree">
					<div class="form-group">
						<label for="">Degree Name</label>
						<input type="hidden" name="degree_id" id="degree_id">
						<input type="text" class="form-control form-control-sm" name="degree_name" id="degree_name" placeholder="BSSE MSc etc">
					</div><!-- form-group -->
					<div class="form-group">
						<label for="">Degree Duration</label>
						<input type="text" class="form-control form-control-sm" name="degree_duration" id="degree_duration" placeholder="Time Duration">
					</div><!-- form-group -->
					<button type="submit" class="btn btn-sm btn-primary">Save</button>
				</form>
			</div><!-- col -->
			<div class="col-sm-8">
				<div class="table-responsive p-0" style="height: 300px;">
					<table class="table table-head-fixed text-nowrap" id="degreeTable">
		                <thead>
		                  <tr>
		                    <th>Degree ID# </th>
		                    <th>Degree Name</th>
		                    <th>Degree Duration</th>
		                    <th>Action</th>
		                  </tr>
		                </thead>
		                <tbody>
		                </tbody>
		            </table>
	            </div><!-- table responsive -->
			</div><!-- col -->
		</div><!-- row -->
	</div><!-- /.card-body -->
</div><!-- /.card -->