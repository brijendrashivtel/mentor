<!doctype html>
<html class="no-js" lang="en"  ng-app="myApp" ng-controller="managePrompt" ng-cloak>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Prompt-Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <?php include("script-head.php"); ?>
   <script language="JavaScript">
	function selectAll(source) {
		checkboxes = document.getElementsByName('location[]');
		for(var i in checkboxes)
			checkboxes[i].checked = source.checked;
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
        <?php include("leftmenu.php");?>
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
                            <div class="card-body pb-0 text-right">
                                <button type="button" class="btn btn-rounded btn-secondary mb-4" data-toggle="modal" ng-click="getAddDID();" >Add Prompt</button>
								<!--<button type="button" class="btn btn-rounded btn-secondary mb-4 ml-3" data-toggle="modal" data-target="#removedid">Remove List</button>-->
								<!--<button type="button" onClick="samplePromptCsv()" class="btn btn-rounded btn-secondary mb-4 ml-3">Download Sample</button>-->
                            </div>
                        </div>
                    </div>
				</div>
                <div class="row">
                    <!-- Dark table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Prompt Table</h4>
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
											<input type="text" class="form-control pull-right" ng-model="keywords" ng-change="getdidList()" placeholder="Search PromptName">
											<div class="input-group-addon br-t-r p-t-b-12 border-left-0" ng-click="getdidList()"><i class="fa fa-search"></i></div>
										</div>
									</div>
								</div>
                                <div class="table-responsive ">
                                    <table class="table text-center">
                                        <thead class="text-capitalize">
                                            <tr>
                                                <th ng-click="sort('slno')">Sr. No.<label class="checkbox-container"><input type="checkbox"  id="selectall"  onClick="selectAll(this)" ><span class="checkmark"></span></label></th>
												<th ng-click="sort('slno')">Action<span class="glyphicon sort-icon" ng-show="sortKey=='slno'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
                                                <th ng-click="sort('groupid')">Name<span class="glyphicon sort-icon" ng-show="sortKey=='groupid'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
												<th ng-click="sort('name')">File<span class="glyphicon sort-icon" ng-show="sortKey=='name'" ng-class="{'ti-arrow-up':reverse, 'ti-arrow-down':!reverse}"></span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr  dir-paginate="list in didlist|orderBy:sortKey:reverse|itemsPerPage:pageSize"   ng-click="selectedRow($index,list);" ng-class="{activeRow : selRow == $index}" total-items="totalCount">
                                                <td>{{$index+1}}<label class="checkbox-container"><input type="checkbox"  name="location[]" value="{{list.id}}"><span class="checkmark"></span></label></td>
												<td><a ng-click="getTimeGroupEdit(list);"><i class="fa fa-edit"></i></a><a ng-click="getTimegroupDelete(list.id);" ><i class="fa fa-trash"></i></a></td>
												<td>{{list.name}}</td>
												<td><a target="_blank" href="<?php echo base_url("cdr/download/"); ?>{{list.file}}"><i class="fa fa-download"></i></a>&nbsp;<a href="javascript:;" ng-if="list.file != ''" ng-click="voiceMailPlay(list.file);" title="Recording Play"><i class="fa fa-play" aria-hidden="true"></i></a></td>
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

	<div class="modal fade" id="timegroupedit">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Prompt Edit</h5>
					<button type="button" class="close"  ng-click="getReverse();"><span>&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="single-table">
						<div id="table" class="table-editable">
							<div class="container1">
								<div class="form-group">
								<label for="email">Name:</label>
								<input type="text" class="form-control" ng-model="didedit.name">
								<input type="hidden" class="form-control" ng-model="didedit.id">
								</div>
							
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
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-rounded btn-secondary"  ng-click="getReverse();">Close</button>
					<button type="button" ng-click="getTimeGroupUpdate(didedit);" class="btn btn-rounded btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Add did popup here -->
	<div class="modal fade" id="adddid">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Prompt</h5>
					<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="form-row align-items-center">
						<div class="col-12">
						<div class="form-group">
								<label for="email">Name:</label>
								<input type="text" class="form-control" ng-model="didedit.name">
								</div>
							<form method="post" enctype="multipart/form-data">
								<div class="position-relative">
									<a class='btn btn-rounded btn-primary position-relative' href='javascript:void(0);'>
										Choose File...
										<input type="file" file-model="files" class="file-upload" name="input-file-preview"  size="40"  onchange='$("#upload-file-info-add").html($(this).val());'/> 
									</a>
									&nbsp;
									<span class='badge badge-pill badge-primary' id="upload-file-info-add"></span>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-rounded btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-rounded btn-primary"  ng-click="didCreate(didedit,'ajaxResult');">Submit</button>
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
  <?php include("footer.php"); ?>
<script>
	$('#promptmenu').addClass('active');
</script>
</body>
</html>
