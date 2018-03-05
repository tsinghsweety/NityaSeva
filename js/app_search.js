$(document).ready(function(){
    var date_input=$('input[name$="date"]'); //our date input has the name "date"
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    var options={
    format: 'dd/mm/yyyy',
    endDate: '0d',
    container: container,
    todayHighlight: true,
    autoclose: true,
    orientation: 'auto top'
    };
    date_input.datepicker(options);
    $("#category").off("change").on("change", SEARCH.showSubCategory);
    $("#search_btn").off("click").on("click", SEARCH.search);

    COMMON.initCommonVars();
    COMMON.checkUserLoggedin();

    SEARCH.init();
});
