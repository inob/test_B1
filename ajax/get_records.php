<?php

// Скрипт для вывода значений в виде таблицы.


include '../db/db_connection.php';

$sql = "SELECT * FROM user";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h3>Значения столбцов:</h3>";
    echo "<table>";
    // Вывод заголовков столбцов
    echo "<tr>";
    while ($fieldinfo = $result->fetch_field()) {
        echo "<th>" . $fieldinfo->name . "</th>";
    }
    echo "</tr>";

    // Вывод данных в виде таблицы
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . $value . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 результатов";
}
$conn->close();
?>