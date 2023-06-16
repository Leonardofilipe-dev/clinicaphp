<?php

require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if ($method === 'put') {
  $input = file_get_contents('php://input');
  $data = json_decode($input, true);

  $id = $data['id'] ?? null;
  $titulo = $data['titulo'] ?? null;
  $idade = $data['idade'] ?? null;
  $body = $data['body'] ?? null;

  $id = filter_var($id, FILTER_VALIDATE_INT);
  $titulo = filter_var($titulo, FILTER_SANITIZE_SPECIAL_CHARS);
  $idade = filter_var($idade, FILTER_VALIDATE_INT);
  $body = filter_var($body, FILTER_SANITIZE_SPECIAL_CHARS);

  if ($id && $titulo && $idade !== false && $body) {
    $sql = $pdo->prepare("SELECT * FROM notes WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();

    if ($sql->rowCount() > 0) {
      $sql = $pdo->prepare("UPDATE notes SET titulo = :titulo, body = :body, idade = :idade WHERE id = :id");
      $sql->bindValue(':titulo', $titulo);
      $sql->bindValue(':body', $body);
      $sql->bindValue(':idade', $idade);
      $sql->bindValue(':id', $id);
      $sql->execute();

      $array['result'] = [
        'id' => $id,
        'titulo' => $titulo,
        'body' => $body,
        'idade' => $idade
      ];
    } else {
      $array['error'] = 'ID não encontrado';
    }
  } else {
    $array['error'] = 'ID, título ou corpo não definidos corretamente';
  }
} else {
  $array['error'] = 'Método não autorizado';
}

require('../return.php');
