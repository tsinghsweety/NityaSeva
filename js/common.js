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
    }).modal("show");
  },
  disableInnerEls: function(selector){
    var elsToDisable = $(selector).find("input, textarea, select, button");
    elsToDisable.attr("disabled", "disabled");
  }
};
