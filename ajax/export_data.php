<?php

// Скрипт для экспорта данных в csv файл.


// Подключение к базе данных MySQL
include '../db/db_connection.php';

// Получение данных из базы
$sql = "SELECT * FROM user";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Создание временного CSV-файла
$csvFileName = tempnam(sys_get_temp_dir(), 'exported_data_');
$csvFile = fopen($csvFileName, 'w');

// Наименования столбцов
$columnNames = array_keys($data[0]);
fputcsv($csvFile, $columnNames);

// Запись данных в CSV-файл
foreach ($data as $row) {
    fputcsv($csvFile, $row);
}

fclose($csvFile);

// Отправка файла обратно на клиент
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="exported_data.csv"');
readfile($csvFileName);

// Удаление временного файла
unlink($csvFileName);

$conn->close();
?>