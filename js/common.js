var COMMON = {
  initCommonVars: function(){
    var lastIdx = location.href.lastIndexOf("/");
    var projectAddr = location.href.substring(0, lastIdx);

    CONSTANTS.API_PATH = projectAddr + "/nitya-api/";
  },
  showModal: function(modalId, headerTxt, bodyHtml){
    $("#"+modalId).off("show.bs.modal").on("show.bs.modal", function(){
      $(this).find(".modal-title").text(headerTxt);
      $(this).find(".modal-body").html(bodyHtml);
    }).off("shown.bs.modal").on("shown.bs.modal", function(){
      $(this).find(".modal-header button").focus();
    }).modal("show");
  },
  disableInnerEls: function(selector){
    var elsToDisable = $(selector).find("input, textarea, select, button");
    elsToDisable.attr("disabled", "disabled");
  },
  createFormDataJson: function(parentId){
    var els = $(parentId).find("[name]");
    var jsonData = {};
    els.each(function(idx, item){
      var name = $(item).attr("name");
      jsonData[name] = $("[name="+name+"]").val();
    });

    return jsonData;
  }
};
