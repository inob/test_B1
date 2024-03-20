<?php


// Скрипт для добавления новых записей в таблицу


// Подключение к базе данных MySQL
include '../db/db_connection.php';

// Чтение содержимого файлов CSV
$file1 = $_FILES['csvFile']['tmp_name']; // Путь к первому загруженному файлу
$file2 = '../data/import_department.csv'; // Путь ко второму файлу

$data1 = [];
if (($handle = fopen($file1, "r")) !== false) {
    $headerSkipped = false;
    while (($row = fgetcsv($handle, 0, ",")) !== false) {
        if (!$headerSkipped) {
            $headerSkipped = true;
            continue; // Пропустить первую строку с заголовками
        }
        $data1[] = $row;
    }
    fclose($handle);
}
$data2 = [];
if (($handle = fopen($file2, "r")) !== false) {
    while (($row = fgetcsv($handle, 0, ";")) !== false) {
        $data2[] = $row;
    }
    fclose($handle);
}

// Создание таблицы, если она не существует
$sql = "CREATE TABLE IF NOT EXISTS user (
  XML_ID varchar(255),
  LAST_NAME varchar(255),
  NAME varchar(255),
  SECOND_NAME varchar(255),
  DEPARTMENT varchar(255),
  WORK_POSITION varchar(255),
  EMAIL varchar(255),
  MOBILE_PHONE varchar(255),
  PHONE varchar(255),
  LOGIN varchar(255),
  PASSWORD varchar(255),
  DEPARTMENT_XML_ID varchar(255),
  DEPARTMENT_NAME varchar(255)
)";
$conn->query($sql);

// Обработка данных и вставка в базу данных
foreach ($data1 as $row1) {
    $xmlId = $row1[0];
    $department = $row1[4];
    // Нахождение соответствующего значения DEPARTMENT_XML_ID и DEPARTMENT_NAME из второго файла
    foreach ($data2 as $row2) {
        if ($row2[0] === $department) {
            $departmentXmlId = $row2[1];
            $departmentName = $row2[2];
            break;
        }
    }
    // Вставка данных в таблицу
    $sql = "INSERT INTO user (XML_ID, LAST_NAME, NAME, SECOND_NAME, DEPARTMENT, WORK_POSITION, EMAIL, MOBILE_PHONE, PHONE, LOGIN, PASSWORD, DEPARTMENT_XML_ID, DEPARTMENT_NAME) 
          VALUES ('$row1[0]', '$row1[1]', '$row1[2]', '$row1[3]', '$row1[4]', '$row1[5]', '$row1[6]', '$row1[7]', '$row1[8]', '$row1[9]', '$row1[10]', '$departmentXmlId', '$departmentName')";
    $conn->query($sql);
}
print_r($data1); // Отображение записанных данных
$conn->close();
?>