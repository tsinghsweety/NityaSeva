var MEMBER = {
    initMember: function(){
      var memberId = sessionStorage.getItem("member_id");
      if(memberId){
        $.ajax({
            url: CONSTANTS.API_PATH + "member/list/" + memberId,
            // url: apiPath + "member-api/RestController.php?page_key=create",
            method: "GET",
            // data: JSON.stringify(data),
            dataType: "json",
            success: function(data, statusTxt){
                console.log(data, statusTxt);
                if(data.output.length > 0){
                  var userData = data.output[0];
                  COMMON.disableInnerEls("section:eq(0)");

                  var userActive = userData['is_active'];

                  $("#member-section button").hide();

                  //Fill Various Field Values
                  $('[name=payment_scheme_name]').val(userData['scheme_name']);
                  $('[name=payment_scheme_value]').val(userData['scheme_value']);
                  $('[name=btg_lang]').val(userData['user_lang']);
                  $('[name=due_amt]').val(userData['scheme_value']);

                  $("[name=title]").val(userData['title']);
                  $("[name=first_name]").val(userData['first_name']);
                  $("[name=last_name]").val(userData['last_name']);
                  $("[name=address]").val(userData['address']);
                  $("[name=phone_no]").val(userData['phone_no']);
                  $("[name=whatsapp]").val(userData['whatsapp']);
                  $("[name=birth_date]").val(userData['dob']);
                  $("[name=email_id]").val(userData['email_id']);
                  $("[name=company_name]").val(userData['company_name']);
                  $("[name=start_date]").datepicker('update', userData['start_date']);
                  $("[name=is_active][value="+userActive+"]").prop("checked", "true");
                  $("[name=connected_to]").val(userData['connected_to']);
                  $("[name=scheme_name]").val(userData['scheme_name']);
                  $("[name=payment_type]").val(userData['payment_type']);
                  $("[name=user_lang]").val(userData['user_lang']);
                  $("[name=remarks]").val(userData['remarks']);

                  $("#editMember").off("click").on("click", function(){
                    $("input, button, textarea, select, input").prop("disabled", false);
                    $("[name=password]").val(userData['pwd']);
                    $("#editMemberBtn").show();
                    $("#cancelEditBtn").show();
                  });

                  var optionList = "<option>Select</option>";
                  $.ajax({
                    url: CONSTANTS.API_PATH + "member/corresponderlist",
                    type: "GET",
                    dataType: "json",
                    success: function(data, statusTxt) {
                      console.log(data, statusTxt);
                      if(data.output.length > 0){
                        var list = data.output;
                        for(var i=0; i<list.length;i++){
                          optionList += "<option>"+list[i]['corresponder_name']+"</option>";
                        }
                      }

                      optionList += "<option>New</option>";
                      $("#corresponder_name").html(optionList);
                      $("[name=corresponder]").val(userData['corresponder'].trim());
                    },
                    error: function(xhr, status) {
                      console.log(xhr, status);
                      optionList += "<option>New</option>";
                      $("#corresponder_name").html(optionList);
                    }
                  });

                  $("section:gt(0)").show();
                } else {
                  COMMON.showModal("myModal", "Sorry", "No member found for member id: " + memberId);
                }
            },
            error: function(xhr, status){
                console.log(xhr, status);
            }
        });
      } else {
        $("#editMemberBtn, #editMember, #cancelEditBtn").hide();
        $("#addMemberBtn").show();
        $("section:gt(0)").hide();
        var optionList = "<option>Select</option>";
        $.ajax({
          url: CONSTANTS.API_PATH + "member/corresponderlist",
          type: "GET",
          dataType: "json",
          success: function(data, statusTxt) {
            console.log(data, statusTxt);
            if(data.output.length > 0){
              var list = data.output;
              for(var i=0; i<list.length;i++){
                optionList += "<option>"+list[i]['corresponder_name']+"</option>";
              }
            }

            optionList += "<option>New</option>";
            $("#corresponder_name").html(optionList);
          },
          error: function(xhr, status) {
            console.log(xhr, status);
            optionList += "<option>New</option>";
            $("#corresponder_name").html(optionList);
          }
        });
        $("section#member-section").show();
      }
    },
    addMember: function(){
        var data = COMMON.createFormDataJson("#member-section");
        // console.log("data");
        // console.log(data);
        $.ajax({
            url: CONSTANTS.API_PATH + "member/create",
            // url: apiPath + "member-api/RestController.php?page_key=create",
            method: "POST",
            data: JSON.stringify(data),
            // dataType: "json",
            success: function(data, statusTxt){
                console.log(data, statusTxt);
                if(data.success === 1){
                  var userData = data.userData;
                  COMMON.disableInnerEls("section:eq(0)");

                  //Fill Various Field Values
                  $('[name=payment_scheme_name]').val(userData['scheme_name']);
                  $('[name=payment_scheme_value]').val(userData['scheme_value']);
                  $('[name=btg_lang]').val(userData['user_lang']);
                  $('[name=due_amt]').val(userData['scheme_value']);

                  sessionStorage.setItem("member_id", userData['user_id']);

                  $("section:gt(0)").show();
                  COMMON.showModal("myModal", "Yay!", data.msg);
                } else if(data.success === 0) {
                  if(data.msg === "API issue"){
                    COMMON.showModal("myModal", "Sorry", data.msg + ", Code: " + data.code);
                  } else {
                    COMMON.showModal("myModal", "Sorry", data.msg);
                  }
                }
            },
            error: function(xhr, status){
                console.log(xhr, status);
            }
        });
    },
    editMember: function () {
      var jsonData = COMMON.createFormDataJson("#member-section");
      console.log(jsonData);
      var memberId = sessionStorage.getItem("member_id");
      if(memberId){
        $.ajax({
            url: CONSTANTS.API_PATH + "member/update/" + memberId,
            // url: apiPath + "member-api/RestController.php?page_key=create",
            method: "POST",
            data: JSON.stringify(jsonData),
            // dataType: "json",
            success: function(data, statusTxt){
              console.log(data, statusTxt);
              if(data.success === 1){
                COMMON.showModal("myModal", "Hari Bol!", data.msg, "#member-section", true);
              } else if(data.success === 0) {
                if(data.msg === "API issue"){
                  COMMON.showModal("myModal", "Sorry", data.msg + ", Code: " + data.code);
                } else {
                  COMMON.showModal("myModal", "Sorry", data.msg);
                }
              }
            },
            error: function(xhr, statusTxt){
              console.log(xhr, status);
            }
        });
      }
    },
    addPayment: function(){
      var jsonData = COMMON.createFormDataJson("#payment-section");
      console.log(jsonData);
      $.ajax({
          url: CONSTANTS.API_PATH + "payment/create",
          // url: apiPath + "member-api/RestController.php?page_key=create",
          method: "POST",
          data: JSON.stringify(jsonData),
          // dataType: "json",
          success: function(data, statusTxt){
            console.log(data, statusTxt);
            if(data.success === 1){
              COMMON.showModal("myModal", "Hari Bol!", data.msg);
            } else if(data.success === 0) {
              if(data.msg === "API issue"){
                COMMON.showModal("myModal", "Sorry", data.msg + ", Code: " + data.code);
              } else {
                COMMON.showModal("myModal", "Sorry", data.msg);
              }
            }
          },
          error: function(xhr, statusTxt){
            console.log(xhr, status);
          }
        });
    },
    addBTG: function(){
      var jsonData = COMMON.createFormDataJson("#btg-section");
      console.log(jsonData);
      $.ajax({
        url: CONSTANTS.API_PATH + "btg/create",
        // url: apiPath + "member-api/RestController.php?page_key=create",
        method: "POST",
        data: JSON.stringify(jsonData),
        // dataType: "json",
        success: function(data, statusTxt){
          console.log(data, statusTxt);
          if(data.success === 1){
            COMMON.showModal("myModal", "Hari Bol!", data.msg);
          } else if(data.success === 0) {
            if(data.msg === "API issue"){
              COMMON.showModal("myModal", "Sorry", data.msg + ", Code: " + data.code);
            } else {
              COMMON.showModal("myModal", "Sorry", data.msg);
            }
          }
        },
        error: function(xhr, statusTxt){
          console.log(xhr, status);
        }
      });
    },
    addGiftPrasadam: function(event){
      var giftType = event.data ? event.data.type : '';
      var section = "#" + giftType + "-section";
      var jsonData = COMMON.createFormDataJson(section);
      var url = CONSTANTS.API_PATH + giftType + "/create";
      console.log(jsonData);
      $.ajax({
        url: url,
        // url: apiPath + "member-api/RestController.php?page_key=create",
        method: "POST",
        data: JSON.stringify(jsonData),
        // dataType: "json",
        success: function(data, statusTxt){
          console.log(data, statusTxt);
          if(data.success === 1){
            COMMON.showModal("myModal", "Yay!", data.msg);
          } else if(data.success === 0) {
            if(data.msg === "API issue"){
              COMMON.showModal("myModal", "Sorry", data.msg + ", Code: " + data.code);
            } else {
              COMMON.showModal("myModal", "Sorry", data.msg);
            }
          }
        },
        error: function(xhr, statusTxt){
          console.log(xhr, status);
        }
      });
    },
    addFollowup: function(){
      var jsonData = COMMON.createFormDataJson("#followup-section");
      console.log(jsonData);
      $.ajax({
        url: CONSTANTS.API_PATH + "followup/create",
        // url: apiPath + "member-api/RestController.php?page_key=create",
        method: "POST",
        data: JSON.stringify(jsonData),
        // dataType: "json",
        success: function(data, statusTxt){
          console.log(data, statusTxt);
          if(data.success === 1){
            COMMON.showModal("myModal", "Yay!", data.msg);
          } else if(data.success === 0) {
            if(data.msg === "API issue"){
              COMMON.showModal("myModal", "Sorry", data.msg + ", Code: " + data.code);
            } else {
              COMMON.showModal("myModal", "Sorry", data.msg);
            }
          }
        },
        error: function(xhr, statusTxt){
          console.log(xhr, status);
        }
      });
    },
    showPaymentHistory: function(){
      var memberId = sessionStorage.getItem('member_id');
      console.log("memberId", memberId);
      console.log("CONSTANTS", CONSTANTS);
      var url = CONSTANTS.API_PATH +"payment/list/"+memberId;
      console.log("url", url);
      $.ajax({
          url: CONSTANTS.API_PATH + "payment/list/"+memberId,
          // url: apiPath + "member-api/RestController.php?page_key=create",
          method: "GET",
          // data: JSON.stringify(data),
          dataType: "json",
          success: function(data, statusTxt){
            console.log(data, statusTxt);
            if(data.output.length > 0){
              var payments = data.output;
              var tableEl = "<table border='1'><thead><th>Payment Date</th><th>Payment Type</th><th>Amt Paid</th><th>Payment Details</th><th>Remarks</th></thead>";
              tableEl += "<tbody>";

              for(var i=0; i<payments.length; i++){
                var payment = payments[i];
                tableEl += "<tr>";
                tableEl += "<td>"+payment['payment_date']+"</td>";
                tableEl += "<td>"+payment['payment_type']+"</td>";
                tableEl += "<td>"+payment['amt_paid']+"</td>";
                tableEl += "<td>"+payment['payment_details']+"</td>";
                tableEl += "<td>"+payment['payment_remarks']+"</td>";
                tableEl += "</tr>";
              }

              tableEl += "</tbody></table>";

              $('title, h2').text('Payment History');
              $('#userId').text(payment['user_id']);
              $('#userName').text(payment['title'] + ' ' + payment['first_name'] + ' ' + payment['last_name']);
              $("#history").html(tableEl);
            }
          },
          error: function(xhr, statusTxt){
            console.log(xhr, status);
          }
      });
    },
    showGiftPrasadamHistory: function(type){
      var memberId = sessionStorage.getItem('member_id');
      console.log("memberId", memberId);
      console.log("CONSTANTS", CONSTANTS);
      var url = CONSTANTS.API_PATH + type + "/list/"+memberId;
      console.log("url", url);
      $.ajax({
          url: url,
          // url: apiPath + "member-api/RestController.php?page_key=create",
          method: "GET",
          // data: JSON.stringify(data),
          dataType: "json",
          success: function(data, statusTxt){
            console.log(data, statusTxt);
            if(data.output.length > 0){
              var gifts = data.output;
              var tableEl = "<table border='1'><thead><th>Dispatch Date</th><th>Description</th><th>Is Dispatched?</th><th>Remarks</th></thead>";
              tableEl += "<tbody>";

              for(var i=0; i<gifts.length; i++){
                var gift = gifts[i];
                tableEl += "<tr>";
                tableEl += "<td>"+gift['dispatch_date']+"</td>";
                tableEl += "<td>"+gift['description']+"</td>";
                tableEl += "<td>"+(gift['is_dispatched']==="Y"? "Yes" : "No")+"</td>";
                tableEl += "<td>"+gift['remarks']+"</td>";
                tableEl += "</tr>";
              }

              tableEl += "</tbody></table>";

              var fullName = gift['title'] + ' ' + gift['first_name'] + ' ' + gift['last_name'];
              var title = "Gift History";
              if(type === "prasadam"){
                title = "Prasadam History";
              }

              $('title, h2').text(title);
              $('#userId').text(gift['user_id']);
              $('#userName').text(fullName);
              $("#history").html(tableEl);
            }
          },
          error: function(xhr, statusTxt){
            console.log(xhr, status);
          }
      });
    },
    showBTGHistory: function(){
      var memberId = sessionStorage.getItem('member_id');
      console.log("memberId", memberId);
      console.log("CONSTANTS", CONSTANTS);
      var url = CONSTANTS.API_PATH + "btg/list/"+memberId;
      console.log("url", url);
      $.ajax({
          url: url,
          // url: apiPath + "member-api/RestController.php?page_key=create",
          method: "GET",
          // data: JSON.stringify(data),
          dataType: "json",
          success: function(data, statusTxt){
            console.log(data, statusTxt);
            if(data.output.length > 0){
              var btgs = data.output;
              var tableEl = "<table border='1'><thead><th>Dispatch Date</th><th>Description</th><th>BTG Language</th><th>Is Dispatched?</th><th>Remarks</th></thead>";
              tableEl += "<tbody>";

              for(var i=0; i<btgs.length; i++){
                var btg = btgs[i];
                tableEl += "<tr>";
                tableEl += "<td>"+btg['dispatch_date']+"</td>";
                tableEl += "<td>"+btg['description']+"</td>";
                tableEl += "<td>"+btg['btg_lang']+"</td>";
                tableEl += "<td>"+(btg['is_dispatched']==="Y"? "Yes" : "No")+"</td>";
                tableEl += "<td>"+btg['remarks']+"</td>";
                tableEl += "</tr>";
              }

              tableEl += "</tbody></table>";

              var fullName = btg['title'] + ' ' + btg['first_name'] + ' ' + btg['last_name'];
              var title = "Back To Godhead History";

              $('title, h2').text(title);
              $('#userId').text(btg['user_id']);
              $('#userName').text(fullName);
              $("#history").html(tableEl);
            }
          },
          error: function(xhr, statusTxt){
            console.log(xhr, status);
          }
      });
    },
    showFollowupHistory: function(){
      var memberId = sessionStorage.getItem('member_id');
      console.log("memberId", memberId);
      console.log("CONSTANTS", CONSTANTS);
      var url = CONSTANTS.API_PATH + "followup/list/"+memberId;
      console.log("url", url);
      $.ajax({
          url: url,
          // url: apiPath + "member-api/RestController.php?page_key=create",
          method: "GET",
          // data: JSON.stringify(data),
          dataType: "json",
          success: function(data, statusTxt){
            console.log(data, statusTxt);
            if(data.output.length > 0){
              var followups = data.output;
              var tableEl = "<table border='1'><thead><th>Followup Date</th><th>Remarks</th><th>Next Date</th></thead>";
              tableEl += "<tbody>";

              for(var i=0; i<followups.length; i++){
                var followup = followups[i];
                tableEl += "<tr>";
                tableEl += "<td>"+followup['followup_date']+"</td>";
                tableEl += "<td>"+followup['followup_remark']+"</td>";
                tableEl += "<td>"+followup['nxt_followup_date']+"</td>";
                tableEl += "</tr>";
              }

              tableEl += "</tbody></table>";

              var fullName = followup['title'] + ' ' + followup['first_name'] + ' ' + followup['last_name'];
              var title = "Back To Godhead History";

              $('title, h2').text(title);
              $('#userId').text(followup['user_id']);
              $('#userName').text(fullName);
              $("#history").html(tableEl);
            }
          },
          error: function(xhr, statusTxt){
            console.log(xhr, status);
          }
      });
    }
};
