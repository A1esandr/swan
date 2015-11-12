<?php

// Создание таблицы для каталога

require_once ('MysqliDb.php');
require_once ('config.php');

$db = new MysqliDb (DB_SERVER, DB_USER, DB_PASS, DB_NAME);

$users = $db->rawQuery(
"CREATE TABLE
    `books` (
    	`id` INT(8) NOT NULL AUTO_INCREMENT,
        `name` CHAR(255) NOT NULL,
        `genre` CHAR(150) NOT NULL,
        `author` CHAR(255) NOT NULL,
        `year` INT(4) NOT NULL,
        PRIMARY KEY(`id`)
    )
COLLATE utf8_general_ci");

echo 'Таблица для каталога создана<br>';

$data = Array ("name" => "Турецкий гамбит",
                 "genre" => "детектив",
                 "author" => "Акунин Б.",
                 "year" => "2002"
  );
  $id = $db->insert ('books', $data);
  if($id)
    echo 'book\'s sign was created. Id=' . $id.'<br>';

$data = Array ("name" => "Дюна",
                 "genre" => "фантастика",
                 "author" => "Герберт Ф.",
                 "year" => "1965"
  );
  $id = $db->insert ('books', $data);
  if($id)
    echo 'book\'s sign was created. Id=' . $id.'<br>';

$data = Array ("name" => "Гамлет",
                 "genre" => "драма",
                 "author" => "Шекспир В.",
                 "year" => "1601"
  );
  $id = $db->insert ('books', $data);
  if($id)
    echo 'book\'s sign was created. Id=' . $id.'<br>';

$data = Array ("name" => "Война и мир",
                 "genre" => "драма",
                 "author" => "Толстой Л.",
                 "year" => "1869"
  );
  $id = $db->insert ('books', $data);
  if($id)
    echo 'book\'s sign was created. Id=' . $id.'<br>';

$data = Array ("name" => "Мертвые души",
                 "genre" => "драма",
                 "author" => "Гоголь Н.",
                 "year" => "1847"
  );
  $id = $db->insert ('books', $data);
  if($id)
    echo 'book\'s sign was created. Id=' . $id.'<br>';

echo 'Таблица наполнена демо-данными';
?>
