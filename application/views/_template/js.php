<!-- Theme JS files -->
<script src="<?php echo base_url('/files/');?>global_assets/js/plugins/visualization/d3/d3.min.js"></script>
<script src="<?php echo base_url('/files/');?>global_assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
<script src="<?php echo base_url('/files/');?>global_assets/js/plugins/forms/styling/switchery.min.js"></script>
<script src="<?php echo base_url('/files/');?>global_assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
<script src="<?php echo base_url('/files/');?>global_assets/js/plugins/ui/moment/moment.min.js"></script>
<script src="<?php echo base_url('/files/');?>global_assets/js/plugins/pickers/daterangepicker.js"></script>


<script src="<?php echo base_url('/files/');?>assets/js/app.js"></script>
<script src="<?php echo base_url('/files/');?>global_assets/js/demo_pages/dashboard.js"></script>
<script src="<?php echo base_url('/files/');?>global_assets/js/demo_pages/form_multiselect.js"></script>
<!-- /theme JS files -->

<!-- dataTable -->
<script src="<?php echo base_url('/files/');?>global_assets/js/dataTable/jquery.dataTables.min.js"></script>
<!-- /dataTable-->

<script src="<?php echo base_url('/files/');?>global_assets/js/plugins/datepicker/bootstrap-datepicker.js"></script>


<!-- SweetAlert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- /SweetAlert -->

<script>
$(function(){
    var current = location.pathname;
    $('#nav li a').each(function(){
        
        const $this = $(this);
        // console.log($this);
        if($this.attr('href').indexOf(current) !== -1){
            $this.parents('li.nav-item-submenu').addClass('nav-item-open');
            $this.parents('ul.nav-group-sub').css("display","block");
            $this.addClass('active');
        }
    });
}

)
</script>