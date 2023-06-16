<?php

require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if ($method === 'post') {

  $titulo = filter_input(INPUT_POST, 'titulo', FILTER_DEFAULT);
  $body = filter_input(INPUT_POST, 'body', FILTER_DEFAULT);

  if ($titulo && $body) {
    $sql = $pdo->prepare("INSERT INTO notes (titulo, body) VALUES (:titulo, :body)");
    $sql->bindValue(':titulo', $titulo);
    $sql->bindValue(':body', $body);
    $sql->execute();

    $id = $pdo->lastInsertId();

    $array['result'] = [
      'id' => $id,
      'titulo' => $titulo,
      'body' => $body
    ];
  } else {
    $array['error'] = 'Undefined titulo or body';
  }
} else {
  $array['error'] = 'Unauthorized Method';
}

require('../return.php');
