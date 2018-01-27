var SEARCH = {
  searchArr: [],
  init: function() {
    SEARCH.searchArr = [
      {idx: 1, name: "Donation Category", value:"donation_category", subCatType: "select", subCatValues: ["Prabhupada Sevak", "Jagannath Sevak", "Govind Sevak"]},
      {idx: 2, name: "Active Member", value:"active_member", subCatType: "select", subCatValues: ["Y", "N"]},
      {idx: 3, name: "Payment Due", value:"payment_due", subCatType: "select", subCatValues: ["Y", "N"]},
      {idx: 4, name: "Current Payment Done", value:"current_payment_done", subCatType: "select", subCatValues: ["Y", "N"]},
      {idx: 5, name: "Corresponder", value:"corresponder", subCatType: "select", url: "member/corresponderlist", ddKey: "corresponder_name"},
      {idx: 6, name: "Connected To", value:"connected_to", subCatType: "select", url: "member/connectedlist", ddKey: "connected_to"}
    ];

    //Create Category Drop Down
    var optionList = "<option value='none'>Select</option>";
    for(var i=0; i<SEARCH.searchArr.length; i++){
      var obj = SEARCH.searchArr[i];

      optionList += "<option value='"+obj['value']+"' data-idx='"+obj['idx']+"'>"+obj["name"]+"</option>";
    }

    $("#category").html(optionList);
  },
  showSubCategory: function(event){
    var el = event.target;
    var optionIdx = $(el).find("option:selected").data("idx");
    if(optionIdx > 0) {
      var selectedOption = SEARCH.searchArr[optionIdx - 1];
      var subCategoryType = selectedOption.subCatType;
      var subCatValues = selectedOption.subCatValues;
      var url = selectedOption.url;
      if(url){
        var ddKey = selectedOption.ddKey;
        $.ajax({
          url: CONSTANTS.API_PATH + url,
          type: "GET",
          dataType: "json",
          success: function(data, statusTxt){
            console.log(data, statusTxt);
            var optionList = "<option>Select</option>";
            // if(data.success === 1){
              if(data.output.length > 0){
                var subCatArr = data.output;
                for (var i=0; i<subCatArr.length; i++) {
                  optionList += "<option>"+subCatArr[i][ddKey]+"</option>";
                }

                $("#sub_category").html(optionList);
              }
            // } else if (data.success === 0) {
            //   if(data.msg === "API issue"){
            //     COMMON.showModal("myModal", "Sorry", data.msg + ", Code: " + data.code);
            //   } else {
            //     COMMON.showModal("myModal", "Sorry", data.msg);
            //   }
            // }
          },
          error: function(xhr, status){
            console.log(xhr, status);
          }
        });
      } else if (subCatValues) {
        var optionList = "<option>Select</option>";
        for (var i=0; i<subCatValues.length; i++) {
          optionList += "<option>"+subCatValues[i]+"</option>";
        }

        $("#sub_category").html(optionList);
      }
    }
  },
  // search: function(){
  //   var category = $("#category").val();
  //   var sub_category = $("#sub_category").val();
  //   switch (category) {
  //     case 'donation_category':
  //       url = "member/list"
  //       break;
  //     default:
  //
  //   }
  // }
};
