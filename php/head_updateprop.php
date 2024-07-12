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

  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    
    <script src="https://kit.fontawesome.com/fc80289fa3.js" crossorigin="anonymous"></script>

</head>
<style>
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