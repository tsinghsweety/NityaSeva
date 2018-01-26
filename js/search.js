var SEARCH = {
  searchArr: [],
  init: function() {
    SEARCH.searchArr = [
      {idx: 1, name: "Donation Category", value:"donation_category", subCatType: "select", subCatValues: ["Prabhupada Sevak", "Jagannath Sevak", "Govind Sevak"]},
      {idx: 2, name: "Active Member", value:"active_member", subCatType: "select", subCatValues: ["Y", "N"]},
      {idx: 3, name: "Payment Due", value:"payment_due", subCatType: "select", subCatValues: ["Y", "N"]},
      {idx: 4, name: "Current Payment Done", value:"current_payment_done", subCatType: "select", subCatValues: ["Y", "N"]},
      {idx: 5, name: "Corresponder", value:"corresponder", subCatType: "select", url: "member/corresponderlist"},
      {idx: 6, name: "Connected To", value:"connected_to", subCatType: "select", url: "member/connectedlist"}
    ];

    //Create Category Drop Down
    var optionList = "<option value='none'>Select</option>";
    for(var i=0; i<SEARCH.searchArr.length; i++){
      var obj = SEARCH.searchArr[i];

      optionList += "<option value='"+obj['value']+"' data-idx='"+obj['idx']+"'>"+obj["name"]+"</option>";
    }

    $("#search_category").html(optionList);
  },
  showSubCategory: function(event){
    var el = event.target;
    var optionIdx = $(el).data("idx");
    if(optionIdx) {
      
    }
  }
};
