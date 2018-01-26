var SEARCH = {
  init: function() {
    var searchObj = [
      {name: "Donation Category", value:"donation_category", subCatType: "select", subCatValues: ["Prabhupada Sevak", "Jagannath Sevak", "Govind Sevak"]},
      {name: "Active Member", value:"active_member", subCatType: "select", subCatValues: ["Y", "N"]},
      {name: "Payment Due", value:"payment_due", subCatType: "select", subCatValues: ["Y", "N"]},
      {name: "Current Payment Done", value:"current_payment_done", subCatType: "select", subCatValues: ["Y", "N"]},
      {name: "Corresponder", value:"corresponder", subCatType: "select", url: "member/corresponderlist"},
      {name: "Connected To", value:"connected_to", subCatType: "select", url: "member/connectedlist"}
    ];
  }
};
