$(document).ready(function() {
  // Set default options for all DataTables
  $.extend(true, $.fn.dataTable.defaults, {
      language: {
       url: "/lte/dist/yajra/id.json"
      }
  });
});
