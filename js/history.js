$(document).ready(function() {
  COMMON.initCommonVars();
  COMMON.checkUserLoggedin();
  
  var type = localStorage.getItem("historyType");
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
