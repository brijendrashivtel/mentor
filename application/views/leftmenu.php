

<ul class="metismenu" id="menu">
	<li>
		<a href="dashboard.html"><i class="ti-dashboard"></i><span>Dashboard</span></a>
	</li>
	<li class="active">
		<a href="<?php echo base_url('did_management');?>"><i class="ti-layers-alt"></i><span>DID Management</span></a>
	</li>
	<li>
		<a href="<?php echo base_url('timegroup');?>"><i class="fa fa-align-left"></i><span>Time Group</span></a>
	</li>
	<li>
		<a href="javascript:void(0)" aria-expanded="true"><i class="ti-layout-sidebar-left"></i> <span>Blacklist Management</span></a>
		<ul class="collapse">
			<li><a href="<?php echo base_url('did_block');?>">DID Wise Blocking</a></li>
			<!--<li><a href="globalblocking.html">Global Blocking</a></li>-->
		</ul>
	</li>
	<li>
		<a href="javascript:void(0)" aria-expanded="true"><i class="ti-layout-sidebar-left"></i> <span>Prompt Management</span></a>
		<ul class="collapse">
			<li><a href="<?php echo base_url('timegroup/prompt');?>">Prompt</a></li>
			<!--<li><a href="globaloffhour.html">Global Offhour Prompt</a></li>-->
		</ul>
	</li>
	<li>
		<a href="<?php echo base_url('holiday');?>"><i class="fa fa-align-left"></i><span>Holiday Management</span></a>
	</li>
	<li>
		<a href="<?php echo base_url('cdr/report');?>"><i class="fa fa-table"></i><span>Answered Report</span></a>
	</li>
	<li>
		<a href="<?php echo base_url('cdr/unanswered');?>"><i class="fa fa-table"></i><span>Unanswered Call Report</span></a>
	</li>
	<li>
		<a href="<?php echo base_url('cdr');?>"><i class="ti-volume"></i><span>Recording</span></a>
	</li>
</ul>