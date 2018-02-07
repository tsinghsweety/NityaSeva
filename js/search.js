var SEARCH = {
  searchArr: [],
  init: function() {
    SEARCH.searchArr = [
      {idx: 1, name: "All members", value:"all_members", subCatType: "select", subCatValues: ["All"]},
      {idx: 2, name: "Member Name", value:"member_name", subCatType: "inputText"},
      {idx: 3, name: "Phone Num", value:"phone_num", subCatType: "inputText"},
      {idx: 4, name: "Donation Category", value:"donation_category", subCatType: "select", subCatValues: ["Prabhupada Sevak", "Jagannath Sevak", "Govind Sevak"]},
      {idx: 5, name: "Active Member", value:"active_member", subCatType: "select", subCatValues: ["Y", "N"]},
      {idx: 6, name: "Payment Due", value:"payment_due", subCatType: "select", subCatValues: ["Y", "N"]},
      {idx: 7, name: "Current Payment Done", value:"current_payment_done", subCatType: "select", subCatValues: ["Y", "N"]},
      {idx: 8, name: "Corresponder", value:"corresponder_name", subCatType: "select", url: "member/corresponderlist", ddKey: "corresponder_name"},
      {idx: 9, name: "Connected To", value:"connected_to", subCatType: "select", url: "member/connectedlist", ddKey: "connected_to"}
    ];

    //Create Category Drop Down
    var optionList = "<option value='none'>Select</option>";
    for(var i=0; i<SEARCH.searchArr.length; i++){
      var obj = SEARCH.searchArr[i];

      optionList += "<option value='"+obj['value']+"' data-idx='"+obj['idx']+"' data-subtype='"
      +obj['subCatType']+"'>"+obj["name"]+"</option>";
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
      var inside_conditions = false;
      if(url){
        inside_conditions = true;
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

                $("#sub_category_select").html(optionList);
                $("#sub_category_input_text").hide();
                $("#sub_category_select").show();
              }
          },
          error: function(xhr, status){
            console.log(xhr, status);
          }
        });
      } else if (subCatValues) {
        inside_conditions = true;
        var optionList = "<option>Select</option>";
        for (var i=0; i<subCatValues.length; i++) {
          optionList += "<option>"+subCatValues[i]+"</option>";
        }

        $("#sub_category_select").html(optionList);
        $("#sub_category_input_text").hide();
        $("#sub_category_select").show();
      } else if (subCategoryType === "inputText") {
        inside_conditions = true;
        $("#sub_category_select").hide();
        $("#sub_category_input_text").val("");
        $("#sub_category_input_text").show();
        $("#sub_category_input_text").off("keydown").on("keydown", function(event){
          var key = event.which || event.keyCode;
          if(key === 13){
            $("#search_btn").click();
          }
        });
      }

      if(inside_conditions){
        $("#search_result").empty();
      }
    }
  },
  search: function(){
    var category = $("#category").val();
    var sub_cat_type = $("#category").data("subtype");
    var sub_category = sub_cat_type === "select" ? $("#sub_category_select").val() : $("#sub_category_input_text").val();
    var url = CONSTANTS.API_PATH + "member/categorySearch";
    var data = {
      category: category,
      sub_category: sub_category
    };
    // if(category === "all_members"){
    //   url = CONSTANTS.API_PATH + "member/list";
    // }
    $.ajax({
      url: url,
      type: "POST",
      data: JSON.stringify(data),
      dataType: "json",
      success: function(data, statusTxt){
        console.log(data, statusTxt);
        if(data.output.success === 1){
          var membersArr = data.output.members;
          if(membersArr){
            var tableEl = "<table border='2'>"
            +"<thead>"
            +"<th>Sl No</th><th>User ID</th><th>Name</th><th>Phone Number</th>"
            +"<th>Email</th><th>Corresponder Name</th><th>Connected To</th>"
            +"<th>Scheme</th><th>Member Since</th><th>BTG Lang Pref</th>"
            +"<th>Last Payment</th><th>Last Followup</th><th>Last BTG Sent</th>"
            +"<th>Last Gift Sent</th><th>Last Prasadam Sent</th>"
            +"</thead>"
            +"<tbody>";

            for (var i = 0; i < membersArr.length; i++) {
              var memberData = membersArr[i];
              tableEl += "<tr>";
              tableEl += "<td>"+(i+1)+"</td>";
              tableEl += "<td><a href='member.html' class='user_id'>"+memberData['user_id']+"</a></td>";
              tableEl += "<td>"+memberData['title']+" "+memberData['first_name']+" "+memberData["last_name"]+"</td>";
              tableEl += "<td>"+memberData['phone_no']+"</td>";
              tableEl += "<td>"+memberData['email_id']+"</td>";
              tableEl += "<td>"+memberData['corresponder']+"</td>";
              tableEl += "<td>"+memberData['connected_to']+"</td>";
              tableEl += "<td>"+memberData['scheme_name']+"</td>";
              tableEl += "<td>"+memberData['start_date']+"</td>";
              tableEl += "<td>"+memberData['user_lang']+"</td>";
              tableEl += "<td>"+memberData['last_payment_date']+"</td>";
              tableEl += "<td>"+memberData['last_followup_date']+"</td>";
              tableEl += "<td>"+memberData['last_btg_sent_date']+"</td>";
              tableEl += "<td>"+memberData['last_gift_sent_date']+"</td>";
              tableEl += "<td>"+memberData['last_prasadam_sent_date']+"</td>";
              tableEl += "</tr>";
            }

            tableEl += "</tbody></table>";

            $("#search_result").html(tableEl);

            $("#search_result .user_id").off("click").on("click", function(){
              var id = $(this).text();
              sessionStorage.setItem("member_id", id);
            });
          } else {
            $("#search_result").empty();
            COMMON.showModal("myModal", "Sorry", "No member found for given criteria");
          }
        } else if (data.output.success === 0) {
          if(data.output.msg === "API issue"){
            COMMON.showModal("myModal", "Sorry", data.output.msg + ", Code: " + data.output.code);
          } else {
            COMMON.showModal("myModal", "Sorry", data.output.msg);
          }
        }
      },
      error: function(xhr, status){
        console.log(xhr, status);
      }
    });
  }
};
