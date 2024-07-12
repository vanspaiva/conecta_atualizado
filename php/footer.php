<?php

$thisYear = date("Y");

include("systemVersion.php");
$thisVersion = systemVersion();
?>
<footer class="footer mt-5 py-3 bg-light-gray2 font-montserrat">
    <div class="container">
        <p class="text-conecta small text-center">&copy; Conecta 2021 - <?php echo $thisYear; ?></p>
        <p class="text-conecta small text-center"> Versão <?php echo $thisVersion; ?></p>
    </div>
</footer>


<!-- jQuery e Bootstrap Bundle -->
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous" defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<!-- DataTables e FixedColumns -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous" defer></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous" defer></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js" crossorigin="anonymous" defer></script>

<!-- Outros scripts -->
<script src="js/scripts.js" defer></script>
<script src="js/standart.js" defer></script>


<!-- DataTables Demo -->
<script src="assets/demo/datatables-demo.js" defer></script>

</body>

</html>