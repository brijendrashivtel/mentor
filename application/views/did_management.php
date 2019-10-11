<!doctype html>
<html class="no-js" lang="en"  ng-app="myApp" ng-controller="manageDid" ng-cloak>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Did-Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <?php include("script-head.php"); ?>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
   <script language="JavaScript">
	function selectAll(source) {
		checkboxes = document.getElementsByName('location[]');
		for(var i in checkboxes)
			checkboxes[i].checked = source.checked;
	}
</script>
<script>
$(document).ready(function() {
    var max_fields      = 100000;
    var wrapper         = $(".colmappno"); 
    var add_button      = $(".add_form_field"); 
    
    var x = 1; 
    $(add_button).click(function(e){ 
        e.preventDefault();
        if(x < max_fields){ 
            x++; 
            $(wrapper).append('<div class="row"><div class="col-12 col-sm-1"><div class="form-group"><label></label>&nbsp;</div></div><div class="col-12 col-sm-3"><div class="form-group"><label></label><input type="tel"  maxlength="10"  ng-pattern="/^[0-9]{10,10}$/"  name="mapping[]" class="form-control"/></div></div><div class="col-12 col-sm-4 pr-20"><div class="form-group"><label></label><select class="form-control" name="typee[]" ng-model="list.type"><option value="1">Office Time</option><option value="2">Fallback No.</option><option value="3">Non-Office Time</option><option value="4">Holiday No.</option></select></div></div><div class="col-12 col-sm-4 pr-20"><div class="form-group"><label></label><select class="form-control" name="mdnd[]" ng-model="list.dnd"><option value="1">Enable</option><option value="0">Disable</option></select></div><i class="fa fa-trash delete-icon delete" aria-hidden="true"></i></div></div>'); //add input box
        }
		else
		{
		alert('You Reached the limits')
		}
		$("input[type='tel']").inputFilter(function(value) {
			return /^\d*$/.test(value);
		});
    });
    
    $(wrapper).on("click",".delete", function(e){ 
        e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;
    })
	
	var wrapper2         = $(".container2"); 
    var add_button2      = $(".add_form_field2"); 
    
    var x = 1; 
    $(add_button2).click(function(e){ 
        e.preventDefault();
        if(x < max_fields){ 
            x++; 
            $(wrapper2).append('<div class="row"><div class="col-12 pr-20"><div class="form-group"><label>Fallback Number:</label><input type="tel"  maxlength="10"   ng-pattern="/^[0-9]{10,10}$/"  name="fallback[]" class="form-control"/></div><i class="fa fa-trash delete-icon delete" aria-hidden="true"></i></div></div>'); //add input box
        }
		else
		{
		alert('You Reached the limits')
		}
		$("input[type='tel']").inputFilter(function(value) {
			return /^\d*$/.test(value);
		});
    });
    
    $(wrapper2).on("click",".delete", function(e){ 
        e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;
    })
	
	
	var wrapper3         = $(".container3"); 
    var add_button3      = $(".add_form_field3"); 
    
    var x = 1; 
    $(add_button3).click(function(e){ 
        e.preventDefault();
        if(x < max_fields){ 
            x++; 
            $(wrapper3).append('<div class="row"><div class="col-12 col-sm-6"><div class="form-group"><label>Off Hour Number:</label><input type="tel"  maxlength="10" ng-pattern="/^[0-9]{10,10}$/"  name="offhour[]" class="form-control"/></div></div><div class="col-12 col-sm-6 pr-20"><div class="form-group"><label>DND:</label><select class="form-control" name="odnd[]" ng-model="list.dnd"><option value="1">Enable</option><option value="0">Disable</option></select></div><i class="fa fa-trash delete-icon delete" aria-hidden="true"></i></div></div>'); //add input box
        }
		else
		{
		alert('You Reached the limits')
		}
		$("input[type='tel']").inputFilter(function(value) {
			return /^\d*$/.test(value);
		});
    });
    
    $(wrapper3).on("click",".delete", function(e){ 
        e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;
    })
	
	
	var wrapper4         = $(".container4"); 
    var add_button4      = $(".add_form_field4"); 
    
    var x = 1; 
    $(add_button4).click(function(e){ 
        e.preventDefault();
        if(x < max_fields){ 
            x++; 
            $(wrapper4).append('<div class="row"><div class="col-12 col-sm-6"><div class="form-group"><label>Holiday Number:</label><input type="tel"  maxlength="10" ng-pattern="/^[0-9]{10,10}$/" name="holidayno[]" class="form-control"/></div></div><div class="col-12 col-sm-6 pr-20"><div class="form-group"><label>DND:</label><select class="form-control" name="hdnd[]" ng-model="list.dnd"><option value="1">Enable</option><option value="0">Disable</option></select></div><i class="fa fa-trash delete-icon delete" aria-hidden="true"></i></div></div>'); //add input box
        }
		else
		{
		alert('You Reached the limits')
		}
		$("input[type='tel']").inputFilter(function(value) {
			return /^\d*$/.test(value);
		});
    });
    
    $(wrapper4).on("click",".delete", function(e){ 
        e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;
    });
	$.fn.inputFilter = function(inputFilter) {
		return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
		  if (inputFilter(this.value)) {
			this.oldValue = this.value;
			this.oldSelectionStart = this.selectionStart;
			this.oldSelectionEnd = this.selectionEnd;
		  } else if (this.hasOwnProperty("oldValue")) {
			this.value = this.oldValue;
			this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
		  }
		});
	};
	$("input[type='tel']").inputFilter(function(value) {
		return /^\d*$/.test(value);
	});
});

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
function onlyNum(id) {
	 var $this = $('#'+id);
      $this.val($this.val().replace(/\D/g, ''));
}
</script>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
				<div class="logo">
					<!--<a href="dashboard.html"><img src="assets/images/icon/logo.png" alt="logo"></a>-->
					<a href="dashboard.html">Logo Here</a>
				</div>
			</div>
			
			<div class="main-menu">
	<div class="menu-inner">
		<nav>
		<?php include("leftmenu.php");?>
		</nav>
	</div>
</div>
            
			
        </div>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <!-- page title area start -->
            <?php include("header.php"); ?>
			<?php include_once('alert_message.php');?>
			<div class="modal fade" id="didedit">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">DID Edit</h5>
					<button type="button" class="close"   ng-click="getReverse();"><span>&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="single-table">
						<div class="col-md-12">
							<div class="container1">
								<div class="form-group">
									<label>DID:</label>
									<input type="tel" class="form-control"  numbers-only  name="didnumber"   maxlength="10" required ng-model="didedit.did">
								</div>
								<div class="form-group">
									<label>DID Status:</label>
									<select class="form-control" required  ng-model="didedit.did_status"><option value="1">Enable</option><option value="0">Disable</option></select>
								</div>
							    <div class="form-group">
									<label>DID CLI:</label>
									<input type="tel" class="form-control" numbers-only maxlength="10"  required ng-model="didedit.did_cli">
								</div>
								<div class="form-group">
									<label>Call Recording:</label>
									<select class="form-control" required  ng-model="didedit.call_recording"><option value="1">Enable</option><option value="0">Disable</option></select>
								</div>
								<div class="form-group">
									<label>Holiday Check:</label>
									<select class="form-control" required  ng-model="didedit.holiday_check"><option value="1">Enable</option><option value="0">Disable</option></select>
								</div>
								<div class="form-group">
									<label>Time Group Check:</label>
									<select class="form-control" required  ng-model="didedit.timegroupid"><option value="">---Select---</option><option ng-repeat="listt in timegroup" value="{{listt.id}}">{{listt.name}}</option></select>
								</div>
								
								<div class="form-group">
									<label>OffTime_destination_type:</label>
									<select class="form-control" required  ng-model="didedit.OffTime_destination_type"><option value="">---Select---</option><option value="dial">dial</option><option value="playback">playback</option><option value="hangup">hangup</option></select>
								</div>
								
								<div class="form-group">
									<label>OffTime_destination_type_value:</label>
									<span ng-if="didedit.OffTime_destination_type!='playback'"><input type="text" class="form-control" ng-model="didedit.OffTime_destination_type_value"></span>
									<span ng-if="didedit.OffTime_destination_type=='playback'"><select class="form-control" ng-model="didedit.OffTime_destination_type_value"><option value="">---Select---</option><option ng-repeat="listt in promptdetails" value="{{listt.file}}">{{listt.name}}</option></select></span>
								</div>
								
								<div class="form-group">
									<label>Holiday_destination_type:</label>
									<select class="form-control" ng-model="didedit.holiday_destination_type"><option value="">---Select---</option><option value="dial">dial</option><option value="playback">playback</option><option value="hangup">hangup</option></select>
								</div>
								
								<div class="form-group">
									<label>Holiday_destination_type_value:</label><span ng-if="didedit.holiday_destination_type!='playback'"><input type="text" class="form-control" ng-model="didedit.holiday_destination_type_value"></span>
									<span ng-if="didedit.holiday_destination_type=='playback'"><select class="form-control" ng-model="didedit.holiday_destination_type_value"><option value="">---Select---</option><option ng-repeat="listt in promptdetails" value="{{listt.file}}">{{listt.name}}</option></select></span>
								</div>
							</div>
						</div>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-rounded btn-secondary"   ng-click="getReverse();">Close</button>
					<button type="button" ng-click="getDIDEditUpdate(didedit);" class="btn btn-rounded btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="hyperlink-1">
		<div class="modal-dialog modal-dialog-centered  modal-md  modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Call Mapping No. - {{selecteddid}}</h5>
					<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="single-table">
						<div class="col-md-12">
							<div class="colmappno">
								<div class="row" >
									<div class="col-12 col-sm-1">
										<div class="form-group">
											<label>SNo</label>
											&nbsp;
										</div>
									</div>
									<div class="col-12 col-sm-3">
										<div class="form-group">
											<label>Number:</label>
											&nbsp;
										</div>
									</div>
									<div class="col-12 col-sm-4 pr-20">
										<div class="form-group">
											<label>Type:</label>&nbsp;
										</div>
									</div>
									<div class="col-12 col-sm-4 pr-20">
										<div class="form-group">
											<label>Status:</label>&nbsp;
										</div>
									</div>
								</div>
								<div class="row" ng-repeat="list in callforwdlist track by $index">
									<div class="col-12 col-sm-1">
										<div class="form-group">
											<label>{{$index+1}}</label>
										</div>
									</div>
									<div class="col-12 col-sm-3">
										<div class="form-group">
											
											<input type="tel" id="map-id-{{$index}}" onChange="onlyNum(this.id)" name="mapping[]" numbers-only ng-value="list.number"  maxlength="10" class="form-control">
										</div>
									</div>
									<div class="col-12 col-sm-4 pr-20">
										<div class="form-group">
											<select class="form-control" name="typee[]" ng-model="list.type"><option value="1">Office Time</option><option value="2">Fallback No.</option><option value="3">Non-Office Time</option><option value="4">Holiday No.</option></select>
										</div>
									</div>
									<div class="col-12 col-sm-4 pr-20">
										<div class="form-group">
											
											<select class="form-control" name="mdnd[]" ng-model="list.dnd"><option value="1">Enable</option><option value="0">Disable</option></select>
										</div>
										<i class="fa fa-trash delete-icon mb-0" aria-hidden="true" ng-click="getDeleteCommon('cm',list.number);"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="w-100 mt-3">
                       <button type="button" class="add_form_field btn btn-rounded btn-secondary">Add New No.</button>
                    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-rounded btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" ng-click="ffffffffffff();" class="btn btn-rounded btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="fallbacklist">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Fallback No.</h5>
					<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="single-table">
						<div class="col-md-12">
							<div class="container2">
								<div class="row" ng-repeat="list in callfallbacklist track by $index">
									<div class="col-12 pr-20">
										<div class="form-group">
											<label>Fallback Number:</label>
											<input type="tel" id="fallback-id-{{$index}}" onChange="onlyNum(this.id)" name="fallback[]" numbers-only  maxlength="10" ng-value="list.number" class="form-control">
										</div>
										<i class="fa fa-trash delete-icon mb-0" aria-hidden="true" ng-click="getDeleteCommon('fb',list.number);"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="w-100 mt-3">
                       <button type="button" class="add_form_field2 btn btn-rounded btn-secondary">Add New No.</button>
                    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-rounded btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" ng-click="fallbacklistupdate();" class="btn btn-rounded btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="offhourlist">
		<div class="modal-dialog modal-dialog-centered modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Off Hour No.</h5>
					<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="single-table">
						<div class="col-md-12">
							<div class="container3">
								<div class="row" ng-repeat="list in offhourslist track by $index">
									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Off Hour Number:</label>
											<input type="tel" name="offhour[]" id="offhour-id-{{$index}}" onChange="onlyNum(this.id)" numbers-only  maxlength="10" ng-value="list.number" class="form-control">
										</div>
									</div>
									<div class="col-12 col-sm-6 pr-20">
										<div class="form-group">
											<label>DND:</label>
											<select class="form-control" name="odnd[]" ng-model="list.dnd"><option value="1">Enable</option><option value="0">Disable</option></select>
										</div>
										<i class="fa fa-trash delete-icon mb-0" aria-hidden="true" ng-click="getDeleteCommon('fh',list.number);"></i>
									</div>
								</div>	
							</div>
						</div>
					</div>
					<div class="w-100 mt-3">
                       <button type="button" class="add_form_field3 btn btn-rounded btn-secondary">Add New No.</button>
                    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-rounded btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" ng-click="OffHourListupdate();" class="btn btn-rounded btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="holidaynolist">
		<div class="modal-dialog modal-dialog-centered modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Holiday No.</h5>
					<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="single-table">
						<div class="col-md-12">
							<div class="container4">
								<div class="row" ng-repeat="list in holidaysnolist track by $index">
									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Holiday Number:</label>
											<input type="tel" name="holidayno[]" id="holiday-id-{{$index}}" onChange="onlyNum(this.id)" maxlength="10" numbers-only  ng-value="list.number" class="form-control">
										</div>
									</div>
									<div class="col-12 col-sm-6 pr-20">
										<div class="form-group">
											<label>DND:</label>
											<select class="form-control" name="hdnd[]" ng-model="list.dnd"><option value="1">Enable</option><option value="0">Disable</option></select>
										</div>
										<i class="fa fa-trash delete-icon mb-0" aria-hidden="true" ng-click="getDeleteCommon('hn',list.number);"></i>
									</div>
								</div>	
							</div>
						</div>
					</div>
					<div class="w-100 mt-3">
                       <button type="button" class="add_form_field4 btn btn-rounded btn-secondary">Add New No.</button>
                    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-rounded btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" ng-click="HolidayListupdate();" class="btn btn-rounded btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>
            <!-- page title area end -->
            <div class="main-content-inner">
				<div class="row">
					<div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body pb-0 text-right">
                                <button type="button" class="btn btn-rounded btn-secondary mb-4" data-toggle="modal" ng-click="getAddDID();" >Add List</button>
								<!--<button type="button" class="btn btn-rounded btn-secondary mb-4 ml-3" data-toggle="modal" data-target="#removedid">Remove List</button>-->
								<button type="button" onClick="sampleDidManagementCsv()" class="btn btn-rounded btn-secondary mb-4 ml-3">Download Sample</button>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="row">
                    <!-- Dark table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">DID List</h4>
								<div class="row" id="custHeader">
									<div class="col-12 col-sm-6 lbl-center">
										<label>
											Show 
											<select class="form-control d-inline-block w-auto mr-1 ml-1" ng-model="pageSize">
												<option ng-repeat="sel in selectables" ng-selected="pageSize == sel.value" value="{{sel.value}}">{{sel.value}}</option>
											</select>
											entries
										</label>
									</div>
									<div class="col-12 col-sm-6 custS">
										<div class="input-group sinp m-auto-search mw-250 mb-2">
											<input type="text" class="form-control pull-right" ng-model="keywords" ng-change="getdidList()" placeholder="Search DID">
											<div class="input-group-addon br-t-r p-t-b-12 border-left-0" ng-click="getdidList()"><i class="fa fa-search"></i></div>
										</div>
									</div>
								</div>
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead class="text-capitalize">
                                            <tr>
                                                <th style="min-width: 100px" ng-click="sort('slno')"><label class="checkbox-container"><input type="checkbox"  id="selectall"  onClick="selectAll(this)" ><span class="checkmark"></span></label>
												Sr. No.</th>
												<th style="min-width: 100px" ng-click="sort('slno')">Action</th>
                                                <th ng-click="sort('didno')">DID No.<span class="glyphicon sort-icon" ng-show="sortKey=='didno'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('didstatus')">DID Status<span class="glyphicon sort-icon" ng-show="sortKey=='didstatus'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('didcli')">DID CLI<span class="glyphicon sort-icon" ng-show="sortKey=='didcli'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('callrecord')">Call Recording<span class="glyphicon sort-icon" ng-show="sortKey=='callrecord'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('mapped')">Mapped No.<span class="glyphicon sort-icon" ng-show="sortKey=='mapped'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<!--<th ng-click="sort('falback')">Fallback No.<span class="glyphicon sort-icon" ng-show="sortKey=='falback'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('offhurno')">Off Hour No.<span class="glyphicon sort-icon" ng-show="sortKey=='offhurno'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('hno')">Holiday No.<span class="glyphicon sort-icon" ng-show="sortKey=='hno'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>-->
												<th ng-click="sort('hcheck')">Holiday Check<span class="glyphicon sort-icon" ng-show="sortKey=='hcheck'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
                                                <th ng-click="sort('timegroupid')">TimeGroupId<span class="glyphicon sort-icon" ng-show="sortKey=='timegroupid'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
                                                <th ng-click="sort('offtime')">OffTime Destination Type<span class="glyphicon sort-icon" ng-show="sortKey=='offtime'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
                                                <th ng-click="sort('offtimedt')">OffTime Destination Type Value<span class="glyphicon sort-icon" ng-show="sortKey=='offtimedt'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('holiday')">Holiday Destination Type<span class="glyphicon sort-icon" ng-show="sortKey=='holiday'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
                                                <th ng-click="sort('holtype')">Holiday Destination Type Value<span class="glyphicon sort-icon" ng-show="sortKey=='holtype'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr  dir-paginate="list in didlist|orderBy:sortKey:reverse|itemsPerPage:pageSize"  total-items="totalCount"  ng-click="selectedRow($index,list);" ng-class="{activeRow : selRow == $index}">
                                                <td>{{$index+1}}<label class="checkbox-container"><input type="checkbox"  name="location[]" value="{{list.did}}"><span class="checkmark"></span></label></td>
												<td><a ng-click="getDidEdit(list);"><i class="fa fa-edit"></i></a><a ng-click="getDidDelete(list.id);" ><i class="fa fa-trash"></i></a></td>
                                                <td>{{list.did}}</td>
												<td><span ng-if="list.did_status==1">Enable</span><span ng-if="list.did_status==0">Disable</span></td>
												<td class="editable">{{list.did_cli}}</td>
												<td><span ng-if="list.call_recording==1">Enable</span><span ng-if="list.call_recording==0">Disable</span></td>
												<td><a href="javascript:void(0)"  ng-click="getMappedList(list.did);">{{list.allcount}}</i></a></td>
												<!--<td><a href="javascript:void(0)"  ng-click="getFallbackList(list.did);">{{list.fcount}}</a></td>
												<td><a href="javascript:void(0)"  ng-click="getOffHourList(list.did);">{{list.offcount}}</a></td>
												<td><a href="javascript:void(0)"  ng-click="getHolidayList(list.did);">{{list.hcount}}</a></td>-->
                                                <td><span ng-if="list.holiday_check==1">Enable</span><span ng-if="list.holiday_check==0">Disable</span></td>
                                                <td>{{list.timegroupid}}</td>
                                                <td>{{list.OffTime_destination_type}}</td>
												<td>{{list.OffTime_destination_type_value}}</td>
												<td>{{list.holiday_destination_type}}</td>
												<td>{{list.holiday_destination_type_value}}</td>
                                            </tr>
                                           
                                        </tbody>
                                    </table>
									<div class="row mr-0 ml-0 mb-3 align-items-center">
										<div class="col-md-6 pl-0 pr-0 pr-md-3 paginatin-center">
											<div role="status" id="example_info" class="dataTables_info"  ng-if="totalCount > pageSize" >Showing  {{startval}} to {{endval}} of {{totalCount}} entries</div>
										</div>
										<div class="col-md-6 pr-0 pl-0 pl-md-3 mt-2 mt-md-0 paginatin-center">
											<div id="example_paginate" class="dataTables_paginate paging_simple_numbers">
												<dir-pagination-controls max-size="8" direction-links="true" boundary-links="true" on-page-change="pageData(newPageNumber)"> </dir-pagination-controls>
											</div>
										</div>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Dark table end -->
					<div class="col-12 mt-3 text-right">
					   <button type="button" class="btn btn-rounded btn-secondary mb-2 mr-2" ng-click="didbulkDelete();">Bulk Delete</button>
                       <button type="button" class="btn btn-rounded btn-secondary mb-2" ng-click="csvvvvvvv();">Export CSV</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- main content area end -->
    </div>
	
	
	<!-- Add did popup here -->
	<div class="modal fade" id="adddid">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add / Delete Did List</h5>
					<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="form-row align-items-center">
						<div class="col-12">
							<form method="post" enctype="multipart/form-data">
								<div class="position-relative">
									<a class='btn btn-rounded btn-primary position-relative' href='javascript:void(0);'>
										Choose File...
										<input type="file" file-model="files" class="file-upload" name="input-file-preview"  size="40"  onchange='$("#upload-file-info").html($(this).val());'/> 
									</a>
									&nbsp;
									<span class='badge badge-pill badge-primary' id="upload-file-info"></span>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-rounded btn-primary"  ng-click="didDeleteUpload(record,'ajaxResult');">Delete DID List</button>
					<button type="button" class="btn btn-rounded btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-rounded btn-primary"  ng-click="didCreate(record,'ajaxResult');">Upload DID List</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Remove did popup here -->
	<!--<div class="modal fade" id="removedid">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Remove Did List</h5>
					<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="form-row align-items-center">
						<div class="col-12">
							<form>
								<div class="position-relative">
									<a class='btn btn-rounded btn-primary' href='javascript:;'>
										Choose File...
										<input type="file" class='file-upload' name="file_source_remove" size="40"  onchange='$("#upload-file-remove").html($(this).val());'>
									</a>
									&nbsp;
									<span class='badge badge-pill badge-primary' id="upload-file-remove"></span>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-rounded btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-rounded btn-primary">Submit</button>
				</div>
			</div>
		</div>
	</div> -->
	
  <?php include("footer.php"); ?>
  <script>

$('input').bind('keypress paste', function (event) 
{
var regex = /^[a-zA-Z0-9%()#@_& -]+$/;
var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
if (!regex.test(key)) {
   event.preventDefault();
   return false;
}
});

/*$.fn.inputFilter = function(inputFilter) {
		return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
		  if (inputFilter(this.value)) {
			this.oldValue = this.value;
			this.oldSelectionStart = this.selectionStart;
			this.oldSelectionEnd = this.selectionEnd;
		  } else if (this.hasOwnProperty("oldValue")) {
			this.value = this.oldValue;
			this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
		  }
		});
	};*/
</script>
<script>
	/*$("[name='mapping[]'],[name='didnumber']").inputFilter(function(value) {
		return /^\d*$/.test(value);
	});*/
	</script>
</body>
</html>
