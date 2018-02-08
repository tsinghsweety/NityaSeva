$(document).ready(function(){
    $(".glyphicon-log-out").off("click").on("click", function(){
      COMMON.showModal("logoutModal");
    });
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";

    COMMON.initCommonVars();

    ADMIN.showAdminList();

});
