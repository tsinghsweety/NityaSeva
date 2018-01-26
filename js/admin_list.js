$(document).ready(function(){
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";

    COMMON.initCommonVars();

    ADMIN.showAdminList();

});
