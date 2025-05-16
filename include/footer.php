      <!-- /.sidebar-menu -->
      </div>
    <!-- /.sidebar -->
  </aside>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2025 <a href="https://denrr8dvts.free.nf">DENR-R8 DVTS</a>. Developed by Lander Mendigorin.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.2.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- jQuery Mapael -->
<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": false, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
<script>
// Format and store raw Net Amount
$('#net_amount').on('input', function () {
    let rawValue = $(this).val().replace(/,/g, '');
    if (!isNaN(rawValue) && rawValue !== '') {
        let parts = rawValue.split('.');
        parts[0] = Number(parts[0]).toLocaleString('en-US');
        let formatted = parts.join('.');
        $(this).val(formatted);
        $('#net_amount_raw').val(rawValue); // raw value goes to DB
    } else {
        $('#net_amount_raw').val('');
    }
});

// Format and store raw Gross Amount
$('#gross_amount').on('input', function () {
    let rawValue = $(this).val().replace(/,/g, '');
    if (!isNaN(rawValue) && rawValue !== '') {
        let parts = rawValue.split('.');
        parts[0] = Number(parts[0]).toLocaleString('en-US');
        let formatted = parts.join('.');
        $(this).val(formatted);
        $('#gross_amount_raw').val(rawValue); // raw value goes to DB
    } else {
        $('#gross_amount_raw').val('');
    }
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("#add-task-form");
    const submitBtn = form.querySelector("[type='submit']");

    form.addEventListener("submit", function () {
        setTimeout(() => {
            submitBtn.disabled = true;
            submitBtn.innerText = "Submitting...";
        }, 100);
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
  const transactionSelect = document.getElementById("transaction_id");
  const procurementFields = document.getElementById("procurementFields");

  // Make sure this triggers when using selectpicker
  transactionSelect.addEventListener("change", function () {
    const selectedValue = this.value;

    if (selectedValue === "4" || selectedValue === "6") {
      procurementFields.style.display = "block";
    } else {
      procurementFields.style.display = "none";
      document.getElementById("pr_no").value = "";
      document.getElementById("po_no").value = "";
    }
  });
});
</script>
</body>
</html>