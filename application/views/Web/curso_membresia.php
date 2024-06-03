    <?php
    include('views/curso_membresia.php');
    include('layout/footer.php');
    ?>
    <script src="<?php echo base_url("assets/js/main.js?ver=13.0.0"); ?>"></script>
    
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput-jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript">var base_url = '<?php echo base_url(); ?>';</script>
    <script src="<?php echo base_url("assets/js/inicio_curso_registro.js?ver=18.0.0"); ?>"></script>
    <script>
    $(function(){
      var fToday = new Date(), fYear = '1930', fMonth = fToday.getMonth() + 1, fDay = fToday.getDate();
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