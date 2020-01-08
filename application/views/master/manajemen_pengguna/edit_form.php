<!DOCTYPE html>
<html lang="en">
	<head>
		<?php  $this->load->view("_template/head.php")?>
	</head>
	<body>
	<?php  $this->load->view("_template/nav.php")?>
		<div class="page-content">
			<?php  $this->load->view("_template/sidebar.php")?>
			<div class="content-wrapper">
                <!-- <?php  $this->load->view("_template/breadcrumb.php")?> -->
				<div class="content">
				<?php if ($this->session->flashdata('success')): ?>
					<div class="alert alert-success" role="alert">
						<?php echo $this->session->flashdata('success'); ?>
					</div>
					<?php elseif($this->session->flashdata('failed')): ?>
						<div class="alert alert-danger" role="alert">
							<?php echo $this->session->flashdata('failed'); ?>
						</div>
				<?php endif; ?>

					
				
                    <div class="card">
                        <div class="card-body">
                            <form action="<?php base_url('master/manajemen/edit')?>" method="POST">
							<input type="hidden" name="admin_id" value="<?=$admin->admin_id?>">
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Ubah Data Pengguna</legend>
                                            
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">NIK:</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" name="data_nik" autocomplete="off" value="">
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Username:</label>
												<div class="col-lg-9">
													<input type="text" class="form-control <?php echo validation_errors('admin_username') ? 'is-invalid':'' ?>"  name="admin_username" autocomplete="off" required value="<?=$admin->admin_username?>" >
													<div class="invalid-feedback">
														<?php echo validation_errors('admin_username') ?>
													</div>
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Nama Lengkap:</label>
												<div class="col-lg-9">
													<input type="text" class="form-control <?php echo validation_errors('admin_realname') ? 'is-invalid':'' ?>" name="admin_realname" autocomplete="off" required value="<?=$admin->admin_realname?>">
													<div class="invalid-feedback">
														<?php echo validation_errors('admin_realname') ?>
													</div>
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Email:</label>
												<div class="col-lg-9">
													<input type="text" class="form-control <?php echo validation_errors('admin_email') ? 'is-invalid':'' ?>" name="admin_email" autocomplete="off" required value="<?=$admin->admin_email?>">
													<div class="invalid-feedback">
														<?php echo validation_errors('admin_email') ?>
													</div>
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Pilih Plant:</label>
												<div class="col-lg-9">
                                                    <select class="form-control multiselect-select-all-filtering" multiple="multiple" data-fouc name="plants[]">
													<?php 
														$plants = $this->manajemen_model->selectedPlants($admin->plants);
														foreach($outlets as $outlet):?>
															<option value='<?=$outlet['OUTLET']?>'
																<?php foreach($plants as $plant):
																if($outlet['OUTLET'] == $plant['OUTLET']):
																?>
																	selected
																<?php endif; ?>
																<?php endforeach; ?>
															 >
																<?=$outlet['OUTLET'] .'-'.$outlet['OUTLET_NAME1']?>
															</option> 
														<?php endforeach;?>
													</select>
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Group Hak Akses:</label>
												<div class="col-lg-9">
                                                    <select class="form-control multiselect-select-all-filtering" multiple="multiple" data-fouc name="perm_group_id[]">
													<?php 
													$permGroupSelect = $this->manajemen_model->selectedPermGroups($admin->admin_perm_grup_ids);
													foreach($permGroups as $perm): ?>
														<option value="<?=$perm['group_id']?>" 
															<?php foreach($permGroupSelect as $permGroup):
																if($perm['group_id'] == $permGroup['group_id']):?>
																	selected
																<?php endif; ?>
															<?php endforeach; ?>
														>
															<?=$perm['group_name']?>
														</option>
													<?php endforeach;?>
                                                    </select>
												</div>
											</div>

                                            <div class="text-right">
                                                <button type="submit" class="btn btn-primary">Ubah<i class="icon-paperplane ml-2"></i></button>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>                    
				</div>
				<?php  $this->load->view("_template/footer.php")?>
			</div>
		</div>
        <?php  $this->load->view("_template/js.php")?>
	</body>
</html>