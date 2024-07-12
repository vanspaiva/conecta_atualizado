<?php
// session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Conecta 2.0 - Portal Drs</title>
  <!--Ícone da página-->
  <link rel="shortcut icon" href="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_3aa8b67c896baaa57f51d102751de9ee.png" />
  <link href="css/reset.css" rel="stylesheet" />
  <!-- <link href="css/styles.css" rel="stylesheet" /> -->
  <link href="css/system.css" rel="stylesheet" />
  <link href="css/jquery-ui.css" rel="stylesheet" />
  <!-- Bootstrap -->
  <link rel="stylesheet" href="../src/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../src/js/bootstrap.min.js" />
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

  <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  
  <script src="https://kit.fontawesome.com/fc80289fa3.js" crossorigin="anonymous"></script>

</head>
<style>
  :root {
    --blue: #007bff;
    --indigo: #6610f2;
    --purple: #6f42c1;
    --pink: #e83e8c;
    --red: #dc3545;
    --orange: #ee7624;
    --yellow: #ffc107;
    --green: #28a745;
    --teal: #20c997;
    --cyan: #17a2b8;
    --white: #fff;
    --gray: #6c757d;
    --gray-dark: #4F4F51;
    --primary: #ee7624;
    --secondary: #6c757d;
    --success: #53b66a;
    --info: #129aaf;
    --warning: #daa300;
    --danger: #e21b2f;
    --light: #f0f0f0;
    --dark: #32363a;
    --breakpoint-xs: 0;
    --breakpoint-sm: 576px;
    --breakpoint-md: 768px;
    --breakpoint-lg: 992px;
    --breakpoint-xl: 1200px;
    --font-family-sans-serif: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    --font-family-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
  }

  .faixaLaranja {
    background-color: var(--orange);
    width: 100vw;
    height: 100px;
    margin: 0 !important;
  }

  .faixaRoxa {
    background-color: #373342;
    width: 100vw;
    height: 100px;
    margin: 0 !important;
  }

  .btn-conecta {
    color: #fff;
    background-color: var(--orange);
    border-color: var(--orange);
  }

  .btn-conecta:hover {
    color: #fff;
    background-color: orangered;
    border-color: orangered;
  }

  .btn-conecta:focus,
  .btn-conecta.focus {
    color: #fff;
    background-color: orangered;
    border-color: orangered;
    box-shadow: 0 0 0 0.2rem rgba(76, 76, 77, 0.5);
  }

  .btn-conecta.disabled,
  .btn-conecta:disabled {
    color: #fff;
    background-color: var(--secondary);
    border-color: var(--secondary);
  }

  .btn-conecta:not(:disabled):not(.disabled):active,
  .btn-conecta:not(:disabled):not(.disabled).active,
  .show>.btn-conecta.dropdown-toggle {
    color: #fff;
    background-color: var(--secondary);
    border-color: var(--secondary);
  }

  .btn-conecta:not(:disabled):not(.disabled):active:focus,
  .btn-conecta:not(:disabled):not(.disabled).active:focus,
  .show>.btn-conecta.dropdown-toggle:focus {
    box-shadow: 0 0 0 0.2rem rgba(37, 42, 48, 0.5);
  }


  .text-conecta {
    color: var(--orange) !important;
  }

  a.text-conecta:hover,
  a.text-conecta:focus {
    color: orangered !important;
  }

  .btn-outline-conecta {
    color: var(--orange);
    border-color: var(--orange);
    opacity: 0.8;
  }

  .btn-outline-conecta:hover {
    opacity: 1;
    color: var(--orange);
    background-color: var(--orange);
    border-color: var(--orange);
  }

  .btn-outline-conecta:focus,
  .btn-outline-conecta.focus {
    box-shadow: 0 0 0 0.2rem rgba(255, 115, 0, 0.5);
  }

  .btn-outline-conecta.disabled,
  .btn-outline-conecta.disabled:hover,
  .btn-outline-conecta:disabled {
    color: var(--orange);
    background-color: transparent;
  }

  .btn-outline-conecta:not(:disabled):not(.disabled):active,
  .btn-outline-conecta:not(:disabled):not(.disabled).active,
  .show>.btn-outline-conecta.dropdown-toggle {
    color: #fff;
    background-color: var(--orange);
    border-color: var(--orange);
  }

  .btn-outline-conecta:not(:disabled):not(.disabled):active:focus,
  .btn-outline-conecta:not(:disabled):not(.disabled).active:focus,
  .show>.btn-outline-conecta.dropdown-toggle:focus {
    box-shadow: 0 0 0 0.2rem rgba(255, 115, 0, 0.5);
  }
</style>