<?php

require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'get'){
    $sql = $pdo->query("SELECT * FROM tabela_pacientes");
    if($sql->rowConut() > 0){
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach($data as $item){
            $array['result'][] = ['id' => $item['id'],
            'titulo' => $item['title'],
            'idade' => $item['idade']
        ];
        }

    }
} else{
    $array['error'] = 'Método não encontrado';
}

require('../return.php');