<?php header('Access-Control-Allow-Origin: *');

use App\Models\TaskModel;
 ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Task</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

 <?php echo view('template/head-css')?>
 <?php echo view('template/header')?>
<!--/head is in header.php-->
  <?php echo view('template/sidebar-task')?>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <div class="row">
			  	<div class="col-md-8 mt-2">
				  <h3 class="card-title">Task List</h3>
			  	</div>
				<div class="col-md-4">
				  <button type="button" class="btn btn-block btn-success" onclick="add()"  data-toggle="modal" data-target="#add-modal" title="Add"> <i class="fa fa-plus"></i> Add</button>
			
				</div>
				
			  </div>			  
            </div>
            <!-- /.card-header -->
            <div class="card-body">
				<div class="form-check">
				  <input class="form-check-input" type="checkbox" id="includeArchive" onchange="fLoad()">
				  <label class="form-check-label" for="includeArchive">
					Include Archived
				  </label>
				</div>
				
              <table id="data_table" class="table table-bordered table-striped">
                <thead>
                <tr>
					<th>#</th>
					<th>Project</th>
					<th>Module</th>
					<th>Title</th>
					<!--th>Description</th-->
					<th>Task status</th>
					<th>Order</th>
					<th>Date assign</th>
					<th>Date due</th>
					<th>Date finish</th>
					<th>Assigned to</th>

					<th></th>
                </tr>
                </thead>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
	<!-- Add modal content -->
	<div id="add-modal" class="modal fade" tabindex="-1" role="dialog"
		aria-hidden="true">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="text-center bg-info p-3">
					<h4 class="modal-title text-white" id="info-header-modalLabel">Add</h4>
				</div>
				<div class="modal-body">
					<form id="add-form" class="pl-3 pr-3">								
                        <div class="row">
 							<input type="hidden" id="id" name="id" class="form-control" placeholder="Id" maxlength="11" required>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="project"> Project: </label>
									<select id="project" name="project" class="custom-select" ></select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="module"> Module: </label>
									<input type="text" id="module" name="module" class="form-control" placeholder="Module" maxlength="255" >
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="title"> Title: </label>
									<input type="text" id="title" name="title" class="form-control" placeholder="Title" maxlength="255" >
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="description"> Description: </label>
									<!--input type="text" id="description" name="description" class="form-control" placeholder="Description" maxlength="255" -->
									
									<textarea rows="3" id="description" name="description" class="form-control" placeholder="Description" maxlength="2000" ></textarea>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="task_status"> Task status: </label>
									<select id="task_status" name="task_status" class="custom-select" >
										<option value="1">New</option>
										<option value="2">In Progress</option>
										<option value="3">Completed</option>
										<option value="4">On Hold</option>
										<option value="5">Cancelled</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="order"> Order: </label>
									<input type="number" id="order" name="order" class="form-control" placeholder="Order" maxlength="11" number="true" >
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="dateAssign"> Date assign: </label>
									<input type="date" id="dateAssign" name="dateAssign" class="form-control" dateISO="true" required pattern="\d{4}-\d{2}-\d{2}" value="<?php echo date("Y-m-d");?>" >
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="dateDue"> Date due: </label>
									<input type="date" id="dateDue" name="dateDue" class="form-control" dateISO="true" >
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="date_finish"> Date finish: </label>
									<input type="date" id="date_finish" name="date_finish" class="form-control" dateISO="true" >
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="assigned_to"> Assigned to: </label>
									<select id="assigned_to" name="assigned_to" class="custom-select" >
										<option value="4">Unassigned</option>
										<option value="1">En. Hairi</option>
										<option value="2">Syahirah</option>
										<option value="3">Teya</option>
									</select>
								</div>
							</div>
						</div>
																				
						<div class="form-group text-center">
							<div class="btn-group">
								<button type="submit" class="btn btn-success" id="add-form-btn">Add</button>
								<button type="reset" class="btn btn-warning" id="add-form-btn">Reset</button>
								<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
							</div>
						</div>
					</form>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->	

	<!-- edit modal content -->				
	<div id="edit-modal" class="modal fade" tabindex="-1" role="dialog"
		aria-hidden="true">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="text-center bg-info p-3">
					<h4 class="modal-title text-white" id="info-header-modalLabel">Update</h4>
				</div>
				<div class="modal-body">
					<form id="edit-form" class="pl-3 pr-3">
                        <div class="row">
 							<input type="hidden" id="id" name="id" class="form-control"  maxlength="11" value="">
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="projectUpdate"> Project: </label>
									<select id="projectUpdate" name="project" class="custom-select" ></select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="module"> Module: </label>
									<input type="text" id="module" name="module" class="form-control" maxlength="255" value="" >
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="title"> Title: </label>
									<input type="text" id="title" name="title" class="form-control" placeholder="Title" maxlength="255" value="" >
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<!--label for="description"> Description: </label>
									<input type="text" id="description" name="description" class="form-control" placeholder="Description" maxlength="255" -->
									
									<textarea rows="3" id="description" name="description" class="form-control" placeholder="Description" maxlength="2000" ></textarea>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="task_status"> Task status: </label>
									<select id="task_status" name="task_status" class="custom-select" >
										<option value="1">New</option>
										<option value="2">In Progress</option>
										<option value="3">Completed</option>
										<option value="4">On Hold</option>
										<option value="5">Cancelled</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="order"> Order: </label>
									<input type="number" id="order" name="order" class="form-control" placeholder="Order" maxlength="11" number="true" >
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="dateAssign"> Date assign: </label>
									<input type="date" id="dateAssign" name="dateAssign" class="form-control" dateISO="true" readonly>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="dateDue"> Date due: </label>
									<input type="date" id="dateDue" name="dateDue" class="form-control" dateISO="true" value="">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="date_finish"> Date finish: </label>
									<input type="date" id="date_finish" name="date_finish" class="form-control" dateISO="true" >
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="assigned_to"> Assigned to: </label>
									<select id="assigned_to" name="assigned_to" class="custom-select" >
										<option value="4">Unassigned</option>
										<option value="1">En. Hairi</option>
										<option value="2">Syahirah</option>
										<option value="3">Teya</option>
									</select>
								</div>
							</div>
						</div>
											
						<div class="form-group text-center">
							<div class="btn-group">
								<button type="submit" class="btn btn-success" id="edit-form-btn">Update</button>
								<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
							</div>
						</div>
					</form>

				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->			
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper used in footer.php-->
 

<?php echo view('template/foot-js')?>
<?php echo view('template/footer')?>
<!-- page script -->
<script>
$(document).ready(function () {
	fLoad();
	listProject();
});

function fLoad(){
	//console.log($('#includeArchive').val()); 
	$('#data_table').DataTable({
		"paging": true,
		"lengthChange": false,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": false,
		"responsive": true,
		"ajax": {
			"url": '<?php echo base_url($controller.'/getAll') ?>',
			//"data": "includeArchive=" + $('#includeArchive').val(),
			 "data": {"includeArchive": document.getElementById('includeArchive').checked},
			"type": "POST",
			"dataType": "json",
			async: "true"
		}, 
		"bDestroy": true
	});
}

function listProject() {
	$.ajax({
		url: '<?php echo base_url($controller.'/getProjectList') ?>',
		dataType: 'json',
		success: function(data) {
			//alert(data.length);
			//console.log(data.project_name);
			 //JSON.stringify(data);
			var ele = document.getElementById('project');
			var eleUpdate = document.getElementById('projectUpdate');
			for (var i = 0; i < data.length; i++) {
				// POPULATE SELECT ELEMENT WITH JSON.
				ele.innerHTML = ele.innerHTML + '<option value="' + data[i].id + '">' + data[i].project_name + '</option>';
				eleUpdate.innerHTML = eleUpdate.innerHTML + '<option value="' + data[i].id + '">' + data[i].project_name + '</option>';
			}
		}
		
	})
}

function add() {
	$("#add-form")[0].reset();
	
	//$("#add-form #dateAssign").val('<?php echo date("Y-m-d");?>');
	
	$.validator.setDefaults({
		highlight: function(element) {
			$(element).addClass('is-invalid').removeClass('is-valid');
		},
		unhighlight: function(element) {
			$(element).removeClass('is-invalid').addClass('is-valid');
		},
		errorElement: 'div ',
		errorClass: 'invalid-feedback',
		errorPlacement: function(error, element) {
			if (element.parent('.input-group').length) {
				error.insertAfter(element.parent());
			} else if ($(element).is('.select')) {
				element.next().after(error);
			} else if (element.hasClass('select2')) {
				//error.insertAfter(element);
				error.insertAfter(element.next());
			} else if (element.hasClass('selectpicker')) {
				error.insertAfter(element.next());
			} else {
				error.insertAfter(element);
			}
		},

		submitHandler: function(form) {
			
			var form = $('#add-form');
			// remove the text-danger
			$(".text-danger").remove();

			$.ajax({
				url: '<?php echo base_url($controller.'/add') ?>',						
				type: 'post',
				data: form.serialize(), // /converting the form data into array and sending it to server
				dataType: 'json',
				beforeSend: function() {
					$('#add-form-btn').html('<i class="fa fa-spinner fa-spin"></i>');
				},					
				success: function(response) {

					if (response.success === true) {

						Swal.fire({
							position: 'bottom-end',
							icon: 'success',
							title: response.messages,
							showConfirmButton: false,
							timer: 1500
						}).then(function() {
							$('#data_table').DataTable().ajax.reload(null, false).draw(false);
							$('#add-modal').modal('hide');
						})

					} else {

						if (response.messages instanceof Object) {
							$.each(response.messages, function(index, value) {
								var id = $("#" + index);

								id.closest('.form-control')
									.removeClass('is-invalid')
									.removeClass('is-valid')
									.addClass(value.length > 0 ? 'is-invalid' : 'is-valid');

								id.after(value);

							});
						} else {
							Swal.fire({
								position: 'bottom-end',
								icon: 'error',
								title: response.messages,
								showConfirmButton: false,
								timer: 1500
							})

						}
					}
					$('#add-form-btn').html('Add');
				}
			});

			return false;
		}
	});
	
	$('#add-form').validate();
}

function edit(id) {
	
	$.ajax({
		url: '<?php echo base_url($controller.'/getOne') ?>',
		type: 'post',
		data: {
			id: id
		},
		dataType: 'json',
		async: false,
		
		success: function(response) {
			
			
			//const TEMP_ASSGN = new Date(response.dateAssign).toLocaleDateString("en-MY");
			$("#edit-form #id").val(response.id);
			
			//$("#edit-form #project").val(response.project);
			if(response.project!=""){
				//alert(response.project);
				$("#edit-form #projectUpdate").val(response.project);
			}
			else{
				//alert("null");
				$("#edit-form #projectUpdate").val(null);
			}
			
			
			$("#edit-form #module").val(response.module);
			$("#edit-form #title").val(response.title);
			$("#edit-form #description").val(response.description);
			$("#edit-form #task_status").val(response.task_status);
			$("#edit-form #order").val(response.order);
			$("#edit-form #assigned_to").val(response.assigned_to);
			
			
			if(response.dateAssign!="0000-00-00"){
				const TEMP_ASSGN = new Date(response.dateAssign);
				let x1 = TEMP_ASSGN.getDate()+1;
				let y1 = TEMP_ASSGN.getMonth();
				let z1 = TEMP_ASSGN.getFullYear();
				d_Assign = new Date(z1,y1,x1).toISOString().substr(0, 10);
				$("#edit-form #dateAssign").val(d_Assign);
			}else{
				$("#edit-form #dateAssign").val(null);
			}
			
			if(response.dateDue!="0000-00-00"){
				const TEMP_DUE = new Date(response.dateDue);
				let x2 = TEMP_DUE.getDate()+1;
				let y2 = TEMP_DUE.getMonth();
				let z2 = TEMP_DUE.getFullYear();
				d_Due = new Date(z2,y2,x2).toISOString().substr(0, 10);
				$("#edit-form #dateDue").val(d_Due);
			}else{
				$("#edit-form #dateDue").val(null);
			}
			
			
			if(response.dateFinish!="0000-00-00"){
				const TEMP_Finish = new Date(response.dateFinish);
				let x3 = TEMP_Finish.getDate()+1;
				let y3 = TEMP_Finish.getMonth();
				let z3 = TEMP_Finish.getFullYear();
				d_Finish = new Date(z3,y3,x3).toISOString().substr(0, 10);	
				$("#edit-form #date_finish").val(d_Finish);
				
			}else{
				$("#edit-form #date_finish").val(null);
			}
			
			/////////
			
			// submit the edit from 
			$.validator.setDefaults({
				highlight: function(element) {
					$(element).addClass('is-invalid').removeClass('is-valid');
				},
				unhighlight: function(element) {
					$(element).removeClass('is-invalid').addClass('is-valid');
				},
				errorElement: 'div ',
				errorClass: 'invalid-feedback',
				errorPlacement: function(error, element) {
					if (element.parent('.input-group').length) {
						error.insertAfter(element.parent());
					} else if ($(element).is('.select')) {
						element.next().after(error);
					} else if (element.hasClass('select2')) {
						//error.insertAfter(element);
						error.insertAfter(element.next());
					} else if (element.hasClass('selectpicker')) {
						error.insertAfter(element.next());
					} else {
						error.insertAfter(element);
					}
				},

				submitHandler: function(form) {
					var form = $('#edit-form');
					
					$(".text-danger").remove();
					$.ajax({
						url: '<?php echo base_url($controller.'/edit') ?>' ,						
						type: 'post',
						data: form.serialize(), 
						dataType: 'json',
						beforeSend: function() {
							$('#edit-form-btn').html('<i class="fa fa-spinner fa-spin"></i>');
						},								
						success: function(response) {

							if (response.success === true) {

								Swal.fire({
									position: 'bottom-end',
									icon: 'success',
									title: response.messages,
									showConfirmButton: false,
									timer: 1500
								}).then(function() {
									$('#data_table').DataTable().ajax.reload(null, false).draw(false);
									$('#edit-modal').modal('hide');
								})
								
							} else {

								if (response.messages instanceof Object) {
									$.each(response.messages, function(index, value) {
										var id = $("#" + index);

										id.closest('.form-control')
											.removeClass('is-invalid')
											.removeClass('is-valid')
											.addClass(value.length > 0 ? 'is-invalid' : 'is-valid');

										id.after(value);

									});
								} else {
									Swal.fire({
										position: 'bottom-end',
										icon: 'error',
										title: response.messages,
										showConfirmButton: false,
										timer: 1500
									})

								}
							}
							$('#edit-form-btn').html('Update');
						}
					});

					return false;
				}
			});
			
			$('#edit-form').validate();
		}
		
})}

function remove(id, strtitle) {	
	Swal.fire({
	  title: 'Delete record titled "'+ strtitle +'"',
	  text: "Are you sure?",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#d33',
	  cancelButtonColor: '#3085d6',
	  confirmButtonText: 'Yes',
	  cancelButtonText: 'Cancel'		  
	}).then((result) => {		

	  if (result.value) {
		$.ajax({
			url: '<?php echo base_url($controller.'/remove') ?>',
			type: 'post',
			data: {
				id: id
			},
			dataType: 'json',
			success: function(response) {

				if (response.success === true) {
					Swal.fire({
						position: 'bottom-end',
						icon: 'success',
						title: response.messages,
						showConfirmButton: false,
						timer: 1500
					}).then(function() {
						$('#data_table').DataTable().ajax.reload(null, false).draw(false);								
					})
				} else {
					Swal.fire({
						position: 'bottom-end',
						icon: 'error',
						title: response.messages,
						showConfirmButton: false,
						timer: 1500
					})

					
				}
			}
		});
	  }
	})		
}

function archive(id, strtitle) {	
	Swal.fire({
	  title: 'Archive record titled "'+ strtitle +'"',
	  text: "Are you sure?",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#fd7e14',
	  cancelButtonColor: '#3085d6',
	  confirmButtonText: 'Yes',
	  cancelButtonText: 'Cancel'		  
	}).then((result) => {		

	  if (result.value) {
		$.ajax({
			url: '<?php echo base_url($controller.'/archive') ?>',
			type: 'post',
			data: {
				id: id
			},
			dataType: 'json',
			success: function(response) {

				if (response.success === true) {
					Swal.fire({
						position: 'bottom-end',
						icon: 'success',
						title: response.messages,
						showConfirmButton: false,
						timer: 1500
					}).then(function() {
						$('#data_table').DataTable().ajax.reload(null, false).draw(false);								
					})
				} else {
					Swal.fire({
						position: 'bottom-end',
						icon: 'error',
						title: response.messages,
						showConfirmButton: false,
						timer: 1500
					})

					
				}
			}
		});
	  }
	})		
}
function undoarchive(id, strtitle) {	
	Swal.fire({
	  title: 'Undo archive record titled "'+ strtitle +'"',
	  text: "Are you sure?",
	  icon: 'question',
	  showCancelButton: true,
	  confirmButtonColor: '#fd7e14',
	  cancelButtonColor: '#3085d6',
	  confirmButtonText: 'Yes',
	  cancelButtonText: 'Cancel'
	}).then((result) => {		

	  if (result.value) {
		$.ajax({
			url: '<?php echo base_url($controller.'/undoarchive') ?>',
			type: 'post',
			data: {
				id: id
			},
			dataType: 'json',
			success: function(response) {

				if (response.success === true) {
					Swal.fire({
						position: 'bottom-end',
						icon: 'success',
						title: response.messages,
						showConfirmButton: false,
						timer: 1500
					}).then(function() {
						$('#data_table').DataTable().ajax.reload(null, false).draw(false);								
					})
				} else {
					Swal.fire({
						position: 'bottom-end',
						icon: 'error',
						title: response.messages,
						showConfirmButton: false,
						timer: 1500
					})

					
				}
			}
		});
	  }
	})		
}
</script>
</body>
</html>
