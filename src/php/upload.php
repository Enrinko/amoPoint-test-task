<?php
$uploadDir = '../files/';
$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            throw new Exception('Ошибка загрузки файла: ' . $_FILES['file']['error']);
        }
        $fileName = basename($_FILES['file']['name']);
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $uploadFilePath = $uploadDir . $fileName;
        // Перемещение загруженного файла
        if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath)) {
            throw new Exception('Не удалось переместить загруженный файл.');
        }
        $response['status'] = 'success';
        // Чтение файла и обработка
        $content = file_get_contents($uploadFilePath);
        if ($content === false) {
            throw new Exception('Не удалось прочитать файл.');
        }
        $lines = explode(PHP_EOL, $content);
        $results = [];
        // Подсчет цифр в каждой строке
        foreach ($lines as $line) {
            $countDigits = preg_match_all('/\d/', $line);
            $results[] = "$line = $countDigits";
        }
        $response['results'] = $results;
    } catch
    (Exception $e) {
        $response['status'] = 'error';
        $response['message'] = $e->getMessage();
    }

    // Возвращаем JSON-ответ
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>