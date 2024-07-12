<?php 

$thisYear = date("Y");

include("systemVersion.php");
$thisVersion = systemVersion();
?>
<footer class="footer mt-5 py-3 bg-light-gray2 font-montserrat">
    <div class="container">
        <p class="text-conecta small text-center">&copy; Conecta 2021 - <?php echo $thisYear;?></p>
        <p class="text-conecta small text-center"> Versão <?php echo $thisVersion;?></p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="js/standart.js"></script>

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/datatables-demo.js"></script>
</body>

</html>