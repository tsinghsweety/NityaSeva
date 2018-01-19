$(document).ready(function(){
    var date_input=$('input[name="start_date"]'); //our date input has the name "date"
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    var options={
    format: 'dd/mm/yyyy',
    container: container,
    todayHighlight: true,
    autoclose: true,
    orientation: 'auto top'
    };
    date_input.datepicker(options);
    $("#addMember").off("click").on("click", MEMBER.addMember);

    $("section:gt(0)").hide();
    $("section#member-section").show();

    COMMON.initCommonVars();
});
