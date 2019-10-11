<?php /*?><div ng-show="alertMsg" ng-class="class" class="alert alert-dismissable">
	<button ng-click="alertMsg = false;" class="close" type="button"><i class="ion ion-close-round"></i></button>
	<h4 style="margin:0px;"><i ng-if="class == 'alert-success'" class="icon fa fa-check"></i><i ng-if="class == 'alert-danger'" class="icon fa fa-times"></i> &nbsp; {{ajaxResult}}</h4> 
</div><?php */?>

<div ng-show="alertMsg" class="modal" style="display:block; width:100%; overflow:hidden; top:0px; padding-top:10%; z-index:9999; background:none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div ng-class="class" class="alert alert-success alert-dismissable mb-0">
				<button ng-click="alertMsg = false;" class="close" type="button"><i class="fa fa-times"></i></button>
				<h4 style="margin:0px;"><i class="icon fa fa-check"></i>{{ajaxResult}}</h4> 
			</div>
		</div>
	</div>
</div>

<div ng-show="loader" class="modal text-center" style="display:block; width:100%; overflow:hidden; top:0px; padding-top:20%; z-index:9999;">
	<img src="<?php echo base_url('plugin/assets/images/Preloader_3.gif');?>" width="100px;" />
</div>