<?php 
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

require_once ('MysqliDb.php');
require_once ('config.php');


//Инициализация класса для работы с БД
$db = new MysqliDb (DB_SERVER, DB_USER, DB_PASS, DB_NAME);

// ФУНКЦИИ

// Функция для отображения всего списка книг
function displayAll(){
	global $db;
  $books = $db->get('books');
  
    if ($db->count > 0){
	  	echo '<table class="table"><tr><th>Название</th><th>Автор</th><th>Жанр</th><th>Год</th><th></th><th></th></tr>';
	    foreach ($books as $book) { 
	    	echo '<tr id="'.$book['id'].'"><td class="name">'.$book['name'].'</td><td class="author">'.$book['author'].'</td><td class="genre">'.$book['genre'].'</td><td class="year">'.$book['year'].'</td><td class="edit btn btn-success">Редактировать</td><td class="del btn btn-danger">Удалить</td></tr>';
	    }
	    echo '</table>';
	} else {
		echo '<h3 class="text-center">В каталоге нет книг</h3>';
	}
  
}

// Функция для удаления книги
function deleteBook($id){
	global $db;
	$db->where('id', $id);
	if($db->delete('books')) echo 'Удалено';
}

// Функция для редактирования книги
function editBook($id,$name,$author,$genre,$year){
	global $db;
	$data = Array (
	    'name' => $name,
	    'author' => $author,
	    'genre' => $genre,
	    'year' => $year
	);
	$db->where ('id', $id);
	if ($db->update ('books', $data))
	    echo $db->count . ' записей было обновлено';
	else
	    echo 'Обновление не удалось: ' . $db->getLastError();
}

// Функция для добавления книги
function addBook($name,$author,$genre,$year){
	global $db;
	$data = Array (
	    'name' => $name,
	    'author' => $author,
	    'genre' => $genre,
	    'year' => $year
	);
	$id = $db->insert ('books', $data);
	if($id)
	    echo 'Книга была добавлена';
}



//Чтение действия из ajax-запроса
$action = html_entity_decode(strip_tags($_POST['action']));

//Выполнение действий
if($action == 'show'){
	displayAll();
}
if($action == 'delete'){
	$id = html_entity_decode(strip_tags($_POST['id']));
	deleteBook($id);
}

if($action == 'edit'){
	$id = html_entity_decode(strip_tags($_POST['id']));
	$name = html_entity_decode(strip_tags($_POST['name']));
	$author = html_entity_decode(strip_tags($_POST['author']));
	$genre = html_entity_decode(strip_tags($_POST['genre']));
	$year = html_entity_decode(strip_tags($_POST['year']));
	editBook($id,$name,$author,$genre,$year);
}

if($action == 'add'){
	$name = html_entity_decode(strip_tags($_POST['name']));
	$author = html_entity_decode(strip_tags($_POST['author']));
	$genre = html_entity_decode(strip_tags($_POST['genre']));
	$year = html_entity_decode(strip_tags($_POST['year']));
	addBook($name,$author,$genre,$year);
}
?>
