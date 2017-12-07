<?php
//@mkdir("uploads", 0777);


ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

/*LOADING FILE */
$uploaddir = './uploads/';
//global $uploadfile;
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

//if (copy($_FILES['userfile']['tmp_name'], $uploadfile))
//var_dump(is_uploaded_file($_FILES["userfile"]["tmp_name"]));
if(is_uploaded_file($_FILES["userfile"]["tmp_name"]))
   {

echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "Файл корректен и был успешно загружен.\n";
} else {
    echo "Возможная атака с помощью файловой загрузки!\n";
}

// Выводим информацию о загруженном файле:
echo "<h3>Информация о загруженном на сервер файле: </h3>";
echo "<p><b>Оригинальное имя загруженного файла: ".$_FILES['userfile']['name']."</b></p>";
echo "<p><b>Mime-тип загруженного файла: ".$_FILES['userfile']['type']."</b></p>";
echo "<p><b>Размер загруженного файла в байтах: ".$_FILES['userfile']['size']."</b></p>";
echo "<p><b>Временное имя файла: ".$_FILES['userfile']['tmp_name']."</b></p>";
echo "\nНекоторая отладочная информация:";
///Либо просто: print_r($_FILES);

print "</pre>";
}

/* ОБРАБАТЫВАЕМ ФАЙЛ*/
 include('./add2reestr.php');
?>