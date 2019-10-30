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
                            <legend class="font-weight-semibold"><i class="icon-search4 mr-2"></i>Search of Produksi</legend>  
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
                            <legend class="font-weight-semibold"><i class="icon-list mr-2"></i>List of Produksi</legend>
                            <a href="<?php echo site_url('transaksi1/wo/add') ?>" class="btn btn-primary"> Add New</a>
                            <input type="button" value="Delete" class="btn btn-danger" id="deleteRecord">  
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
                                                <th style="text-align: center">Date</th>
                                                <th style="text-align: center">Item No</th>
                                                <th style="text-align: center">Item Description</th>
                                                <th style="text-align: center">Quantity</th>
                                                <th style="text-align: center">Status</th>
                                                <th style="text-align: center">Created by</th>
                                                <th style="text-align: center">Approved by</th>
                                                <th style="text-align: center">Receipt Number</th>
                                                <th style="text-align: center">Issue Number</th>
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
				$.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings){
					return {
						"iStart": oSettings._iDisplayStart,
						"iEnd": oSettings.fnDisplayEnd(),
						"iLength": oSettings._iDisplayLength,
						"iTotal": oSettings.fnRecordsTotal(),
						"iFilteredTotal": oSettings.fnRecordsDisplay(),
						"iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
						"iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
					};
				};

                dataTable = $('#tableWhole').DataTable({
					"initComplete": function() {
                        var api = this.api();
                        $('#mytable_filter input')
                                .off('.DT')
                                .on('keyup.DT', function(e) {
                                    if (e.keyCode == 13) {
                                        api.search(this.value).draw();
                            }
                        });
                    },
                    "ordering":false,  "paging": true, "searching":true, "serverSide": true,
                    "ajax": {
                        "url":"<?php echo site_url('transaksi1/wo/showAllData');?>",
                        "type":"POST"
                    },
                    "columns": [
                        {"data":"id_produksi_header", "className":"dt-center", render:function(data, type, row, meta){
                            rr=`<input type="checkbox" class="check_delete" id="chk_${data}" value="${data}" onclick="checkcheckbox();">`;
                            return rr;
                        }},
                        {"data":"id_produksi_header", "className":"dt-center", render:function(data, type, row, meta){
                                rr = `<a href='<?php echo site_url('transaksi1/wo/edit')?>' ><i class='icon-file-plus2' title="Edit"></i></a>`;
                                return rr;
                        }},
                        {"data":"id_produksi_header"},
                        {"data":"kode_paket"},
                        {"data":"nama_paket"},
                        {"data":"posting_date"},
                        {"data":"status"},
                        {"data":"user_input"},
                        {"data":"user_approve"},
                        {"data":"lastmodified"},
                        {"data":"produksi_no"},
                        {"data":"doc_issue"},
                        {"data":"log"}
                    ],
					"order": [[1, 'asc']],
					 "rowCallback": function(row, data, iDisplayIndex) {
                        var info = this.fnPagingInfo();
                        var page = info.iPage;
                        var length = info.iLength;
                        var index = page * length + (iDisplayIndex + 1);
                        $('td:eq(0)', row).html(index);
                    }
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

            });
        
        </script>
	</body>
</html>