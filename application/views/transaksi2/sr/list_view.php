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
                    <div class="card">
                        <div class="card-header">
                            <legend class="font-weight-semibold"><i class="icon-search4 mr-2"></i>Search Store Room Request (SR)</legend>  
                        </div>
                        <div class="card-body">
                        <form action="#" method="POST">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Dari Tanggal</label>
                                        <div class="col-lg-3 input-group date">
                                            <input type="text" class="form-control" id="fromDate">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="icon-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <label class="col-lg-2 col-form-label">Sampai Tanggal</label>
                                        <div class="col-lg-4 input-group date">
                                            <input type="text" class="form-control" id="toDate">
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
                                            <select class="form-control form-control-select2" data-live-search="true">
                                                <option value="">none selected</option>
                                                <option value="approved">Approved</option>
                                                <option value="notapproved">Not Approved</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Request To</label>
                                        <div class="col-lg-9">
                                            <select class="form-control form-control-select2" data-live-search="true">
                                                <option value="">none selected</option>
                                                <option value="approved">Approved</option>
                                                <option value="notapproved">Not Approved</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Search<i class="icon-search4  ml-2"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>                        
                    </div> 
                    <div class="card">
                        <div class="card-header">
                            <legend class="font-weight-semibold"><i class="icon-list mr-2"></i>List of Store Room Request (SR)</legend>
                            <a href="<?php echo site_url('transaksi2/sr/add') ?>" class="btn btn-primary"> Add New</a>
                            <input type="button" value="Delete" class="btn btn-danger" id="deleteRecord">
                            <input type="button" value="Export To Excel" class="btn btn-success" id="deleteRecord">  
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12" style="overflow:auto">
                                    <table id="tableWhole" class="table table-striped" style="widht:100%" >
                                        <thead>
                                            <tr>
                                                <th style="text-align: left"><input type="checkbox" name="checkall" id="checkall"></th>
                                                <th style="text-align: center">Action</th>
                                                <th style="text-align: center">ID</th>
                                                <th style="text-align: center">Store Room Request (SR) No</th>
                                                <th style="text-align: center">Request To</th>                                 <th style="text-align: center">Created Date</th>
                                                <th style="text-align: center">Delivery Date</th>
                                                <th style="text-align: center">Request Reason</th>
                                                <th style="text-align: center">Status</th>
                                                <th style="text-align: center">Created by</th>
                                                <th style="text-align: center">Approved by</th>
                                                <th style="text-align: center">Last Modified</th>
                                                <th style="text-align: center">Action</th>
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
                dataTable = $('#tableWhole').DataTable({
                    "ordering":false,  "paging": true, "searching":true,
                    "ajax": {
                        "url":"<?php echo site_url('transaksi2/sr/showAllData');?>",
                        "type":"POST"
                    },
                    "columns": [
                        {"data":"no", "className":"dt-center", render:function(data, type, row, meta){
                            rr=`<input type="checkbox" class="check_delete" id="chk_${data}" value="${data}" onclick="checkcheckbox();">`;
                            return rr;
                        }},
                        {"data":"action", "className":"dt-center", render:function(data, type, row, meta){
                                rr = `<a href='<?php echo site_url('transaksi2/sr/edit')?>' ><i class='icon-file-plus2' title="Edit"></i></a>&nbsp;
                                        <a onClick="deleteConfirm('<?php echo site_url('transaksi2/sr/delete')?>')" href="#!"><i class='icon-printer' title="Delete"></i></a>`;
                                return rr;
                        }},
                        {"data":"id"},
                        {"data":"date"},
                        {"data":"item_no"},
                        {"data":"item_description"},
                        {"data":"quatity"},
                        {"data":"status"},
                        {"data":"created_by"},
                        {"data":"approved_by"},
                        {"data":"receipt_number"},
                        {"data":"issue_number"},
                        {"data":"log"}
                    ]
                });

                // untuk check all
                $("#checkall").click(function(){

                    if($(this).is(':checked')){
                        $(".check_delete").prop('checked', true);
                    }else{
                        $(".check_delete").prop('checked', false);
                    }
                });
                // end check all

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
                                url:"", //masukan url untuk delete
                                type: "post",
                                data:{deleteArr: deleteidArr},
                                success:function(res) {
                                    dataTable.ajax.reload();
                                }
                            });
                        }
                    }
                });

                // ini adalah function versi ES6
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

                $('#fromDate').datepicker();
			    $('#toDate').datepicker();

            });
        
        </script>
	</body>
</html>