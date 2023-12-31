<?php

require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if ($method === 'get') {
  $sql = $pdo->query("SELECT * FROM notes");

  if ($sql->rowCount() > 0) {
    $data = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $item) {
      $array['result'][] = [
        'id' => $item['id'],
        'titulo' => $item['titulo'],
        'idade' => $item['idade']
      ];
    }
  }
} else {
  $array['error'] = 'Unauthorized Method';
}

require('../return.php');