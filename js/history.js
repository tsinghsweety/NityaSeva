$(document).ready(function() {
  COMMON.initCommonVars();
  var type = sessionStorage.getItem("historyType");
  if(type === "payment"){
    MEMBER.showPaymentHistory();
  }
});
