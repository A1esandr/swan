<?php

// Тестовое наполнение каталога

require_once ('MysqliDb.php');
require_once ('config.php');

$db = new MysqliDb (DB_SERVER, DB_USER, DB_PASS, DB_NAME);



$data = Array ("name" => "Турецкий гамбит",
                 "genre" => "детектив",
                 "author" => "Борис Акунин",
                 "year" => "2002"
  );
  $id = $db->insert ('books', $data);
  if($id)
    echo 'book\'s sign was created. Id=' . $id.'<br>';

$data = Array ("name" => "Дюна",
                 "genre" => "фантастика",
                 "author" => "Неизвестный",
                 "year" => "1977"
  );
  $id = $db->insert ('books', $data);
  if($id)
    echo 'book\'s sign was created. Id=' . $id.'<br>';

$data = Array ("name" => "Гамлет",
                 "genre" => "драма",
                 "author" => "Вильям Шекспир",
                 "year" => "1522"
  );
  $id = $db->insert ('books', $data);
  if($id)
    echo 'book\'s sign was created. Id=' . $id.'<br>';

echo 'ok';

?>
