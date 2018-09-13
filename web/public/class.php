<?php
/**
* Название класса
* 
* Полное описание
* 
* @author muratshin.sv <s_admin@mail.ru>
* @version 1.0
*/

final class Init {
  /**
   * Класс @Init без возможности наследования от него 
   */

private $pdo;

/**
   * Конструктор класса 
   * Удаляем ранее созданную таблицу
   * Выполняем метод @create для создание таблицы
   * Выполняем метод @fill для заполнения случайными данными
   */

  public function __construct($pdo)

{
  $this->pdo = $pdo;
  $this->pdo->exec("DROP TABLE `test`");
  $this->create();
  $this->fill();
}   

/**
   * Метод @create создаем таблицу @test
   * Доступен только для методов класса @Init
   */

  private function create()

  {
  $commands = "CREATE TABLE IF NOT EXISTS `test` (
                `id` int NOT NULL AUTO_INCREMENT,
                `script_name` varchar(25) NOT NULL,
                `start_time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `sort_index` int(3) ,
                `result` SET('normal','illegal','failed','success'),
                PRIMARY KEY (`id`)
                ) Engine=InnoDB DEFAULT CHARSET=utf8";

              $this->pdo->exec($commands);
  echo "Таблица test создана"."<br />\n";

  }
  /**
   * Метод @fill заполняет таблицу @test случайными данными
   * Доступен только для методов класса @Init
   */

  private function fill()

  {
   $result = ["normal","illegal","failed","success"];
    $stmt = $this->pdo->prepare( "INSERT INTO test(script_name, sort_index, result) 
                                          values (?, ?, ?) ");
    for ($i = 0;$i < 10;$i++) 
    {
    $stmt->execute(["name$i", rand(1,1000), $result[rand(0,3)]]);
    }
  

  echo "Таблица test запонена"."<br />\n";

  }

  /**
   * Метод @get доступен из вне класса
   * Делаем выборку данных из таблицы @test по критерию @result среди @normal @success
   */

  public function get()

  {

    $data = $this->pdo->query("SELECT * FROM test WHERE result IN ('normal','success')")->fetchAll();
    //print_r($data);
    foreach ($data as $row) 
    {
        echo $row['id']." ".$row['script_name']." ".$row['start_time']." ".$row['sort_index']." ".$row['result']."<br />\n";
    }
   }

}