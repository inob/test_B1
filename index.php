<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тестовое задание B1</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Записи из Базы Данных</h2>
    <button id="showRecordsBtn">Показать записи БД</button>
    <div id="recordsTable"></div>
    
    <h3>Загрузить файл CSV:</h3>
    <form id="uploadForm" enctype="multipart/form-data">
        <input type="file" name="csvFile" id="csvFile">
        <input type="submit" value="Загрузить CSV файл" id="uploadCsvBtn">
    </form>

    <button id="exportDataBtn">Экспортировать данные</button>

    <script> 
        // Показ данных в виде таблицы
        document.getElementById('showRecordsBtn').addEventListener('click', function() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById('recordsTable').innerHTML = xhr.responseText;
                }
            };
            xhr.open('GET', '/ajax/get_records.php', true);
            xhr.send();
        });

        // Загрузка файла .csv
        document.getElementById('uploadForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                }
            };
            xhr.open('POST', '/ajax/upload_csv.php', true);
            xhr.send(formData);
        });

        // Выгрузка данных в файл .csv
        document.getElementById('exportDataBtn').addEventListener('click', function() {
            var xhr = new XMLHttpRequest();
            xhr.responseType = 'blob';
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var a = document.createElement('a');
                    var url = window.URL.createObjectURL(xhr.response);
                    a.href = url;
                    a.download = 'exported_data.csv';
                    a.click();
                    window.URL.revokeObjectURL(url);
                }
            };
            xhr.open('GET', '/ajax/export_data.php', true); 
            xhr.send();
        });
    </script>
</body>
</html>