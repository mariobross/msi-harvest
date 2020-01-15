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
					<?php endif; ?>
					<?php if ($this->session->flashdata('failed')): ?>
						<div class="alert alert-danger" role="alert">
							<?php echo $this->session->flashdata('failed'); ?>
						</div>
					<?php endif; ?>
                    <div class="card">
                        <div class="card-header">
                            <legend class="font-weight-semibold"><i class="icon-search4 mr-2"></i>Search of Transfer In Inter Outlet</legend>  
                        </div>
                        <div class="card-body">

							<form action="#" method="POST">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group row">
											<label class="col-lg-3 col-form-label">Dari Tanggal</label>
											<div class="col-lg-3 input-group date">
												<input type="text" class="form-control" id="fromDate" autocomplete="off">
												<div class="input-group-prepend">
													<span class="input-group-text" id="basic-addon1">
														<i class="icon-calendar"></i>
													</span>
												</div>
											</div>
											<label class="col-lg-2 col-form-label">Sampai Tanggal</label>
											<div class="col-lg-4 input-group date">
												<input type="text" class="form-control" id="toDate" autocomplete="off">
												<div class="input-group-prepend">
													<span class="input-group-text" id="basic-addon1">
														<i class="icon-calendar"></i>
													</span>
												</div>
											</div>
										</div>


										<div class="form-group row">
											<label class="col-lg-3 col-form-label">Status</label>
											<div class="col-lg-9">
												<select class="form-control form-control-select2" data-live-search="true" id="status" name="status" >
													<option value="">--- All ---</option>
													<option value="2">Approved</option>
													<option value="1">Not Approved</option>
												</select>
											</div>
										</div>

										<div class="text-right">
											<button type="button" class="btn btn-primary" onclick="onSearch()">Search<i class="icon-search4  ml-2"></i></button>
										</div>
									</div>
								</div>
							</form>
                        </div>                        
                    </div>                        
                    
                    <div class="card">
                        <div class="card-header">
                            <a href="<?php echo site_url('transaksi1/transferininteroutlet/add') ?>" class="btn btn-primary"> Add New</a>
                            <input type="button" value="Delete" class="btn btn-danger" id="deleteRecord">  
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12" style="overflow:auto">
                                    <table id="tableWhole" class="table table-striped" style="widht:100%" >
                                        <thead>
                                            <tr>
                                                <th style="text-align: left"></th>
                                                <th style="text-align: center">Action</th>
                                                <th style="text-align: center">ID</th>
                                                <th style="text-align: center">Transfer In No</th>
                                                <th style="text-align: center">Store Room Request (SR) Number</th>
                                                <th style="text-align: center">Transfer Slip No</th>
                                                <th style="text-align: center">Delivery Outlet</th>
                                                <th style="text-align: center">Delivery Date</th>
                                                <th style="text-align: center">Posting Date</th>
                                                <th style="text-align: center">Status</th>
                                                <th style="text-align: center">User</th>
                                                <th style="text-align: center">Approved by</th>
                                                <th style="text-align: center">Last Modified</th>
                                                <th style="text-align: center">Log</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>                   
				</div>
				<?php  $this->load->view("_template/footer.php")?>
			</div>
		</div>
        <?php  $this->load->view("_template/modal_delete.php")?>
        <?php  $this->load->view("_template/js.php")?>
        <script>
            $(document).ready(function(){
                $('#fromDate').datepicker();
                $('#toDate').datepicker();
                
                showListData();

                $("#deleteRecord").click(function(){
                    let deleteidArr=[];
                    $("input:checkbox[class=check_delete]:checked").each(function(){
                        deleteidArr.push($(this).val());
                    })
                    // mengecek ckeckbox tercheck atau tidak
                    if(deleteidArr.length > 0){
                        var confirmDelete = confirm("Do you really want to Delete records?");
                        if(confirmDelete == true){
                            $.ajax({
                                url:"<?php echo site_url('transaksi1/transferininteroutlet/deleteData');?>", //masukan url untuk delete
                                type: "post",
                                data:{deleteArr: deleteidArr},
                                success:function(res) {
                                    dataTable.ajax.reload();
                                }
                            });
                        }
                    }
                });

                checkcheckbox = () => {
                    
                    const lengthcheck = $(".check_delete").length;
                    
                    let totalChecked = 0;
                    $(".check_delete").each(function(){
                        if($(this).is(":checked")){
                            totalChecked += 1;
                        }
                    });
                    if(totalChecked == lengthcheck){
                        $("#checkall").prop('checked', true);
                    }else{
                        $("#checkall").prop('checked', false);
                    }
                }

                deleteConfirm = (url)=>{
                    $('#btn-delete').attr('href', url);
	                $('#deleteModal').modal();
                }

                printPdf = (data)=>{
                    // console.log(data);
                    uri = "<?php echo site_url('transaksi1/transferininteroutlet/printpdf/')?>"+data
                    // console.log(uri);
                    window.open(uri);

                }
            });

            function onSearch(){
                const fromDate = $('#fromDate').val();
                const toDate = $('#toDate').val();
                const status = $('#status').val();

                showListData();
            }

            function showListData(){
                const obj = $('#tableWhole tbody tr').length;

                if(obj > 0){
                    const dataTable = $('#tableWhole').DataTable();
                    dataTable.destroy();
                    $('#tableWhole > tbody > tr').remove();
                    
                }

                const fromDate = $('#fromDate').val();
                const toDate = $('#toDate').val();
                const status = $('#status').val();

                dataTable = $('#tableWhole').DataTable({
                    "ordering":false,  "paging": true, "searching":true,
                    "ajax": {
                        "url":"<?php echo site_url('transaksi1/transferininteroutlet/showListData');?>",
                        "type":"POST",
                        "data":{fDate: fromDate, tDate: toDate, stts: status}
                    },
                    "columns": [
                        {"data":"id_grsto_header", "className":"dt-center", render:function(data, type, row, meta){
                            rr=`<input type="checkbox" class="check_delete" id="chk_${data}" value="${data}" onclick="checkcheckbox();">`;
                            return rr;
                        }},
                        {"data":"id_grsto_header", "className":"dt-center", render:function(data, type, row, meta){
                            rr = `<div style="width:100px">
										<a href='<?php echo site_url('transaksi1/transferininteroutlet/excel/')?>${data}' ><i class='icon-file-excel' title="Excel"></i></a>&nbsp;
										<a onClick="printPdf(${data})" href="#" ><i class='icon-printer' title="Print"></i></a>&nbsp;
                                        <a href='<?php echo site_url('transaksi1/transferininteroutlet/edit/')?>${data}' ><i class='icon-file-plus2' title="Edit"></i></a>&nbsp;
                                    </div>`;
                                        return rr;
                        }},
                        {"data":"id_grsto_header"},
                        {"data":"grsto_no"},
                        {"data":"po_no"},
                        {"data":"no_doc_gist"},
                        {"data":"delivery_outlet"},
                        {"data":"delivery_date"},
                        {"data":"posting_date"},
                        {"data":"status"},
                        {"data":"created_by"},
                        {"data":"approved_by"},
                        {"data":"last_modified"},
                        {"data":"back"}
                    ]
                });
            }
        
        </script>
	</body>
</html>