    <?php
    include('views/curso_membresia.php');
    include('layout/footer.php');
    ?>
    <?php
    if (!empty($deferIzipayKryptonToFooter) && isset($client)) {
        $izEp = $client->getClientEndpoint();
        $izPk = $client->getPublicKey();
        $izOk = base_url() . 'Curso/respuestaIzipay';
    ?>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($izEp, ENT_QUOTES, 'UTF-8'); ?>/static/js/krypton-client/V4.0/ext/classic-reset.css">
    <script
      src="<?php echo htmlspecialchars($izEp, ENT_QUOTES, 'UTF-8'); ?>/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js"
      kr-public-key="<?php echo htmlspecialchars($izPk, ENT_QUOTES, 'UTF-8'); ?>"
      kr-post-url-success="<?php echo htmlspecialchars($izOk, ENT_QUOTES, 'UTF-8'); ?>"></script>
    <script src="<?php echo htmlspecialchars($izEp, ENT_QUOTES, 'UTF-8'); ?>/static/js/krypton-client/V4.0/ext/classic.js"></script>
    <?php } ?>
    <script src="<?php echo base_url("assets/js/main.js?ver=19.0.0"); ?>"></script>
    
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput-jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript">
      var base_url = '<?php echo base_url(); ?>';
      var ubicacion_api_base = '<?php echo isset($sApiUbicacionBase) ? htmlspecialchars($sApiUbicacionBase, ENT_QUOTES, "UTF-8") : ""; ?>';
    </script>
    <script src="<?php echo base_url("assets/js/inicio_curso_registro.js?ver=37.0.0"); ?>"></script>
    <script>
    /* Planes membresía: fetch al API Laravel (URL en data-planes-api-url del #planes-membresia-root) */
    (function () {
      function escHtml(s) {
        if (s == null) return '';
        var d = document.createElement('div');
        d.textContent = String(s);
        return d.innerHTML;
      }
      function safeClass(s) {
        if (!s) return '';
        return String(s).replace(/["<>]/g, '');
      }
      function loadPlanesMembresia() {
        var root = document.getElementById('planes-membresia-root');
        if (!root) return;
        var apiUrl = root.getAttribute('data-planes-api-url');
        if (!apiUrl) return;

        fetch(apiUrl, { credentials: 'omit', headers: { 'Accept': 'application/json' } })
          .then(function (r) {
            if (!r.ok) throw new Error('HTTP ' + r.status);
            return r.json();
          })
          .then(function (data) {
            var planes = (data && data.planes) ? data.planes : [];
            var html = '';
            if (!planes.length) {
              root.innerHTML = '<div class="col-12 px-2 mb-3"><p class="text-center text-muted mb-0">No hay planes disponibles.</p></div>';
              return;
            }
            window.__planesData = {};
            planes.forEach(function (plan) {
              var cardClass = safeClass(plan.card_css_classes) || 'bg-light c-plam col-12';
              var btnClass = safeClass(plan.button_css_classes) || 'border-0 py-3 text-center d-block fw-bold hover-naranja text-decoration-none small2 bg-dark text-white w-100 mt-3 rounded-3';
              var subt = plan.subtitle
                ? '<span class="t-plam t-1 text-dark">' + escHtml(plan.subtitle) + '</span>'
                : '';
              var priceRow = '<div class="m1 t-3 d-flex">';
              var precioTachado = plan.price_original == null ? '' : String(plan.price_original).trim();
              if (precioTachado !== '') {
                priceRow += '<span class="text-decoration-line-through text-secondary fs-6 my-auto">' + escHtml(precioTachado) + '</span>';
              }
              priceRow += '<span class="t-plam ' + (precioTachado !== '' ? 'ms-2' : '') + ' my-auto">' + escHtml(plan.price_current) + '</span></div>';
              var benefits = '';
              (plan.benefits || []).forEach(function (b) {
                benefits += '<span class="t-plaml"><i class="bi bi-check2 plami"></i> ' + escHtml(b) + '</span>';
              });
              var tp = parseInt(plan.tipo_pago, 10);
              if (isNaN(tp) || tp < 1) tp = 1;
              window.__planesData[tp] = {
                title: plan.title || '',
                price_current: plan.price_current || '',
                price_amount: plan.price_amount || null
              };
              var btnLabel = plan.button_label ? escHtml(plan.button_label) : 'Ir a pagar';
              html += '<div class="col-md-4 col-12 px-2 mb-3">' +
                '<div class="' + cardClass + '">' +
                '<div class="d-flex justify-content-between">' +
                '<span class="t-plam t-2 fs-4 text-dark fw-bold">' + escHtml(plan.title) + '</span></div>' +
                subt + priceRow +
                '<span class="t-plam fs-6 fw-bold text-dark">Beneficios</span>' +
                '<div class="d-flex flex-column">' + benefits + '</div>' +
                '<button type="button" onclick="pagar(' + tp + ');" class="' + btnClass + '">' + btnLabel + '</button>' +
                '</div></div>';
            });
            root.innerHTML = html;
          })
          .catch(function () {
            root.innerHTML = '<div class="col-12 px-2 mb-3"><p class="text-center text-danger mb-0">No se pudieron cargar los planes (CORS, URL o red). Revisa la consola y <code>integraciones.php</code>.</p></div>';
          });
      }
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', loadPlanesMembresia);
      } else {
        loadPlanesMembresia();
      }
    })();
    </script>
    <script>
    $(function(){
      var fToday = new Date();
      fToday.setHours(23, 59, 59, 999); /* endDate incluye el día de hoy */
      var fMonth = fToday.getMonth() + 1;
      var fDay = fToday.getDate();
      if (fMonth < 10)
        fMonth = '0' + fMonth;
      /* Una sola inicialización (evita que el segundo .datepicker() pierda opciones) */
      $('#datepicker').datepicker({
        autoclose : true,
        /* Nacimiento: desde 1930 hasta hoy (no fechas futuras → evita edad vacía / negativa) */
        startDate : new Date(1930, 0, 1),
        endDate : fToday,
        todayHighlight  : true,
        dateFormat: 'dd/mm/yyyy',
        format: 'dd/mm/yyyy',
      }).children('input').val(fDay + '/' + fMonth + '/' + fToday.getFullYear());
      if (typeof window.cursoSincronizarEdadDesdeFechaNacimiento === 'function') {
        window.cursoSincronizarEdadDesdeFechaNacimiento();
      }
    });
    </script>
  </body>
</html>