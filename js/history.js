$(document).ready(function() {
  $(".glyphicon-log-out").off("click").on("click", function(){
    COMMON.showModal("logoutModal");
  });
  COMMON.initCommonVars();
  var type = sessionStorage.getItem("historyType");
  if(type === "payment"){
    MEMBER.showPaymentHistory();
  } else if(type === "btg"){
    MEMBER.showBTGHistory();
  } else if(["gift", "prasadam"].indexOf(type) > -1){
    MEMBER.showGiftPrasadamHistory(type);
  } else if(type === "followup"){
    MEMBER.showFollowupHistory();
  }
});
