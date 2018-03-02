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
    $("#addMemberBtn").off("click").on("click", MEMBER.addMember);
    $("#editMemberBtn").off("click").on("click", MEMBER.editMember);
    $("#addpayment").off("click").on("click", MEMBER.addPayment);
    $("#add_btg").off("click").on("click", MEMBER.addBTG);
    $("#add_gift").off("click").on("click", {type: 'gift'}, MEMBER.addGiftPrasadam);
    $("#add_prasadam").off("click").on("click", {type: 'prasadam'}, MEMBER.addGiftPrasadam);
    $("#add_followup").off("click").on("click", MEMBER.addFollowup);
    $("#showPaymentHistory").off("click").on("click", function(){
      sessionStorage.setItem('historyType', 'payment');
    });
    $("#showBTGHistory").off("click").on("click", function(){
      sessionStorage.setItem('historyType', 'btg');
    });
    $("#showGiftHistory").off("click").on("click", function(){
      sessionStorage.setItem('historyType', 'gift');
    });
    $("#showPrasadamHistory").off("click").on("click", function(){
      sessionStorage.setItem('historyType', 'prasadam');
    });
    $("#showFollowupHistory").off("click").on("click", function(){
      sessionStorage.setItem('historyType', 'followup');
    });

    $("#cancelEditBtn").off("click").on("click", function(){
      $("[name=password]").val("");
      COMMON.disableInnerEls("#member-section");
      $("#member-section button").hide();
    });

    // sessionStorage.setItem("member_id", 55);

    COMMON.initCommonVars();

    MEMBER.initMember();
});
