let holidaydata = [['2019-08-06','0','8802988787'],['2019-08-07','1','8802988787'],['2019-08-08','0','8802988787'],['2019-08-09','1','8802988787'],['2019-08-10','0','8802988787'],['2019-08-11','0','8802988787']];
let timegroupdata = [['Name','TimeGroup'],['Name1','09:00-18:00,Sat-Sat,1-31,Jan-Dec'],['Name2','09:00-18:00,Sat-Sat,1-31,Jan-Dec'],['Name3','09:00-18:00,Sat-Sat,1-31,Jan-Dec'],['Name4','09:00-18:00,Sat-Sat,1-31,Jan-Dec'],['Name5','09:00-18:00,Sat-Sat,1-31,Jan-Dec']];
let didwiseblobkingdata = [['8802988787', '8802988787','1','1','1'],['8802988787', '8802988787','1','1','1'],['8802988787', '8802988787','1','1','1'],['8802988787', '8802988787','1','1','1'],['8802988787', '8802988787','1','1','1'],['8802988787', '8802988787','1','1','1']];
let globalblobkingdata = [['8802988787'],['8702988789'],['8802988788'],['8802988779'],['8702988785'],['8802988783']];
let diddata = [['8802988787','1','8802988787','1','1','2','playback','tt-monkeys','playback','tt-monkeys','9856325698;7896541236','9856325698;7896541236','9856325698;7896541236','9856325698;7896541236'],['8802988787','1','8802988787','1','1','2','playback','tt-monkeys','playback','tt-monke','9856325698;7896541236','9856325698;7896541236','9856325698;7896541236','9856325698;7896541236'],['8802988787','1','8802988787','1','1','2','playback','tt-monkeys','playback','tt-monke','9856325698;7896541236','9856325698;7896541236','9856325698;7896541236','9856325698;7896541236'],['8802988787','1','8802988787','1','1','2','playback','tt-monkeys','playback','tt-monkeys','9856325698;7896541236','9856325698;7896541236','9856325698;7896541236','9856325698;7896541236']];
 
function sampleTimeGroupCsv() {
    let csv = 'Name,TimeGroup\n';
    timegroupdata.forEach(function(row) {
            csv += row.join(',');
            csv += "\n";
    });
    let hiddenElement = document.createElement('a');
    hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
    hiddenElement.target = '_blank';
    hiddenElement.download = 'TimeGroup_Sample.csv';
    hiddenElement.click();
}
function sampleHolidayCsv() {
    let csv = 'Date,IsGlobal,DID\n';
    holidaydata.forEach(function(row) {
            csv += row.join(',');
            csv += "\n";
    });
    let hiddenElement = document.createElement('a');
    hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
    hiddenElement.target = '_blank';
    hiddenElement.download = 'Holiday_Sample.csv';
    hiddenElement.click();
}
function sampleDidWiseBlockingCsv() {
    let csv = 'Caller No.,DID,IsActive,IsGlobal,DND\n';
    didwiseblobkingdata.forEach(function(row) {
            csv += row.join(',');
            csv += "\n";
    });
    let hiddenElement = document.createElement('a');
    hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
    hiddenElement.target = '_blank';
    hiddenElement.download = 'DidWiseBlocking_Sample.csv';
    hiddenElement.click();
}
function sampleGlobalBlockingCsv(){
	let csv = 'Phone\n';
    globalblobkingdata.forEach(function(row) {
            csv += row.join(',');
            csv += "\n";
    });
    let hiddenElement = document.createElement('a');
    hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
    hiddenElement.target = '_blank';
    hiddenElement.download = 'GlobalBlocking_Sample.csv';
    hiddenElement.click();
}
function sampleDidManagementCsv(){
	let csv = 'DID,DID_STATUS,DID_CLI,CALL_RECORDING,HOLIDAY_CHECK,TIME_GROUPID,OffTime_destination_type,OffTime_destination_type_value,holiday_destination_type,holiday_destination_type_value,Mapped No.,Fallback No.,Off Hour No., Holiday No\n';
    diddata.forEach(function(row) {
            csv += row.join(',');
            csv += "\n";
    });
    let hiddenElement = document.createElement('a');
    hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
    hiddenElement.target = '_blank';
    hiddenElement.download = 'Did_Sample.csv';
    hiddenElement.click();
}