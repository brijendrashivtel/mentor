<!doctype html>
<html class="no-js" lang="en"  ng-app="myApp" ng-controller="cdrreport" ng-cloak>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Report-Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <?php include("script-head.php"); ?>
   <script>
   var tableToExcel = (function() {
	  var uri = 'data:application/vnd.ms-excel;base64,'
		, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
		, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
		, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
	  return function(table, name) {
		if (!table.nodeType) table = document.getElementById(table)
		var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
		window.location.href = uri + base64(format(template, ctx))
	  }
	})()
	function closeModal(){
		$('#getCLIDBlock').hide()
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
            <!-- page title area end -->
            <div class="main-content-inner">
				<div class="row">
					<div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
								<div class="form-row align-items-center">
									<div class="col-lg-11">
										<div class="form-row align-items-center">
											<div class="col-sm-6 col-md-3 my-2">
												<div class="form-gp mb-0">
													<label for="startdate">Start Date</label>
													<input type="text" id="startdate" class="datepicker-here" ng-model="sdate" data-language='en' autocomplete="off"  data-date-format="yyyy-mm-dd">
													<i class="ti-calendar"><label for="startdate" class="w-18-h-18"></label></i>
												</div>
											</div>
											<div class="col-sm-6 col-md-3 my-2">
												<div class="form-gp mb-0">
													<label for="enddate">End Date</label>
													<input type="text" id="enddate" class="datepicker-here" ng-model="edate" autocomplete="off"  data-language='en'   data-date-format="yyyy-mm-dd">
													<i class="ti-calendar"><label for="enddate" class="w-18-h-18"></label></i>
												</div>
											</div>
											<div class="col-sm-6 col-md-3 my-2">
												<div class="form-gp mb-0">
													<select ng-model="disposition" id="disposition">
														<option value="">Select Call Patch Status</option>
														<option value="ANSWER">ANSWERED</option>
														<option value="NOANSWER">NO ANSWER</option>
														<option value="BUSY">BUSY</option>
														<option value="FAILED">FAILED</option>
													</select>
												</div>
											</div>
											<div class="col-sm-6 col-md-3 my-2">
												<div class="form-gp mb-0">
													<label for="number">CP Number/ DNID / Caller No</label>
													<input type="text" id="number" autocomplete="off"  nbumber-only ng-model="sd" >
												</div>
											</div>
										</div>
									</div>
									<div class="col-auto pr-0">
										<button type="button" class="btn btn-rounded btn-secondary" ng-click="getReportdidList();">Search</button>
									</div>
								</div>
							</div>
                        </div>
                    </div>
				</div>
                <div class="row">
                    <!-- Dark table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Report List</h4>
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
										<!--<div class="input-group sinp m-auto-search mw-250 mb-2">
											<input type="text" class="form-control pull-right" ng-model="keywords" ng-change="getdidList()" placeholder="Search TimeGroupName">
											<div class="input-group-addon pointer" ng-click="getdidList()"><i class="fa fa-search"></i></div>
										</div>-->
										<input type="button" onClick="tableToExcel('testTable1', 'W3C Example Table')" ng-click="noprint==true;" class="btn btn-rounded btn-primary pull-right" value="Export to Excel">
									</div>
								</div>
								<div class="table-responsive ">
									<table class="table text-center"  id="testTable">
										<thead class="text-capitalize">
											<tr>
												<th ng-click="sort('slno')">Sr. No.<span class="glyphicon sort-icon" ng-show="sortKey=='slno'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('date')">Date<span class="glyphicon sort-icon" ng-show="sortKey=='date'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('CLID')">Caller No<span class="glyphicon sort-icon" ng-show="sortKey=='CLID'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												
												<th ng-click="sort('opc')">Operator Circle<span class="glyphicon sort-icon" ng-show="sortKey=='opc'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('stime')">Start Time<span class="glyphicon sort-icon" ng-show="sortKey=='stime'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												
												<th ng-click="sort('cptime')">CP Time<span class="glyphicon sort-icon" ng-show="sortKey=='cptime'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('cpdur')">CP Duration<span class="glyphicon sort-icon" ng-show="sortKey=='cpdur'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('cpstatus')">CP Status<span class="glyphicon sort-icon" ng-show="sortKey=='cpstatus'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('cpno')">CP No<span class="glyphicon sort-icon" ng-show="sortKey=='cpno'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												
												<th ng-click="sort('src')">DNID<span class="glyphicon sort-icon" ng-show="sortKey=='src'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('nonoffice')">Office /Non Office<span class="glyphicon sort-icon" ng-show="sortKey=='nonoffice'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('record')">Recording<span class="glyphicon sort-icon" ng-show="sortKey=='record'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('duration')">Duration <span class="glyphicon sort-icon" ng-show="sortKey=='duration'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('rduration')">Ring Duration<span class="glyphicon sort-icon" ng-show="sortKey=='rduration'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('dreason')">Disconnection Reason<span class="glyphicon sort-icon" ng-show="sortKey=='dreason'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												
												<th ng-click="sort('blc')">BLC <span class="glyphicon sort-icon" ng-show="sortKey=='blc'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
											</tr>
										</thead>
										<tbody>
											<tr  dir-paginate="list in didlist|orderBy:sortKey:reverse|itemsPerPage:pageSize"   ng-click="selectedRow($index,list);" ng-class="{activeRow : selRow == $index}" total-items="totalCount">
												<td>{{$index+1}}</td>
												<td>{{list.calldate}}</td>
												<td>{{list.clid}}</td>
												<td></td>
												<td>{{list.start}}</td>
												<td>{{list.answer}}</td>
												<td>{{list.billsec}}</td>
												<td><a href="#" ng-click="getCDRIndetail(list.uniqueid);">{{list.disposition}}</a></td>
												<td>{{list.cpno}}</td>
												<td>{{list.src}}</td>
												<td></td>
												<td><span ng-hide="noprint"><a title="Recording Download"  target="_blank" href="http://112.196.109.66:8181/recording/{{list.recording}}.wav"><i class="fa fa-download"></i></a>&nbsp;<a href="javascript:;" ng-if="list.recording != ''" ng-click="voiceMailPlay(list.recording);" title="Recording Play"><i class="fa fa-play" aria-hidden="true"></i></a></span><span ng-show="noprint"></span></td>
												<td>{{list.duration}}</td>
												<td>{{list.billsecs}}</td>
												<td>{{list.HangUpCauseCode}}</td>
												
												<td>
												<span ng-if="list.block=='Y'"><i ng-click="getCLIDBlock(list.clid,list.src,'B');" class="fa fa-check" style="color:#006600" aria-hidden="true"></i></span>
												<span ng-if="list.block=='N'"><i ng-click="getCLIDUnBlock(list.clid,list.src,'U');" class="fa fa-times" style="color:#FF0000" aria-hidden="true"></i></span>
												</td>
											</tr>
										   
										</tbody>
									</table>
									
									<table class="table text-center" style="display:none"  id="testTable1">
										<thead class="text-capitalize">
											<tr>
												<th ng-click="sort('slno')">Sr. No.<span class="glyphicon sort-icon" ng-show="sortKey=='slno'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('date')">Date<span class="glyphicon sort-icon" ng-show="sortKey=='date'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('CLID')">Caller No<span class="glyphicon sort-icon" ng-show="sortKey=='CLID'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('opc')">Operator Circle<span class="glyphicon sort-icon" ng-show="sortKey=='opc'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('stime')">Start Time<span class="glyphicon sort-icon" ng-show="sortKey=='stime'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												
												<th ng-click="sort('cptime')">CP Time<span class="glyphicon sort-icon" ng-show="sortKey=='cptime'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('cpdur')">CP Duration<span class="glyphicon sort-icon" ng-show="sortKey=='cpdur'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('cpstatus')">CP Status<span class="glyphicon sort-icon" ng-show="sortKey=='cpstatus'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('cpno')">CP No<span class="glyphicon sort-icon" ng-show="sortKey=='cpno'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												
												<th ng-click="sort('src')">DNID<span class="glyphicon sort-icon" ng-show="sortKey=='src'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('nonoffice')">Office /Non Office<span class="glyphicon sort-icon" ng-show="sortKey=='nonoffice'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('record')">Recording<span class="glyphicon sort-icon" ng-show="sortKey=='record'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('duration')">Duration <span class="glyphicon sort-icon" ng-show="sortKey=='duration'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('rduration')">Ring Duration<span class="glyphicon sort-icon" ng-show="sortKey=='rduration'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('dreason')">Disconnection Reason<span class="glyphicon sort-icon" ng-show="sortKey=='dreason'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('blc')">BLC <span class="glyphicon sort-icon" ng-show="sortKey=='blc'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
											</tr>
										</thead>
										<tbody>
											<tr  dir-paginate="list in didlist|orderBy:sortKey:reverse|itemsPerPage:pageSize"   ng-click="selectedRow($index,list);" ng-class="{activeRow : selRow == $index}" total-items="totalCount">
												<td>{{$index+1}}</td>
												<td>{{list.calldate}}</td>
												<td>{{list.clid}}</td>
												<td></td>
												<td>{{list.start}}</td>
												<td>{{list.answer}}</td>
												<td>{{list.billsec}}</td>
												<td>{{list.disposition}}</td>
												<td>{{list.cpno}}</td>
												<td>{{list.src}}</td>
												<td></td>
												<td>http://112.196.109.66:8181/recording/{{list.recording}}.wav</td>
												<td>{{list.billsec}}</td>
												<td>{{list.billsecs}}</td>
												<td>{{list.HangUpCauseCode}}</td>
												<td>
												<span ng-if="list.block=='Y'"><i ng-click="getCLIDBlock(list.clid,list.src,'B');" class="fa fa-check" style="color:#006600" aria-hidden="true"></i></span>
												<span ng-if="list.block=='N'"><i ng-click="getCLIDUnBlock(list.clid,list.src,'U');" class="fa fa-times" style="color:#FF0000" aria-hidden="true"></i></span>
												</td>
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
                       <!--<button type="button" class="btn btn-rounded btn-secondary mb-4"   ng-click="csvvvvvvv();">Export CSV</button>-->
                    </div>
                </div>
            </div>
        </div>
        <!-- main content area end -->
    </div>
	
	<div id="voicemaillisten" class="modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Recording Play</h4>
					<button type="button" class="close" ng-click="closeActionNew();" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body text-center">
					<div class="row"><div class="col-md-12" id="extplay"></div></div>
				</div>
				<div class="modal-footer text-center" style="text-align:center !important;">
					<button type="submit" ng-click="closeActionNew();" class="btn btn-warning">Cancel</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Add did popup here -->
	<div class="modal fade" id="cdrlist">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">CDR List</h5>
					<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="form-row align-items-center">
						<div class="col-12">
								<div class="table-responsive ">
						<table class="table text-center">
							<thead class="text-capitalize">
								<tr>
									<th ng-click="sort('slno')">Sr. No.<span class="glyphicon sort-icon" ng-show="sortKey=='slno'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
									<th ng-click="sort('date')">Date<span class="glyphicon sort-icon" ng-show="sortKey=='date'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
									<th ng-click="sort('CLID')">Caller No<span class="glyphicon sort-icon" ng-show="sortKey=='CLID'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
									<th ng-click="sort('src')">SRC<span class="glyphicon sort-icon" ng-show="sortKey=='src'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
									<th ng-click="sort('dst')">DST<span class="glyphicon sort-icon" ng-show="sortKey=='dst'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
									<th ng-click="sort('billsec')">Bill Sec<span class="glyphicon sort-icon" ng-show="sortKey=='billsec'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
									<th ng-click="sort('disposition')">Disposition<span class="glyphicon sort-icon" ng-show="sortKey=='disposition'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
									<th >Recording</th>
								</tr>
							</thead>
							<tbody>
								<tr  ng-repeat="list in indetaildidlist"   ng-click="selectedRow($index,list);" ng-class="{activeRow : selRow == $index}" total-items="totalCount">
									<td>{{$index+1}}</td>
									<td>{{list.calldate}}</td>
									<td>{{list.clid}}</td>
									<td>{{list.src}}</td>
									<td>{{list.dst}}</td>
									<td>{{list.billsec}}</td>
									<td>{{list.disposition}}</td>
									<td><a title="Recording Download"  target="_blank" href="http://112.196.109.66:8181/recording/{{list.recording}}.wav"><i class="fa fa-download"></i></a>&nbsp;<a href="javascript:;" ng-if="list.recording != ''" ng-click="voiceMailPlay(list.recording);" title="Recording Play"><i class="fa fa-play" aria-hidden="true"></i></a></td>
								</tr>
							   
							</tbody>
						</table>
						<div class="col-md-12">
							<div class="col-md-6">
							<div role="status" id="example_info" class="dataTables_info"  ng-if="totalCount > pageSize" >Showing  {{startval}} to {{endval}} of {{totalCount}} entries</div>
							</div>
							<div class="col-md-6">
							<div id="example_paginate" class="dataTables_paginate paging_simple_numbers">
								<dir-pagination-controls max-size="8" direction-links="true" boundary-links="true" on-page-change="pageData(newPageNumber)"> </dir-pagination-controls>
							</div>
							</div>
						</div>
					</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-rounded btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Remove did popup here -->
	<div class="modal fade" id="removedid">
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
	</div>
	<!-- HyperLink popup here -->
	<div class="modal fade" id="hyperlink-1">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Call Mapping No.</h5>
					<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="single-table">
						<div id="table" class="table-editable">
							<table class="table text-center">
								<thead class="text-uppercase bg-dark">
									<tr class="text-white">
										<th scope="col">Phone No.</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td contenteditable='true'>1234567890</td>
									</tr>
									<tr>
										<td contenteditable='true'>1234567890</td>
									</tr>
									<tr>
										<td contenteditable='true'>1234567890</td>
									</tr>
									<tr>
										<td contenteditable='true'>1234567890</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="w-100 mt-3">
                        <div class="form-gp">
                            <label for="phoneno-1">Phone No.</label>
                            <input type="text" id="phoneno-1">
                            <i class="fa fa-phone"></i>
                        </div>
                    </div>
					<div class="w-100 mt-3">
                       <button type="button" class="btn btn-rounded btn-secondary">Add New No.</button>
                    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-rounded btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-rounded btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>
	<!-- HyperLink popup here -->
	<div class="modal fade" id="hyperlink-2">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">DID Wise Blocked No.</h5>
					<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="table-responsive data-tables datatable-dark">
						<table id="didtableblock" class="text-center">
							<thead class="text-capitalize">
								<tr>
									<th>Sr. No.</th>
									<th>Phone No.</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>1</td>
									<td>1234454544</td>
								</tr>
								<tr>
									<td>2</td>
									<td>1234454544</td>
								</tr>
								<tr>
									<td>3</td>
									<td>1234454544</td>
								</tr>
								<tr>
									<td>4</td>
									<td>1234454544</td>
								</tr>
								<tr>
									<td>5</td>
									<td>1234454544</td>
								</tr>
								<tr>
									<td>6</td>
									<td>1234454544</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-rounded btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	
	
	
	<div class="modal fade" id="unniquelistpopup">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">CDR List</h5>
					<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="form-row align-items-center">
						<div class="col-12">
								<div class="table-responsive ">
								<input type="button" onClick="tableToExcel('testTable22', 'W3C Example Table')" ng-click="noprint==true;" class="btn btn-rounded btn-primary pull-right mb-2" value="Export to Excel">
									<table class="table text-center"  id="testTable22">
										<thead class="text-capitalize">
											<tr>
												<th ng-click="sort('slno')">Sr. No.<span class="glyphicon sort-icon" ng-show="sortKey=='slno'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('date')">Date<span class="glyphicon sort-icon" ng-show="sortKey=='date'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('CLID')">Caller No<span class="glyphicon sort-icon" ng-show="sortKey=='CLID'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('dino')">Dialed No<span class="glyphicon sort-icon" ng-show="sortKey=='dino'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('opc')">Operator Circle<span class="glyphicon sort-icon" ng-show="sortKey=='opc'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('stime')">Start Time<span class="glyphicon sort-icon" ng-show="sortKey=='stime'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('cptime')">End Time<span class="glyphicon sort-icon" ng-show="sortKey=='cptime'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('src')">DNID<span class="glyphicon sort-icon" ng-show="sortKey=='src'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('nonoffice')">Office /Non Office<span class="glyphicon sort-icon" ng-show="sortKey=='nonoffice'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<!--<th ng-click="sort('record')">Recording<span class="glyphicon sort-icon" ng-show="sortKey=='record'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>-->
												<th ng-click="sort('duration')">Duration <span class="glyphicon sort-icon" ng-show="sortKey=='duration'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('dreason')">Disconnection Reason<span class="glyphicon sort-icon" ng-show="sortKey=='dreason'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('dispo')">Disposition<span class="glyphicon sort-icon" ng-show="sortKey=='dispo'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('blc')">BLC <span class="glyphicon sort-icon" ng-show="sortKey=='blc'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
											</tr>
										</thead>
										<tbody>
											<tr  dir-paginate="list in indetaildidlist|orderBy:sortKey:reverse|itemsPerPage:pageSize"   ng-click="selectedRow($index,list);" ng-class="{activeRow : selRow == $index}" total-items="totalCount">
												<td>{{$index+1}}</td>
												<td>{{list.start}}</td>
												<td>{{list.clid}}</td>
												<td>{{list.dst}}</td>
												<td></td>
												<td>{{list.start}}</td>
												<td>{{list.end}}</td>
												<td>{{list.src}}</td>
												<td></td>
												<!--<td>{{list.recording}}<span ng-if="list.recording!=' '"><a title="Recording Download" target="_blank" href="http://112.196.109.66:8181/recording/{{list.recording}}.wav"><i class="fa fa-download"></i></a>&nbsp;<a href="javascript:;" ng-if="list.recording != ''" ng-click="voiceMailPlay(list.recording);" title="Recording Play"><i class="fa fa-play" aria-hidden="true"></i></a></span></td>-->
												<td>{{list.duration}}</td>
												
												<td>{{list.HangUpCauseCode}}</td>
												<td>{{list.report_disposition}}</td>
												<td><span ng-if="list.block=='Y'"><i ng-click="getCLIDBlock(list.clid,list.src,'B');" class="fa fa-check" style="color:#006600" aria-hidden="true"></i></span>
												<span ng-if="list.block=='N'"><i ng-click="getCLIDBlock(list.clid,list.src,'U');" class="fa fa-times" style="color:#FF0000" aria-hidden="true"></i></span></td>
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
				<div class="modal-footer">
					<button type="button" class="btn btn-rounded btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	
	<div id="getCLIDBlock" class="modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Block</h4>
					<button type="button" class="close" onclick="closeModal()" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="single-table">
						<div class="col-md-12">
							<div class="container1">
								<div class="form-group">
									<label>DID:</label>
									<input type="tel" class="form-control" numbers-only maxlength="10" readonly=""  required ng-model="didedit.did">
								</div>
								<div class="form-group">
									<label>CLID:</label>
									<input type="tel" class="form-control"  numbers-only  name="didnumber" readonly=""   maxlength="10" required ng-model="didedit.clid">
								</div>
								<div class="form-group">
									<label>Is Global:</label>
									<select class="form-control" required  ng-model="didedit.is_global"><option value="1">Yes</option><option value="0">No</option></select>
								</div>
								<div class="form-group">
									<label>Reason:</label>
									<select class="form-control" required  ng-model="didedit.reason"><option ng-repeat="list in reasonslist" value="{{list.reason_id}}">{{list.reason}}</option></select>
								</div>
								
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-rounded btn-primary" ng-click="getCLIDBlockUpdate(didedit);">Update</button><button type="button" class="close" onclick="closeModal()" data-dismiss="modal"><span>Close</span></button>
				</div>
			</div>
		</div>
	</div>
  <?php include("footer.php"); ?>
</body>

</html>
