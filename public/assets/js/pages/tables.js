 $(document).ready(function() {
     var conf = {
         responsive : true,
         "processing": true,
         "pageLength" : "25"
     };
     conf.language = {
         url: PUBLIC_REL + "/assets/vendors/datatables/i18n/" + LOCALE + ".json"
     };

     var table = $('#table').DataTable(conf);
     table.on( 'draw', function () {
         $('.livicon').each(function(){
             $(this).updateLivicon();
         });
     });
});