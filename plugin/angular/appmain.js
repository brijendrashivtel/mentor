var myapp = angular.module('myApp',['dirPagination']);

/* ---- Alert Msg and Pagination function Start---- */
myapp.service('myService', function () {
	this.resMessage = function (scope,timeout,errcode) {
		scope.alertMsg = true; if(errcode == 200){ scope.altErr = true; }else{ scope.altErr = false; }
    }
	this.pagination = function (scope,pageno,pagesize,datalength,totalcount) {
		scope.totalCount = totalcount; scope.cpage = pageno;
		scope.startval = (pageno-1)*pagesize+1;
		scope.endval = datalength.length+(pagesize*(pageno - 1));
		if(datalength.length == 0){ scope.startval = 0;}
    }
});

/* ---- fileupload function ---- */
myapp.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs){
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;
            element.bind('change', function(){
                scope.$apply(function(){ modelSetter(scope, element[0].files[0]); });
            });
        }
    };
}]);

/*myapp.filter('highlight', function() {
    return function(text, phrase) {
      return phrase 
        ? text.replace(new RegExp('('+phrase+')', 'gi'), '<kbd>$1</kbd>') 
        : text;
    };
  });*/

myapp.filter('highlight', function($sce) 
  {
    return function(text, phrase) 
	{
      if (phrase) text = text.replace(new RegExp('('+phrase+')', 'gi'),
        '<span class="highlighted">$1</span>')

      return $sce.trustAsHtml(text)
    }
  });

myapp.directive('capitalize', function() {
	return {
      require: 'ngModel',
      link: function(scope, element, attrs, modelCtrl) {
        var capitalize = function(inputValue) {
          if (inputValue == undefined) inputValue = '';
          var capitalized = inputValue.toUpperCase();
          if (capitalized !== inputValue) {
            // see where the cursor is before the update so that we can set it back
            var selection = element[0].selectionStart;
            modelCtrl.$setViewValue(capitalized);
            modelCtrl.$render();
            // set back the cursor after rendering
            element[0].selectionStart = selection;
            element[0].selectionEnd = selection;
          }
          return capitalized;
        }
        modelCtrl.$parsers.push(capitalize);
        capitalize(scope[attrs.ngModel]); // capitalize initial value
      }
	};
});

myapp.directive('allowDecimalNumbers', function () {  
	return {  
		restrict: 'A',  
		link: function (scope, elm, attrs, ctrl) {  
			elm.on('keydown', function (event) {  
				var $input = $(this);  
				var value = $input.val();  
				value = value.replace(/[^0-9\.]/g, '')  
				$input.val(value);  
				if (event.which == 64 || event.which == 16) {  
					// numbers  
					return false;  
				} if([8, 13, 27, 37, 38, 39, 40, 110].indexOf(event.which) > -1){  
					// backspace, enter, escape, arrows  
					return true;  
				} else if(event.which >= 48 && event.which <= 57){  
					// numbers  
					return true;  
				} else if(event.which >= 96 && event.which <= 105){  
					// numpad number  
					return true;  
				} else if ([46, 110, 190].indexOf(event.which) > -1) {  
					// dot and numpad dot  
					return true;  
				} else {  
					event.preventDefault();  
					return false;  
				}  
			});  
		}  
	}  
});

//Function allow only numbers
myapp.directive('numbersOnly', function () {  
	return {  
		restrict: 'A',  
		link: function (scope, elm, attrs, ctrl) {  
			elm.on('keydown', function (event) {  
				var $input = $(this);  
				var value = $input.val();  
				value = value.replace(/[^0-9\.]/g, '')  
				$input.val(value);  
				if (event.which == 64 || event.which == 16) {  
					// numbers  
					return false;  
				} if ([8, 9, 13, 27, 37, 38, 39, 40].indexOf(event.which) > -1) {  
					// backspace, enter, escape, arrows  
					return true;  
				} else if (event.which >= 48 && event.which <= 57) {  
					// numbers  
					return true;  
				} else if (event.which >= 96 && event.which <= 105) {  
					// numpad number  
					return true;  
				} else {  
					event.preventDefault();  
					return false;  
				}  
			});  
		}  
	}  
});

myapp.directive('myPattern', function() {
 function link(scope, elem, attrs, ngModel) {
	  ngModel.$parsers.push(function(viewValue) {
		var reg = /^[^`~!@#$%\^&*()_+={}|[\]\\:';"<>?,./]*$/;
		// if view values matches regexp, update model value
		if (viewValue.match(reg)) {
		  return viewValue;
		}
		// keep the model value as it is
		var transformedValue = ngModel.$modelValue;
		ngModel.$setViewValue(transformedValue);
		ngModel.$render();
		return transformedValue;
	  });
  }

  return {
	  restrict: 'A',
	  require: 'ngModel',
	  link: link
  };      
});

myapp.filter('lineBreaker', function() {
	return function(input, breakLength) {
		var newString = "";
		for (var i = 0; i < input.length; i++) {
		  newString = newString+input[i];
		  if (i%breakLength == 0) {
			if(i != 0) { newString = newString+"<br />"; }
		  }
		}
		return newString;
	};
});

myapp.filter('dateFormat', function() {    
    return function(input) {
		if(input == '0000-00-00 00:00:00' || input == '0000-00-00' || input == undefined)
		{
			return '';
		}
		else
		{
			var weekday = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
			var str = input.split(' ');
			if(str[1] == undefined || str[1] == 'undefined')
			{
				var date = new Date(input);
				var today = weekday[new Date(input).getDay()];
				var d = date.getDate(); var m = date.getMonth()+1; var y = date.getFullYear(); 
				return today+", "+d+"-"+m+"-"+y;
			}
			else
			{
				var date = new Date(input);
				var hours = date.getHours() > 12 ? date.getHours() - 12 : date.getHours();
				var am_pm = date.getHours() >= 12 ? "PM" : "AM";
				hours = hours < 10 ? "0" + hours : hours;
				var minutes = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
				var seconds = date.getSeconds() < 10 ? "0" + date.getSeconds() : date.getSeconds();
				var strTime = hours + ":" + minutes + ":" + seconds + " " + am_pm;
				
				var today = weekday[new Date(input).getDay()];
				var d = date.getDate(); var m = date.getMonth()+1; var y = date.getFullYear(); 
				return today+", "+d+"-"+m+"-"+y+" "+strTime;
			}
		}
    };
});

//Function more then 50 chars will hide
myapp.filter('cut', function () {
	return function (value, wordwise, max, tail) {
		if (!value) return '';
		max = parseInt(max, 10);
		if (!max) return value;
		if (value.length <= max) return value;

		value = value.substr(0, max);
		if (wordwise) {
			var lastspace = value.lastIndexOf(' ');
			if (lastspace != -1) {
				value = value.substr(0, lastspace);
			}
		}
		return value + (tail || ' …');
	};
});

myapp.filter("spacePlaceFilterProvider", function() {
	return function(data, delimiter){
		if(data != undefined){ return data.replace(/\s/g,delimiter); }
	}
});

myapp.filter("specialFilterProvider", function() {
	return function(data, delimiter) {
		if(data != undefined){
			var str = data.replace(/[^a-zA-Z 0-9]+/g,''); 
			if(data != undefined){ return str.replace(/\s/g,delimiter); }
		}
	}
});
/*---Alert Msg and Pagination function End---*/

//manageDid Page Start
myapp.controller("manageDid", function($scope,$http,$timeout,$location,myService) 
{
	$scope.pageno = 1; // initialize page no to 1
	$scope.selectables = [ {value: 10}, {value: 25}, {value: 50}, {value: 100}, {value: 200}, {value: 500} ];
	$scope.pageSize = "10";
	$scope.totalCount = 0;
	$scope.selectedRow = function(row,val){ $scope.selRow = row; $scope.selectval = val; };
	$scope.sort = function(keyname){ $scope.sortKey = keyname; $scope.reverse = !$scope.reverse; }
	$scope.pageData = function(pageno){ $scope.pageno = pageno; $scope.getdidList(); }
	$scope.getdidList = function (record,varResult) 
	{
		$scope.loading = true; 
		var config = {params: { page:$scope.pageno, size:$scope.pageSize, keyword:$scope.keywords}};
		$http.post(base_url+"did_management/did_details", null, config).then(function(response)
		{ 
			$scope.loading = false; $scope.didlist = response.data.tabledata; 
			myService.pagination($scope,$scope.pageno,$scope.pageSize,$scope.didlist,response.data.totalCount);
		});	
	}
	$scope.getdidList();
	
	$scope.didbulkDelete = function()
	{
		var checkboxes = document.getElementsByName('location[]');
		var vals = "";
		for (var i=0, n=checkboxes.length;i<n;i++) 
		{
			if (checkboxes[i].checked) 
			{
				vals += ","+checkboxes[i].value;
			}
		}
		if (vals) vals = vals.substring(1);
		if(vals !='')
		{
			if(confirm("Are you sure you want to delete DIDs "+vals+"?"))
			{
				var config = {params:{id:vals}}; $scope.loading = true;
				$http.post(base_url+"did_management/did_delete_bulk", null, config).then(function(response)
				{  $scope.loading = false; 
				$scope.ajaxResult = response.data.errmsg; myService.resMessage($scope,$timeout, response.data.errcode); $scope.getdidList();
				});
			}
		}
		else
		{
			$scope.ajaxResult = "Please select DIDs to delete"; myService.resMessage($scope,$timeout,202);
		}
	}
	
	$scope.getDidEdit = function(list)
	{
		$scope.didedit = list; $('#didedit').modal({ backdrop: 'static', keyboard: false });
	}
	
	$scope.timegroup_details = function (record,varResult) 
	{
		$scope.loading = true; 
		$http.get(base_url+"did_management/timegroup_details_all").then(function(response)
		{ 
			$scope.loading = false; $scope.timegroup = response.data; 
		});	
	}
	$scope.timegroup_details();
	
	$scope.prompt_details_all = function (record,varResult) 
	{
		$scope.loading = true; 
		$http.get(base_url+"did_management/prompt_details_all").then(function(response)
		{ 
			$scope.loading = false; $scope.promptdetails = response.data; 
		});	
	}
	$scope.prompt_details_all();
	$scope.getDidDelete = function(id)
	{
		if(confirm("Are you sure you want to delete DID?"))
		{
			var config = {params:{id:id}}; $scope.loading = true;
		 	$http.post(base_url+"did_management/did_delete", null, config).then(function(response)
		 	{  $scope.loading = false; 
		 	$scope.ajaxResult = response.data.errmsg; myService.resMessage($scope,$timeout, response.data.errcode); $scope.getdidList();
			});
		}
	}
	
	$scope.getDeleteCommon = function(sts,id)
	{
		if(sts == 'cm') var strng = "Call Mapping Number";
		if(sts == 'fb') var strng = "Fall Back Number";
		if(sts == 'fh') var strng = "Off Hour Number";
		if(sts == 'hn') var strng = "Holiday Number";
		if(confirm("Are you sure you want to delete?"))
		{
			var config = {params:{sts:sts,id:id}}; $scope.loading = true;
		 	$http.post(base_url+"did_management/common_delete", null, config).then(function(response)
		 	{  
				$scope.loading = false; //alert(response.data.errmsg);
		 		$scope.ajaxResult = response.data.errmsg; myService.resMessage($scope,$timeout, response.data.errcode); 
				 window.location.reload();
				 
			});
		}
	}
	
	$scope.getDIDEditUpdate = function(id)
	{
		var config = {params:{id:id}}; $scope.loading = true; $('#didedit').modal('hide');
		$http.post(base_url+"did_management/did_update", null, config).then(function(response)
		{  
		   $scope.loading = false;
		   $scope.ajaxResult = response.data.errmsg; myService.resMessage($scope,$timeout, response.data.errcode); 
		   $scope.getdidList();
		});
	}
	
	$scope.getReverse = function()
	{
		$scope.getdidList(); $('#didedit').modal('hide');
	}
	
	$scope.csvvvvvvv = function()
	{
		window.location = base_url+"did_management/did_details_csv";
	}
	
	$scope.getAddDID = function(){ document.getElementById("upload-file-info").innerHTML = ''; $('#adddid').modal({ backdrop: 'static', keyboard: false }); }
	$scope.didCreate = function (record,varResult) 
	{
		if(document.getElementById("upload-file-info").innerHTML != '')
		{
			$scope.loader = true; var fd = new FormData(); fd.append("fileInput", $scope.files); $('#adddid').modal('hide');
			$http.post(base_url+"did_management/did_create",fd,{transformRequest: angular.identity,params:{formdata:record},headers: {'Content-Type': undefined}})
			.then(function(response){ $scope.loader = false; 
				$scope.ajaxResult = response.data.errmsg; myService.resMessage($scope,$timeout,response.data.errcode);
				if(response.data.errcode == 200){ $scope.getdidList();  }
			});
		}
		else
		{
			$scope.ajaxResult = "Please select File"; myService.resMessage($scope,$timeout,202);
		}
	}
	
	$scope.didDeleteUpload = function (record,varResult) 
	{
		if(confirm("Are you sure you want to delete the DID List?"))
		{
			if(document.getElementById("upload-file-info").innerHTML != '')
			{
				$scope.loader = true; var fd = new FormData(); fd.append("fileInput", $scope.files); $('#adddid').modal('hide');
				$http.post(base_url+"did_management/didDeleteUpload",fd,{transformRequest: angular.identity,params:{formdata:record},headers: {'Content-Type': undefined}})
				.then(function(response){ $scope.loader = false; 
					$scope.ajaxResult = response.data.errmsg; myService.resMessage($scope,$timeout,response.data.errcode);
					if(response.data.errcode == 200){ $scope.getdidList();  }
				});
			}
			else
			{
				$scope.ajaxResult = "Please select File"; myService.resMessage($scope,$timeout,202);
			}
		}
	}
	
	$scope.selecteddid = '';
	$scope.getMappedList = function(did)
	{ 
		var config = {params:{did:did,maptype:1}}; $scope.loading = true; $scope.selecteddid = did;
		 $http.post(base_url+"did_management/call_flow_number", null, config).then(function(response)
		 {  $scope.loading = false; console.log(response);
			$scope.callforwdlist = response.data;
		});
		//$('#hyperlink-1').modal('show'); 
		$('#hyperlink-1').modal({ backdrop: 'static', keyboard: false });
	}
	
	$scope.ffffffffffff = function()
	{
		var inps = document.getElementsByName('mapping[]');
		var dnp = document.getElementsByName('mdnd[]');
		var tppp = document.getElementsByName('typee[]');
		var mapvals = ''; var dnds = ''; var tpps = '';
		for (var i = 0; i <inps.length; i++) 
		{
			var inp=inps[i]; var dnpp=dnp[i]; var trps=tppp[i]; mapvals += inp.value+','; dnds += dnpp.value+','; tpps += trps.value+',';
		}
		//alert(tpps);
		var config = {params:{mapvals:mapvals,dnds:dnds,maptype:1,did:$scope.selecteddid,tpps:tpps}}; $scope.loading = true;
		 $http.post(base_url+"did_management/call_flow_number_update", null, config).then(function(response)
		 {  $scope.loading = false; $('#hyperlink-1').modal('hide'); 
		 	$scope.ajaxResult = "Updated Successfully"; myService.resMessage($scope,$timeout,200); window.location.reload();
		});
	}
	
	$scope.getFallbackList = function(did)
	{ 
		var config = {params:{did:did,maptype:2}}; $scope.loading = true; $scope.selecteddid = did;
		 $http.post(base_url+"did_management/call_flow_number", null, config).then(function(response)
		 {  $scope.loading = false;
			$scope.callfallbacklist = response.data;
		});
		//$('#fallbacklist').modal('show'); 
		$('#fallbacklist').modal({ backdrop: 'static', keyboard: false });
	}
	
	$scope.fallbacklistupdate = function()
	{
		var inps = document.getElementsByName('fallback[]'); var mapvals = '';
		for (var i = 0; i <inps.length; i++) 
		{
			var inp=inps[i]; mapvals += inp.value+',';  //dnds += inp.value+',';
		}
		var config = {params:{mapvals:mapvals,maptype:2,did:$scope.selecteddid}}; $scope.loading = true;
		 $http.post(base_url+"did_management/call_flow_number_update", null, config).then(function(response)
		 {  $scope.loading = false; $('#fallbacklist').modal('hide'); 
		 	$scope.ajaxResult = "Updated Successfully"; myService.resMessage($scope,$timeout,200); window.location.reload();
		});
	}
	
	$scope.getOffHourList = function(did)
	{ 
		var config = {params:{did:did,maptype:3}}; $scope.loading = true; $scope.selecteddid = did;
		 $http.post(base_url+"did_management/call_flow_number", null, config).then(function(response)
		 {  $scope.loading = false;
			$scope.offhourslist = response.data;
		});
		//$('#offhourlist').modal('show'); 
		$('#offhourlist').modal({ backdrop: 'static', keyboard: false });
	}
	
	$scope.OffHourListupdate = function()
	{
		/*var inps = document.getElementsByName('offhour[]'); var mapvals = '';
		for (var i = 0; i <inps.length; i++) 
		{
			var inp=inps[i]; mapvals += inp.value+',';
		}
		var config = {params:{mapvals:mapvals,maptype:3,did:$scope.selecteddid}}; $scope.loading = true;*/
		
		var inps = document.getElementsByName('offhour[]');
		var dnp = document.getElementsByName('odnd[]');
		var mapvals = ''; var dnds = '';
		for (var i = 0; i <inps.length; i++) 
		{
			
			var inp=inps[i]; var dnpp=dnp[i]; mapvals += inp.value+','; dnds += dnpp.value+',';
		}
		var config = {params:{mapvals:mapvals,dnds:dnds,maptype:3,did:$scope.selecteddid}}; $scope.loading = true;
		$http.post(base_url+"did_management/call_flow_number_update", null, config).then(function(response)
		 {  $scope.loading = false; $('#offhourlist').modal('hide'); 
		 	$scope.ajaxResult = "Updated Successfully"; myService.resMessage($scope,$timeout,200); window.location.reload();
		});
	}
	
	$scope.getHolidayList = function(did)
	{ 
		var config = {params:{did:did,maptype:4}}; $scope.loading = true; $scope.selecteddid = did;
		 $http.post(base_url+"did_management/call_flow_number", null, config).then(function(response)
		 {  $scope.loading = false;
			$scope.holidaysnolist = response.data;
		});
		//$('#holidaynolist').modal('show'); 
		$('#holidaynolist').modal({ backdrop: 'static', keyboard: false });
	}
	
	$scope.HolidayListupdate = function()
	{
		/*var inps = document.getElementsByName('holidayno[]'); var mapvals = '';
		for (var i = 0; i <inps.length; i++) 
		{
			var inp=inps[i]; mapvals += inp.value+',';
		}
		var config = {params:{mapvals:mapvals,maptype:4,did:$scope.selecteddid}}; $scope.loading = true;*/
		var inps = document.getElementsByName('holidayno[]');
		var dnp = document.getElementsByName('hdnd[]');
		var mapvals = ''; var dnds = '';
		for (var i = 0; i <inps.length; i++) 
		{
			
			var inp=inps[i]; var dnpp=dnp[i]; mapvals += inp.value+','; dnds += dnpp.value+',';
		}
		var config = {params:{mapvals:mapvals,dnds:dnds,maptype:4,did:$scope.selecteddid}}; $scope.loading = true;
		 $http.post(base_url+"did_management/call_flow_number_update", null, config).then(function(response)
		 {  $scope.loading = false; $('#holidaynolist').modal('hide'); 
		 	$scope.ajaxResult = "Updated Successfully"; myService.resMessage($scope,$timeout,200);
			window.location.reload();
		});
	}
});
//manageDid Page Ends

//manageHoliday Page Start
myapp.controller("manageHoliday", function($scope,$http,$timeout,$location,myService) 
{
	$scope.pageno = 1; // initialize page no to 1
	$scope.selectables = [ {value: 10}, {value: 25}, {value: 50}, {value: 100}, {value: 200}, {value: 500} ];
	$scope.pageSize = "10";
	$scope.totalCount = 0;
	$scope.selectedRow = function(row,val){ $scope.selRow = row; $scope.selectval = val;  };
	$scope.sort = function(keyname){ $scope.sortKey = keyname; $scope.reverse = !$scope.reverse; }
	$scope.pageData = function(pageno){ $scope.pageno = pageno; $scope.getdidList(); }
	
	$scope.getdidList = function (record,varResult) 
	{
		$scope.loading = true; 
		var config = {params: { page:$scope.pageno, size:$scope.pageSize, keyword:$scope.keywords}};
		$http.post(base_url+"holiday/holiday_details", null, config).then(function(response)
		{
			$scope.loading = false; $scope.didlist = response.data.tabledata; 
			myService.pagination($scope,$scope.pageno,$scope.pageSize,$scope.didlist,response.data.totalCount);
		});	
	}
	$scope.getdidList();
	
	$scope.getTimegroupDelete = function(id)
	{
		if(confirm("Are you sure you want to delete Holiday?"))
		{
			var config = {params:{id:id}}; $scope.loading = true;
		 	$http.post(base_url+"did_management/holiday_delete", null, config).then(function(response)
		 	{  $scope.loading = false; 
		 	$scope.ajaxResult = response.data.errmsg; myService.resMessage($scope,$timeout, response.data.errcode); $scope.getdidList();
			});
		}
	}
	
	$scope.TimegroupbulkDelete = function()
	{
		var checkboxes = document.getElementsByName('location[]');
		var vals = "";
		for (var i=0, n=checkboxes.length;i<n;i++) 
		{
			if (checkboxes[i].checked) 
			{
				vals += ","+checkboxes[i].value;
			}
		}
		if (vals) vals = vals.substring(1);
		if(vals !='')
		{
			if(confirm("Are you sure you want to delete Prompt?"))
			{
				var config = {params:{id:vals}}; $scope.loading = true;
				$http.post(base_url+"did_management/holiday_delete_bulk", null, config).then(function(response)
				{  $scope.loading = false; 
				$scope.ajaxResult = response.data.errmsg; myService.resMessage($scope,$timeout, response.data.errcode); $scope.getdidList();
				});
			}
		}
		else
		{
			$scope.ajaxResult = "Please select Prompt to delete"; myService.resMessage($scope,$timeout,202);
		}
	}
	
	
	$scope.getTimeGroupEdit = function(list)
	{
		$scope.didedit = list;  $('#timegroupedit').modal({ backdrop: 'static', keyboard: false });
	}
	
	$scope.getTimeGroupUpdate = function(id)
	{
		var config = {params:{id:id}}; $scope.loading = true; $('#timegroupedit').modal('hide');
		$http.post(base_url+"did_management/holiday_update", null, config).then(function(response)
		{  
		   $scope.loading = false;
		   $scope.ajaxResult = response.data.errmsg; myService.resMessage($scope,$timeout, response.data.errcode); 
		   $scope.getdidList();
		});
	}
	
	$scope.getReverse = function()
	{
		$scope.getdidList(); $('#timegroupedit').modal('hide');
	}
	
	$scope.csvvvvvvv = function()
	{
		window.location = base_url+"holiday/holiday_details_csv";
	}
	
	$scope.getAddDID = function(){ $scope.didedit = {}; $('#adddid').modal({ backdrop: 'static', keyboard: false }); }
	$scope.didCreate = function (record,varResult) 
	{
		$scope.loader = true; var fd = new FormData(); fd.append("fileInput", $scope.files); $('#adddid').modal('hide');
		$http.post(base_url+"holiday/holiday_create",fd,{transformRequest: angular.identity,params:{formdata:record},headers: {'Content-Type': undefined}})
		.then(function(response){ $scope.loader = false; 
			$scope.ajaxResult = response.data.errmsg; myService.resMessage($scope,$timeout,response.data.errcode);
			$scope.getdidList();
		});
	}
});
//manageHoliday Page Ends

//manageTimeGroup Page Start
myapp.controller("manageTimeGroup", function($scope,$http,$timeout,$location,myService) 
{
	$scope.pageno = 1; // initialize page no to 1
	$scope.selectables = [ {value: 10}, {value: 25}, {value: 50}, {value: 100}, {value: 200}, {value: 500}  ];
	$scope.pageSize = "10";
	$scope.totalCount = 0;
	$scope.selectedRow = function(row,val){ $scope.selRow = row; $scope.selectval = val; };
	$scope.sort = function(keyname){ $scope.sortKey = keyname; $scope.reverse = !$scope.reverse; }
	$scope.pageData = function(pageno){ $scope.pageno = pageno; $scope.getdidList(); }
	
	$scope.getdidList = function (record,varResult) 
	{
		$scope.loading = true; 
		var config = {params: { page:$scope.pageno, size:$scope.pageSize, keyword:$scope.keywords}};
		$http.post(base_url+"timegroup/timegroup_details", null, config).then(function(response)
		{ 
			$scope.loading = false; $scope.didlist = response.data.tabledata; 
			myService.pagination($scope,$scope.pageno,$scope.pageSize,$scope.didlist,response.data.totalCount);
		});	
	}
	$scope.getdidList();
	
	$scope.getTimegroupDelete = function(id)
	{
		if(confirm("Are you sure you want to delete TimeGroup?"))
		{
			var config = {params:{id:id}}; $scope.loading = true;
		 	$http.post(base_url+"did_management/timegroup_delete", null, config).then(function(response)
		 	{  $scope.loading = false; 
		 	$scope.ajaxResult = response.data.errmsg; myService.resMessage($scope,$timeout, response.data.errcode);  $scope.getdidList();
			});
		}
	}
	
	$scope.TimegroupbulkDelete = function()
	{
		var checkboxes = document.getElementsByName('location[]');
		var vals = "";
		for (var i=0, n=checkboxes.length;i<n;i++) 
		{
			if (checkboxes[i].checked) 
			{
				vals += ","+checkboxes[i].value;
			}
		}
		if (vals) vals = vals.substring(1);
		if(vals !='')
		{
			if(confirm("Are you sure you want to delete TimeGroup?"))
			{
				var config = {params:{id:vals}}; $scope.loading = true;
				$http.post(base_url+"did_management/timegroup_delete_bulk", null, config).then(function(response)
				{  $scope.loading = false; 
				$scope.ajaxResult = response.data.errmsg; myService.resMessage($scope,$timeout, response.data.errcode); $scope.getdidList();
				});
			}
		}
		else
		{
			$scope.ajaxResult = "Please select TimeGroup to delete"; myService.resMessage($scope,$timeout,202);
		}
	}
	
	
	$scope.getTimeGroupEdit = function(list)
	{
		$scope.didedit = list; $('#timegroupedit').modal({ backdrop: 'static', keyboard: false });
	}
	
	$scope.getTimeGroupUpdate = function(id)
	{
		if(document.getElementById("tname").value == '')
		{
			$scope.ajaxResult = "Time Group Name Cannot be Empty!"; myService.resMessage($scope,$timeout, 202); 
		}
		else if(document.getElementById("tggoups").value == '')
		{
			$scope.ajaxResult = "Time Group cannot be Empty!"; myService.resMessage($scope,$timeout, 202); 
		}
		else
		{
			var config = {params:{id:id}}; $scope.loading = true; $('#timegroupedit').modal('hide');
			$http.post(base_url+"did_management/timegroup_update", null, config).then(function(response)
			{  
			   $scope.loading = false;
			   $scope.ajaxResult = response.data.errmsg; myService.resMessage($scope,$timeout, response.data.errcode); 
			   $scope.getdidList();
			});
		}
	}
	
	$scope.getReverse = function()
	{
		$scope.getdidList(); $('#timegroupedit').modal('hide');
	}
	
	$scope.csvvvvvvv = function()
	{
		window.location = base_url+"timegroup/timegroup_details_csv";
	}
	
	$scope.getAddDID = function(){ $scope.didedit = {};  $('#adddid').modal({ backdrop: 'static', keyboard: false }); }
	$scope.didCreate = function (record,varResult) 
	{
		$scope.loader = true; var fd = new FormData(); fd.append("fileInput", $scope.files); $('#adddid').modal('hide');
		$http.post(base_url+"timegroup/timegroup_create",fd,{transformRequest: angular.identity,params:{formdata:record},headers: {'Content-Type': undefined}})
		.then(function(response){ $scope.loader = false; 
			$scope.ajaxResult = response.data.errmsg; myService.resMessage($scope,$timeout,response.data.errcode);
			if(response.data.errcode == 200){ $scope.getdidList();  }
		});
	}
});
//manageTimeGroup Page Ends

//manageDIDBlock Page Start
myapp.controller("manageDIDBlock", function($scope,$http,$timeout,$location,myService) 
{
	$scope.pageno = 1; // initialize page no to 1
	$scope.selectables = [ {value: 10}, {value: 25}, {value: 50}, {value: 100}, {value: 200}, {value: 500} ];
	$scope.pageSize = "10";
	$scope.totalCount = 0;
	$scope.selectedRow = function(row,val){ $scope.selRow = row; $scope.selectval = val; };
	$scope.sort = function(keyname){ $scope.sortKey = keyname; $scope.reverse = !$scope.reverse; }
	$scope.pageData = function(pageno){ $scope.pageno = pageno; $scope.getdidList(); }
	
	$scope.getdidList = function (record,varResult) 
	{
		$scope.loading = true; 
		var config = {params: { page:$scope.pageno, size:$scope.pageSize, keyword:$scope.keywords}};
		$http.post(base_url+"did_block/did_block_details", null, config).then(function(response)
		{  
			$scope.loading = false; $scope.didlist = response.data.tabledata; 
			myService.pagination($scope,$scope.pageno,$scope.pageSize,$scope.didlist,response.data.totalCount);
		});	
	}
	$scope.getdidList();
	
	$scope.csvvvvvvv = function()
	{
		window.location = base_url+"did_block/did_block_details_csv";
	}
	
	$scope.getAddDID = function(){  $scope.didedit = {}; $('#adddid').modal({ backdrop: 'static', keyboard: false }); }
	$scope.didCreate = function (record,varResult) 
	{
		$scope.loader = true; var fd = new FormData(); fd.append("fileInput", $scope.files); $('#adddid').modal('hide');
		$http.post(base_url+"did_block/did_block_create",fd,{transformRequest: angular.identity,params:{formdata:record},headers: {'Content-Type': undefined}})
		.then(function(response){ $scope.loader = false; console.log(response);
			$scope.ajaxResult = response.data.errmsg; myService.resMessage($scope,$timeout,response.data.errcode);
			if(response.data.errcode == 200){ $scope.getdidList();  }
		});
	}
	
	$scope.getTimegroupDelete = function(id)
	{
		if(confirm("Are you sure you want to delete DID Block Number?"))
		{
			var config = {params:{id:id}}; $scope.loading = true;
		 	$http.post(base_url+"did_management/didblock_delete", null, config).then(function(response)
		 	{  $scope.loading = false; 
		 	$scope.ajaxResult = response.data.errmsg; myService.resMessage($scope,$timeout, response.data.errcode);  $scope.getdidList();
			});
		}
	}
	
	$scope.didbulkDelete = function()
	{
		var checkboxes = document.getElementsByName('location[]');
		var vals = "";
		for (var i=0, n=checkboxes.length;i<n;i++) 
		{
			if (checkboxes[i].checked) 
			{
				vals += ","+checkboxes[i].value;
			}
		}
		if (vals) vals = vals.substring(1);
		if(vals !='')
		{
			if(confirm("Are you sure you want to delete DID Block?"))
			{
				var config = {params:{id:vals}}; $scope.loading = true;
				$http.post(base_url+"did_management/didblock_delete_bulk", null, config).then(function(response)
				{  $scope.loading = false; 
				$scope.ajaxResult = response.data.errmsg; myService.resMessage($scope,$timeout, response.data.errcode); $scope.getdidList();
				});
			}
		}
		else
		{
			$scope.ajaxResult = "Please select DID Block to delete"; myService.resMessage($scope,$timeout,202);
		}
	}
	
	$scope.getTimeGroupEdit = function(list)
	{
		$scope.didedit = list; $('#timegroupedit').modal({ backdrop: 'static', keyboard: false });
	}
	
	$scope.getTimeGroupUpdate = function(id)
	{
		var config = {params:{id:id}}; $scope.loading = true; $('#timegroupedit').modal('hide');
		$http.post(base_url+"did_management/didblock_update", null, config).then(function(response)
		{  
		   $scope.loading = false;
		   $scope.ajaxResult = response.data.errmsg; myService.resMessage($scope,$timeout, response.data.errcode); 
		   $scope.getdidList();
		});
	}
	
	$scope.getReverse = function()
	{
		$scope.getdidList(); $('#timegroupedit').modal('hide');
	}
});
//manageDIDBLOCK Page Ends

//CDRs Page Start
myapp.controller("cdr", function($scope,$http,$timeout,$location,myService) 
{
	$scope.pageno = 1; // initialize page no to 1
	$scope.selectables = [{value: 10}, {value: 25}, {value: 50}, {value: 100}, {value: 200}, {value: 500}  ];
	$scope.pageSize = "100";
	$scope.totalCount = 0;
	$scope.selectedRow = function(row,val){ $scope.selRow = row; $scope.selectval = val; };
	$scope.sort = function(keyname){ $scope.sortKey = keyname; $scope.reverse = !$scope.reverse; }
	$scope.pageData = function(pageno){ $scope.pageno = pageno; $scope.getdidList(); }
	
	$scope.closeActionNew = function(){ $('#voicemaillisten').hide(); var vid = document.getElementById("myAudio");  vid.pause(); }
	$scope.voiceMailPlay = function(exten1)
	{
		$('#voicemaillisten').show();
		document.getElementById("extplay").innerHTML = '<audio  id="myAudio" controls autoplay><source src="http://112.196.109.66:8181/recording/'+exten1+'.wav" type="audio/wav"></audio>';
	}
	
	$scope.getListenUpdate = function(id)
	{
		var config = {params: {id:id}};
			$http.post(base_url+"cdr/cdr_details_listen", null, config).then(function(response)
			{
				
			});	
	}
	$scope.reasons = '';
	$http.get(base_url+"cdr/reasons").then(function(response)
	{
		$scope.reasonslist = response.data;
	});
	$scope.didedit = {};
	$scope.getCLIDBlock = function(clid,src,status)
	{
		$scope.didedit = angular.extend($scope.didedit,{clid:clid,is_global:'0',did:src,reason:'1'});
		$('#getCLIDBlock').show();
	}
	$scope.getCLIDBlockUpdate = function(didedit)
	{
			var config = {params: { didedit:didedit,status:'B'}};
			$http.post(base_url+"cdr/get_clid_block_status", null, config).then(function(response)
			{ 
				$scope.loading = false;  $('#getCLIDBlock').hide();
				if(response.data == 1)
				{
					$scope.ajaxResult = "DID Blocked Successfully";
					myService.resMessage($scope,$timeout,200); 
					$scope.getdidList();
				}
				else
				{
					$scope.ajaxResult = "Something went wrong, plz try again later";  myService.resMessage($scope,$timeout,202);
				}
			});	
	}
	$scope.getCLIDUnBlock = function(clid,src,status)
	{
		var config = {params: { clid:clid,src:src,status:status}};
		$http.post(base_url+"cdr/get_clid_unblock_status", null, config).then(function(response)
		{ 
			$scope.loading = false; 
			if(response.data == 1)
			{
				if(status=='B'){ $scope.ajaxResult = clid+" - DID Blocked Successfully";} else { $scope.ajaxResult =" DID Un Blocked Successfully"; } 
				myService.resMessage($scope,$timeout,200);
				$scope.getdidList();
			}
			else
			{
				$scope.ajaxResult = "Something went wrong, plz try again later";  myService.resMessage($scope,$timeout,202);
			}
		});	
	}
	
	$scope.getdidList = function (record,varResult) 
	{
		$scope.loading = true;
		if(document.getElementById("startdate").value!='' &&  document.getElementById("enddate").value!='')
		{
			var config = {params: { page:$scope.pageno, size:$scope.pageSize, sdate:document.getElementById("startdate").value, edate:document.getElementById("enddate").value, disposition:$scope.disposition, sd:$scope.sd,asc:''}};
			$http.post(base_url+"cdr/cdr_details", null, config).then(function(response)
			{ 
				$scope.loading = false; $scope.didlist = response.data.tabledata; 
				myService.pagination($scope,$scope.pageno,$scope.pageSize,$scope.didlist,response.data.totalCount);
			});	
		}
		else
		{
			$scope.ajaxResult = "Select Start & End Dates"; myService.resMessage($scope,$timeout,202);
		}
	}
	
	$scope.sortbyCount = function (record,varResult) 
	{
		$scope.loading = true; var stats = document.getElementById("countsort").value;
		if(document.getElementById("startdate").value!='' &&  document.getElementById("enddate").value!='')
		{
			if(stats == 'ASC'){ document.getElementById("countsort").value = 'DESC'; } else if(stats == 'DESC'){ document.getElementById("countsort").value = 'ASC'; }
			var config = {params: { page:$scope.pageno, size:$scope.pageSize, sdate:document.getElementById("startdate").value, edate:document.getElementById("enddate").value, disposition:$scope.disposition, sd:$scope.sd,asc:stats}};
			$http.post(base_url+"cdr/cdr_details", null, config).then(function(response)
			{ 
				$scope.loading = false; $scope.didlist = response.data.tabledata; 
				myService.pagination($scope,$scope.pageno,$scope.pageSize,$scope.didlist,response.data.totalCount);
			});	
		}
		else
		{
			$scope.ajaxResult = "Select Start & End Dates"; myService.resMessage($scope,$timeout,202);
		}
	}
	
	$scope.getCDRIndetail = function (clid) 
	{
		$scope.loading = true;
		if(document.getElementById("startdate").value!='' &&  document.getElementById("enddate").value!='')
		{
			var config = {params: {clid:clid, sdate:document.getElementById("startdate").value, edate:document.getElementById("enddate").value, disposition:$scope.disposition, sd:$scope.sd}};
			$http.post(base_url+"cdr/cdr_indetails", null, config).then(function(response)
			{ 
				console.log(response);
				$scope.loading = false; $scope.indetaildidlist = response.data.tabledata; $('#cdrlist').modal({ backdrop: 'static', keyboard: false });
			});	
		}
		else
		{
			$scope.ajaxResult = "Select Start & End Dates"; myService.resMessage($scope,$timeout,202);
		}
	}
	
	$scope.getCDRIndetailSRC = function (clid) 
	{
		$scope.loading = true;
		if(document.getElementById("startdate").value!='' &&  document.getElementById("enddate").value!='')
		{
			var config = {params: {clid:clid, sdate:document.getElementById("startdate").value, edate:document.getElementById("enddate").value, disposition:$scope.disposition, sd:$scope.sd}};
			$http.post(base_url+"cdr/cdr_indetails_src", null, config).then(function(response)
			{ 
				console.log(response);
				$scope.loading = false; $scope.indetaildidlist = response.data.tabledata; $('#cdrlist').modal({ backdrop: 'static', keyboard: false });
			});	
		}
		else
		{
			$scope.ajaxResult = "Select Start & End Dates"; myService.resMessage($scope,$timeout,202);
		}
	}
	
	$scope.getWeeklyCDRIndetail = function (clid) 
	{
		$scope.loading = true;
		var config = {params: {clid:clid, disposition:$scope.disposition, sd:$scope.sd}};
		$http.post(base_url+"cdr/cdr_indetails_weekly", null, config).then(function(response)
		{ 
			console.log(response);
			$scope.loading = false; $scope.indetaildidlist = response.data.tabledata; $('#cdrlist').modal({ backdrop: 'static', keyboard: false });
		});	
	}
	
	$scope.csvvvvvvv = function()
	{
		window.location = base_url+"timegroup/timegroup_details_csv";
	}
	
	
});
//CDRs Page Ends


//CDRs Page Start
myapp.controller("cdrreport", function($scope,$http,$timeout,$location,myService) 
{
	$scope.pageno = 1; // initialize page no to 1
	$scope.selectables = [ {value: 10}, {value: 25}, {value: 50}, {value: 100}, {value: 200}, {value: 500}  ];
	$scope.pageSize = "100";
	$scope.totalCount = 0;
	$scope.selectedRow = function(row,val){ $scope.selRow = row; $scope.selectval = val; };
	$scope.sort = function(keyname){ $scope.sortKey = keyname; $scope.reverse = !$scope.reverse; }
	$scope.pageData = function(pageno){ $scope.pageno = pageno; $scope.getReportdidList(); }
	
	$scope.closeActionNew = function(){ $('#voicemaillisten').hide(); var vid = document.getElementById("myAudio");  vid.pause(); }
	$scope.voiceMailPlay = function(exten1)
	{
		$('#voicemaillisten').show();
		document.getElementById("extplay").innerHTML = '<audio  id="myAudio" controls autoplay><source src="http://112.196.109.66:8181/recording/'+exten1+'.wav" type="audio/wav"></audio>';
	}
	
	$scope.reasons = '';
	$http.get(base_url+"cdr/reasons").then(function(response)
	{
		$scope.reasonslist = response.data;
	});
	$scope.didedit = {};
	$scope.getCLIDBlock = function(clid,src,status)
	{
		$scope.didedit = angular.extend($scope.didedit,{clid:clid,is_global:'0',did:src,reason:'1'});
		$('#getCLIDBlock').show();
	}
	$scope.getCLIDBlockUpdate = function(didedit)
	{
			var config = {params: { didedit:didedit,status:'B'}};
			$http.post(base_url+"cdr/get_clid_block_status", null, config).then(function(response)
			{ 
				$scope.loading = false;  $('#getCLIDBlock').hide();
				if(response.data == 1)
				{
					$scope.ajaxResult = "DID Blocked Successfully";
					myService.resMessage($scope,$timeout,200); 
					$scope.getReportdidList();
				}
				else
				{
					$scope.ajaxResult = "Something went wrong, plz try again later";  myService.resMessage($scope,$timeout,202);
				}
			});	
	}
	$scope.getCLIDUnBlock = function(clid,src,status)
	{
		var config = {params: { clid:clid,src:src,status:status}};
		$http.post(base_url+"cdr/get_clid_unblock_status", null, config).then(function(response)
		{ 
			$scope.loading = false; 
			if(response.data == 1)
			{
				if(status=='B'){ $scope.ajaxResult = clid+" - DID Blocked Successfully";} else { $scope.ajaxResult =" DID Un Blocked Successfully"; } 
				myService.resMessage($scope,$timeout,200);
				$scope.getReportdidList();
			}
			else
			{
				$scope.ajaxResult = "Something went wrong, plz try again later";  myService.resMessage($scope,$timeout,202);
			}
		});	
	}
	
	$scope.getReportdidList = function () 
	{
		$scope.loading = true;
		if(document.getElementById("startdate").value!='' &&  document.getElementById("enddate").value!='')
		{
			var config = {params: { page:$scope.pageno, size:$scope.pageSize, sdate:document.getElementById("startdate").value, edate:document.getElementById("enddate").value, disposition:$scope.disposition, sd:$scope.sd}};
			$http.post(base_url+"cdr/cdr_details_report", null, config).then(function(response)
			{ 
				$scope.loading = false; $scope.didlist = response.data.tabledata; 
				myService.pagination($scope,$scope.pageno,$scope.pageSize,$scope.didlist,response.data.totalCount);
			});	
		}
		else
		{
			$scope.ajaxResult = "Select Start & End Dates"; myService.resMessage($scope,$timeout,202);
		}
	}
	
	$scope.getCDRIndetail = function (clid) 
	{
		$scope.loading = true;
		if(document.getElementById("startdate").value!='' &&  document.getElementById("enddate").value!='')
		{
			var config = {params: {sd:clid}};
			$http.post(base_url+"cdr/cdr_details_report_unanswered_popup", null, config).then(function(response)
			{ 
				$scope.loading = false; $scope.indetaildidlist = response.data.tabledata; $('#unniquelistpopup').modal({ backdrop: 'static', keyboard: false });
			});	
		}
		else
		{
			$scope.ajaxResult = "Select Start & End Dates"; myService.resMessage($scope,$timeout,202);
		}
	}

});
//CDRs Page Ends

//CDRs Page Start
myapp.controller("cdrunansweredreport", function($scope,$http,$timeout,$location,myService) 
{
	$scope.pageno = 1; // initialize page no to 1
	$scope.selectables = [ {value: 10}, {value: 25}, {value: 50}, {value: 100}, {value: 200}, {value: 500}  ];
	$scope.pageSize = "100";
	$scope.totalCount = 0;
	$scope.selectedRow = function(row,val){ $scope.selRow = row; $scope.selectval = val; };
	$scope.sort = function(keyname){ $scope.sortKey = keyname; $scope.reverse = !$scope.reverse; }
	$scope.pageData = function(pageno){ $scope.pageno = pageno; $scope.getReportdidList(); }
	
	$scope.closeActionNew = function(){ $('#voicemaillisten').hide(); var vid = document.getElementById("myAudio");  vid.pause(); }
	$scope.voiceMailPlay = function(exten1)
	{
		$('#voicemaillisten').show();
		document.getElementById("extplay").innerHTML = '<audio  id="myAudio" controls autoplay><source src="http://112.196.109.66:8181/recording/'+exten1+'.wav" type="audio/wav"></audio>';
	}
	
	$scope.reasons = '';
	$http.get(base_url+"cdr/reasons").then(function(response)
	{
		$scope.reasonslist = response.data;
	});
	$scope.didedit = {};
	$scope.getCLIDBlock = function(clid,src,status)
	{
		$scope.didedit = angular.extend($scope.didedit,{clid:clid,is_global:'0',did:src,reason:'1'});
		$('#getCLIDBlock').show();
	}
	$scope.getCLIDBlockUpdate = function(didedit)
	{
			var config = {params: { didedit:didedit,status:'B'}};
			$http.post(base_url+"cdr/get_clid_block_status", null, config).then(function(response)
			{ 
				$scope.loading = false;  $('#getCLIDBlock').hide();
				if(response.data == 1)
				{
					$scope.ajaxResult = "DID Blocked Successfully";
					myService.resMessage($scope,$timeout,200); 
					$scope.getReportdidList();
				}
				else
				{
					$scope.ajaxResult = "Something went wrong, plz try again later";  myService.resMessage($scope,$timeout,202);
				}
			});	
	}
	$scope.getCLIDUnBlock = function(clid,src,status)
	{
		var config = {params: { clid:clid,src:src,status:status}};
		$http.post(base_url+"cdr/get_clid_unblock_status", null, config).then(function(response)
		{ 
			$scope.loading = false; 
			if(response.data == 1)
			{
				if(status=='B'){ $scope.ajaxResult = clid+" - DID Blocked Successfully";} else { $scope.ajaxResult =" DID Un Blocked Successfully"; } 
				myService.resMessage($scope,$timeout,200);
				$scope.getReportdidList();
			}
			else
			{
				$scope.ajaxResult = "Something went wrong, plz try again later";  myService.resMessage($scope,$timeout,202);
			}
		});	
	}
	
	$scope.getReportdidList = function (record,varResult) 
	{
		$scope.loading = true;
		if(document.getElementById("startdate").value!='' &&  document.getElementById("enddate").value!='')
		{
			var config = {params: { page:$scope.pageno, size:$scope.pageSize, sdate:document.getElementById("startdate").value, edate:document.getElementById("enddate").value, disposition:$scope.disposition, sd:$scope.sd}};
			$http.post(base_url+"cdr/cdr_details_report_unanswered", null, config).then(function(response)
			{ 
				$scope.loading = false; $scope.didlist = response.data.tabledata; 
				myService.pagination($scope,$scope.pageno,$scope.pageSize,$scope.didlist,response.data.totalCount);
			});	
		}
		else
		{
			$scope.ajaxResult = "Select Start & End Dates"; myService.resMessage($scope,$timeout,202);
		}
	}

});
//CDRs Page Ends


//manageTimeGroup Page Start
myapp.controller("managePrompt", function($scope,$http,$timeout,$location,myService) 
{
	$scope.pageno = 1; // initialize page no to 1
	$scope.selectables = [ {value: 10}, {value: 25}, {value: 50}, {value: 100}, {value: 200}, {value: 500}  ];
	$scope.pageSize = "10";
	$scope.totalCount = 0;
	$scope.selectedRow = function(row,val){ $scope.selRow = row; $scope.selectval = val; };
	$scope.sort = function(keyname){ $scope.sortKey = keyname; $scope.reverse = !$scope.reverse; }
	$scope.pageData = function(pageno){ $scope.pageno = pageno; $scope.getdidList(); }
	
	$scope.getdidList = function (record,varResult) 
	{
		$scope.loading = true; 
		var config = {params: { page:$scope.pageno, size:$scope.pageSize, keyword:$scope.keywords}};
		$http.post(base_url+"timegroup/prompt_details", null, config).then(function(response)
		{ 
			$scope.loading = false; $scope.didlist = response.data.tabledata; console.log(response);
			myService.pagination($scope,$scope.pageno,$scope.pageSize,$scope.didlist,response.data.totalCount);
		});	
	}
	$scope.getdidList();
	
	$scope.voiceMailPlay = function(exten1)
	{
		$('#voicemaillisten').modal({ backdrop: 'static', keyboard: false });
		document.getElementById("extplay").innerHTML = '<audio  id="myAudio" controls autoplay><source src="http://112.196.109.66:8181/mentor/promptdocs/'+exten1+'" type="audio/wav"></audio>';
	}
	$scope.closeActionNew = function(){ $('#voicemaillisten').modal("hide"); var vid = document.getElementById("myAudio");  vid.pause(); }
	
	$scope.getTimegroupDelete = function(id)
	{
		if(confirm("Are you sure you want to delete Prompt?"))
		{
			var config = {params:{id:id}}; $scope.loading = true;
		 	$http.post(base_url+"did_management/prompt_delete", null, config).then(function(response)
		 	{  $scope.loading = false; 
		 	$scope.ajaxResult = response.data.errmsg; myService.resMessage($scope,$timeout, response.data.errcode);  $scope.getdidList();
			});
		}
	}
	
	$scope.TimegroupbulkDelete = function()
	{
		var checkboxes = document.getElementsByName('location[]');
		var vals = "";
		for (var i=0, n=checkboxes.length;i<n;i++) 
		{
			if (checkboxes[i].checked) 
			{
				vals += ","+checkboxes[i].value;
			}
		}
		if (vals) vals = vals.substring(1);
		if(vals !='')
		{
			if(confirm("Are you sure you want to delete Prompt?"))
			{
				var config = {params:{id:vals}}; $scope.loading = true;
				$http.post(base_url+"did_management/prompt_delete_bulk", null, config).then(function(response)
				{  $scope.loading = false; 
				$scope.ajaxResult = response.data.errmsg; myService.resMessage($scope,$timeout, response.data.errcode); $scope.getdidList();
				});
			}
		}
		else
		{
			$scope.ajaxResult = "Please select Prompt to delete"; myService.resMessage($scope,$timeout,202);
		}
	}
	
	
	$scope.getTimeGroupEdit = function(list)
	{
		$scope.didedit = list; $('#timegroupedit').modal({ backdrop: 'static', keyboard: false }); 
	}
	
	$scope.getTimeGroupUpdate = function(id)
	{
		$scope.loader = true; var fd = new FormData(); fd.append("fileInput", $scope.files); $('#timegroupedit').modal('hide');
		$http.post(base_url+"timegroup/prompt_update",fd,{transformRequest: angular.identity,params:{formdata:id},headers: {'Content-Type': undefined}})
		.then(function(response){ $scope.loader = false;
			$scope.ajaxResult = response.data.errmsg; myService.resMessage($scope,$timeout,response.data.errcode);
			if(response.data.errcode == 200){ $scope.getdidList();  }
		});
	}
	
	$scope.getReverse = function()
	{
		$scope.getdidList(); $('#timegroupedit').modal('hide');
	}
	
	$scope.csvvvvvvv = function()
	{
		window.location = base_url+"timegroup/timegroup_details_csv";
	}
	
	$scope.getAddDID = function(){  $scope.didedit = {}; $('#adddid').modal({ backdrop: 'static', keyboard: false }); }
	$scope.didCreate = function (record,varResult) 
	{
		$scope.loader = true; var fd = new FormData(); fd.append("fileInput", $scope.files); $('#adddid').modal('hide');
		$http.post(base_url+"timegroup/prompt_create",fd,{transformRequest: angular.identity,params:{formdata:record},headers: {'Content-Type': undefined}})
		.then(function(response){ $scope.loader = false; console.log(response);
			$scope.ajaxResult = response.data.errmsg; myService.resMessage($scope,$timeout,response.data.errcode);
			if(response.data.errcode == 200){ $scope.getdidList();  }
		});
	}
});
//manageTimeGroup Page Ends
//For Login Page - Start
myapp.controller("loginController", function($scope,$http,$window,$timeout,myService) 
{
											 
	$scope.getLoginCheck = function (formdata)
	{
		var config = { params: { formdata : formdata } };
		$http.post(base_url+"login/checklogin", null, config).then(function(response)
		{	 
			console.log(response);
			if(response.data.errcode == 200)
			{
				window.location = base_url+response.data.errmsg;
			}
			else
			{
				alert("Invalid Credentails");
				$scope.ajaxResult = "Invalid Credentails"; myService.resMessage($scope,$timeout,202);
			}
		});	
	};
});
//For Login Page - End
