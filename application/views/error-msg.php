<style>
.pop_load{
background:#fff; color:#FF0000; font-size:14px; border:solid 2px #CCCCCC; text-align:center; max-width:300px; margin-top:10%;
border-radius:10px; padding:30px;}
.pop_load img{width:100px; height:auto;}
</style>

<div class="modal" style="display:block; background:none; z-index:2000;" ng-show="loading">
	<div class="modal-dialog pop_load">
 		<img src="<?php echo base_url('plugin/images/loading.gif'); ?>" /><p>PLEASE WAIT WHILE PROCESSING</p>
   </div>
</div>
