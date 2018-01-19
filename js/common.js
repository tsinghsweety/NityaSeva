var COMMON = {
  showModal: function(modalId, headerTxt, bodyHtml){
    $("#"+modalId).off("show.bs.modal").on("show.bs.modal", function(){
      $(this).find(".modal-title").text(headerTxt);
      $(this).find(".modal-body").html(bodyHtml);
    }).modal("show");
  }
};
