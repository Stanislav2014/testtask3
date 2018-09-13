<?php
$dbcon = new PDO('mysql:host=mysql;dbname=test;charset=utf8', 'dev', 'dev');
$dbcon->exec("DROP TABLE `book_autor`, `books`, `autors`");

$commands = array('CREATE TABLE `books`
( 
    `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT ,
    `book_name` varchar(32) NOT NULL
)Engine=InnoDB DEFAULT CHARSET=utf8'
,
'CREATE TABLE `autors`
( 
    `id` integer NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `autor_name` varchar(32) NOT NULL
)Engine=InnoDB DEFAULT CHARSET=utf8'
,
'CREATE TABLE book_autor
(   
    book_id integer NOT NULL,
    autor_id integer NOT NULL,
       FOREIGN KEY (book_id) REFERENCES books(id),
       FOREIGN KEY (autor_id) REFERENCES autors(id)
)Engine=InnoDB DEFAULT CHARSET=utf8'
);

foreach($commands as $command)
  {
    $dbcon->exec($command);
}

$autors= ["Иванов","Петров","Муров","Емелин","Бармалеев","Желов","Мармин","Кудактаев","Миллионов","Мамедов"];
$books= ["Рецепты","Введение в профессию PHP","СУБД от и до","Программируй всегда и везде","Си тебе по силам",
"Жизнь","Заметки программиста","Куда идти и что делать?","Миллион мне по силам","Вот и все"];


  $stmt = $dbcon->prepare( "INSERT INTO `books`(book_name) values (?) ");
   for ($i =0; $i < 10;$i++)
    {
        $stmt->execute(["$books[$i]"]);
    }
    $stmt = $dbcon->prepare( "INSERT INTO `autors`(autor_name) values (?) ");
   for ($i =0; $i < 10;$i++)
    {
        $stmt->execute(["$autors[$i]"]);
    }
    $stmt = $dbcon->prepare( "INSERT INTO `book_autor`(book_id,autor_id) values (?,?) ");
   for ($i =0; $i < 20;$i++)
    {
        $stmt->execute([rand(1,10),rand(1,10)]);    
    }

    $result = $dbcon->query("SELECT b.book_name, count(b.id) as cnt 
    FROM books as b,book_autor as ab 
    WHERE b.id=ab.book_id GROUP BY b.id HAVING cnt>2");
    
    foreach($result as $row) {
        echo $row['book_name']."  "."написана"."  ".$row['cnt']."  "."авторами <br />\n";
    }
