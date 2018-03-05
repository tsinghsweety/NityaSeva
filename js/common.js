var COMMON = {
  initCommonVars: function(){
    var lastIdx = location.href.lastIndexOf("/");
    var projectAddr = location.href.substring(0, lastIdx);

    CONSTANTS.API_PATH = projectAddr + "/nitya-api/";
  },
  showModal: function(modalId, headerTxt, bodyHtml, resetSelector, disableFlag){
    $("#"+modalId).off("show.bs.modal").on("show.bs.modal", function(){
      $(this).find(".modal-title").text(headerTxt);
      $(this).find(".modal-body").html(bodyHtml);
    }).off("shown.bs.modal").on("shown.bs.modal", function(){
      $(this).find(".modal-header button").focus();
    }).off("hidden.bs.modal").on("hidden.bs.modal", function(){
      if(resetSelector){
        if(disableFlag){
          COMMON.disableInnerEls(resetSelector);
        } else {
          COMMON.resetInnerEls(resetSelector);
        }
      }
    }).modal("show");
  },
  disableInnerEls: function(selector){
    var elsToDisable = $(selector).find("input, textarea, select, button");
    elsToDisable.attr("disabled", "disabled");
  },
  resetInnerEls: function(selector){
    var toReset = $(selector).find("input, textarea, select");
    toReset.removeAttr("disabled").val("");
  },
  createFormDataJson: function(parentId){
    var els = $(parentId).find("[name]");
    var jsonData = {};
    els.each(function(idx, item){
      var name = $(item).attr("name");
      jsonData[name] = $(item).val();
    });

    return jsonData;
  },
  logoutRedirect: function(xhr){
    var resp = xhr.responseJSON;
    if(xhr.status === 403 && resp.success === 0 && resp.status === "Access Denied" && resp.msg === "user not logged in"){
      location.href = "logout.php";
    }
  },
  accessDeniedRedirect: function(xhr){
    var resp = xhr.responseJSON;
    if(xhr.status === 403 && resp.success === 0 && resp.status === "Access Denied" && resp.msg === "secure content"){
      location.href = "access-denied.html";
    }
  },
  checkUserLoggedin: function(){
    $.ajax({
      url: CONSTANTS.API_PATH + "login/check/loggedin",
      method: "GET",
      dataType: "json",
      success: function(data, statusTxt){
        console.log(data, statusTxt);
      },
      error: function(xhr, status){
        console.log(xhr, status);
        COMMON.logoutRedirect(xhr);
      }
    });
  },
  checkSuperAdmin: function(){
    $.ajax({
      url: CONSTANTS.API_PATH + "login/check/superadmin",
      method: "GET",
      dataType: "json",
      success: function(data, statusTxt){
        console.log(data, statusTxt);
      },
      error: function(xhr, status){
        console.log(xhr, status);
        COMMON.accessDeniedRedirect(xhr);
        COMMON.logoutRedirect(xhr);
      }
    });
  }
};
