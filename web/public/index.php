<?php
require_once('class.php');
    try {
         /**
          * Соединяемся с базой данных @test
          */


        $dbcon = new PDO('mysql:host=mysql;dbname=test', 'dev', 'dev');

        /** 
         * Создаем объект класса @Init    
         */
    
        $sql = new Init($dbcon);


        /** 
         * Вызываем метод @get класса @Init для получения данных из таблицы @test    
         */

        $sql->get();
    } catch(PDOException $e) {
        echo 'Ошибка: ' . $e->getMessage();
    }
