$(document).ready(function(){
    var date_input=$('input[name$="date"]'); //our date input has the name "date"
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    var options={
    format: 'dd/mm/yyyy',
    container: container,
    todayHighlight: true,
    autoclose: true,
    orientation: 'auto top'
    };
    date_input.datepicker(options);
    $(".glyphicon-log-out").off("click").on("click", function(){
      COMMON.showModal("logoutModal");
    });
    $("#addAdminBtn").off("click").on("click", ADMIN.addAdmin);
    $("#editAdminBtn").off("click").on("click", ADMIN.editAdmin);
    $("#cancelEditBtn").off("click").on("click", function(){
      $("[name=password]").val("");
      COMMON.disableInnerEls("#add-admin");
      $("button").hide();
    });

    COMMON.initCommonVars();

    ADMIN.init();
});
