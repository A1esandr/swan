<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Swan</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="js/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
  </head>
<body>
<div class="container">  
  <div class="row">  
    <div class="col-lg-12">  
      <h1 class="text-center">Каталог книг</h1>
      <button id="showAll" class="btn btn-primary">Показать список всех книг</button>
      <button id="add" class="btn btn-warning">Добавить книгу</button>
      <div id="table">
        
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){

//Функция для отображения списка и привязки триггеров действий
  $('#showAll').click(function(){

    //Запрос на получение списка записей
    var request = $.ajax({
      url: "actions.php",
      method: "POST",
      data: {action:"show"}
    }).done(function( msg ) {
      //Очистка контейнера и вставка списка
        $('#table').empty().append(msg);

        //Привязка события удаления записи
        $('.del').click(function(){

          var bookId = $(this).parent().attr('id');

          //Запрос на удаление записи
          var request = $.ajax({
            url: "actions.php",
            method: "POST",
            data: {action:"delete",id:bookId}
          }).done(function( msg ) {
            //alert(msg);
          });

          //Удаление записи со страницы
          $(this).parent().remove();

          //Если удалена последняя запись - отображение отсутствия записей
          var number = $('tr').length;
          if(number == 1){
            $('#table').empty().append('<h3 class="text-center">В каталоге нет книг</h3>');
          }

        });

        //Привязка события редактирования записи
        $('.edit').click(function(){

          //Сбор данных со страницы для вставки в форму
          var bookId = $(this).parent().attr('id');
          var bookName = $(this).parent().find('.name').text();
          var bookAuthor = $(this).parent().find('.author').text();
          var bookGenre = $(this).parent().find('.genre').text();
          var bookYear = $(this).parent().find('.year').text();

          //Вставка данных в форму
          $('#Modal .modal-title').text('Редактировать запись');
          $('#Modal').modal('toggle');
          $('#bookName').val(bookName);
          $('#bookAuthor').val(bookAuthor);
          $('#bookGenre').val(bookGenre);
          $('#bookYear').val(bookYear);
          $('#bookId').val(bookId);

          //Сохранение изменений
          $('#save').click(function(){

            //Сбор данных из формы
            var bookName = $('#bookName').val();
            var bookAuthor = $('#bookAuthor').val();
            var bookGenre = $('#bookGenre').val();
            var bookYear = $('#bookYear').val();
            var bookId = $('#bookId').val();

            //Запрос на редактирование записи в БД
            var request = $.ajax({
              url: "actions.php",
              method: "POST",
              data: {action:"edit",id:bookId,name:bookName,author:bookAuthor,genre:bookGenre,year:bookYear}
            }).done(function( msg ) {
              alert(msg);
            });

            //Редактирование записи на странице
            $("#"+bookId+" .name").text(bookName);
            $("#"+bookId+" .author").text(bookAuthor);
            $("#"+bookId+" .genre").text(bookGenre);
            $("#"+bookId+" .year").text(bookYear);

            //Сокрытие формы
            $('#Modal').modal('hide');
          });

          //Очистка формы при закрытии
          $('#Modal').on('hidden.bs.modal', function (e) {
            $('input').val('');
          });
        });
    });
  });

  //Добавление записи
  $('#add').click(function(){

    $('#Modal .modal-title').text('Добавить запись');
    $('#Modal').modal('toggle');

    //Сохранение данных из формы
    $('#save').click(function(){

      //Сбор данных из формы
      var bookName = $('#bookName').val();
      var bookAuthor = $('#bookAuthor').val();
      var bookGenre = $('#bookGenre').val();
      var bookYear = $('#bookYear').val();

      //Запрос на добавление записи в БД
      var request = $.ajax({
        url: "actions.php",
        method: "POST",
        data: {action:"add",name:bookName,author:bookAuthor,genre:bookGenre,year:bookYear}
      }).done(function( msg ) {
        alert(msg);
      });

      //Сокрытие формы
      $('#Modal').modal('hide');

      //Запуск отображения списка заново
      $( "#showAll" ).trigger( "click" );

    });

    //Очистка формы при закрытии
    $('#Modal').on('hidden.bs.modal', function (e) {
      $('input').val('');
    });
  });

});
</script>

<div class="modal fade" id="Modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Название книги</label>
          <input id="bookName" class="form-control">
        </div>
        <div class="form-group">
          <label>Автор</label>
          <input id="bookAuthor" class="form-control">
        </div>
        <div class="form-group">
          <label>Жанр</label>
          <input id="bookGenre" class="form-control">
        </div>
        <div class="form-group">
          <label>Год</label>
          <input id="bookYear" class="form-control">
        </div>
        <input id="bookId" type="hidden">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
        <button type="button" class="btn btn-primary" id="save">Сохранить</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</body>
</html>
