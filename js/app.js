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
    $("#addMember").off("click").on("click", MEMBER.addMember);
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

    // sessionStorage.setItem("member_id", 55);

    COMMON.initCommonVars();

    MEMBER.initMember();
});
