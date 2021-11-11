<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Manage Skills</h3>
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
					<input type="hidden" name="action" value="addSkill">
					<div class="form-group">
						<input type="hidden" name="skill_id" id="skill_id">
						<label for="">Skill Name</label>
						<input type="text" class="form-control form-control-sm" name="skill_name" id="skill_name" placeholder="Skill Name">
					</div><!-- form group -->
					<div class="form-group">
						<label for="">Skill Details</label>
						<textarea name="skill_details" placeholder="Details" id="skill_details" class="form-control" cols="" rows="3"></textarea>
					</div><!-- form group -->
					<button type="submit" class="btn btn-primary btn-sm">Save</button>
				</form>
			</div><!-- col -->
			<div class="col-sm-8">
		        <div class="table-responsive p-0" style="height: 300px;">
					<table class="table table-head-fixed text-nowrap" id="skillTable">
						<thead>
							<tr>
								<th>Skill ID#</th>
								<th>Skill Name</th>
								<th>Skill Details</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div><!-- col -->
		</div><!-- row -->
	</div><!-- card-body -->
</div><!-- card -->