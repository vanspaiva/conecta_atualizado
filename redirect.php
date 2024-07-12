<?php

$id = addslashes($_GET['id']);
echo $id;

header("Location: update-proposta?id=" . $id);