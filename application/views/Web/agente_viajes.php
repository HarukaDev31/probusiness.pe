    <?php
    include('views/agente_viajes.php');
    include('layout/footer.php');
    ?>
    <script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';
    </script>
    <script src="<?php echo base_url("assets/js/main.js?ver=10.0.0.0"); ?>"></script>
    <script>
    $(function(){
      var fToday = new Date(), fYear = fToday.getFullYear(), fMonth = fToday.getMonth() + 1, fDay = fToday.getDate();
      $('#datepicker').datepicker({
        autoclose : true,
        startDate : new Date(fYear, fToday.getMonth(), fDay),
        todayHighlight  : true,
        dateFormat: 'dd/mm/yyyy',
        format: 'dd/mm/yyyy',
      });

      if (fMonth < 10)
        fMonth = '0' + fMonth;
      $('#datepicker').datepicker().children('input').val(fDay + '/' + fMonth + '/' + fYear);
    });
    </script>
  </body>
</html>