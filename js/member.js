var MEMBER = {
    addMember: function(){
        var title = $("[name=title]").val();
        var first_name = $("[name=first_name]").val();
        var last_name = $("[name=last_name]").val();
        var address = $("[name=address]").val();
        var phone_no = $("[name=phone_no]").val();
        var whatsapp = $("[name=whatsapp]").val();
        var email_id = $("[name=email_id]").val();
        var start_date = $("[name=start_date]").val();
        var is_active = $("[name=is_active]").val();
        var connected_to = $("[name=connected_to]").val();
        var scheme_name = $("[name=scheme_name]").val();
        var payment_type = $("[name=payment_type]").val();
        var corresponder = $("[name=corresponder]").val();
        var user_lang = $("[name=user_lang]").val();
        var remarks = $("[name=remarks]").val();

        // alert("hi");

        var data = {
            title: title,
            first_name: first_name,
            last_name: last_name,
            address: address,
            phone_no: phone_no,
            whatsapp: whatsapp,
            email_id: email_id,
            start_date: start_date,
            is_active: is_active,
            connected_to: connected_to,
            scheme_name: scheme_name,
            payment_type: payment_type,
            corresponder: corresponder,
            user_lang: user_lang,
            remarks: remarks
        };

        var serverAddr = location.origin;
        var apiPath = serverAddr + "/NityaSeva/nitya-api/";
        console.log(apiPath);

        $.ajax({
            url: apiPath + "member-api/member/create",
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
    }
};
