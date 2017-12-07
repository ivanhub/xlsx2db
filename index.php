<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body style="margin-top:15%;">
<form enctype="multipart/form-data" action="upload.php" method="POST" style="text-align:center">
    <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
    <!-- Название элемента input определяет имя в массиве $_FILES -->
    Загрузить реестр сертификатов в Базу Данных: <input name="userfile" type="file" />
    <input type="submit" value="Загрузить" />
</form>
</body>
</html>