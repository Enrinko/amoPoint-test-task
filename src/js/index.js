document.addEventListener('DOMContentLoaded', function() {
    const maxFileSize = 2 * 1024 * 1024; // Максимальный размер файла 2 МБ
    const fileInput = document.querySelector('#uploadForm > input');
    const messageDiv = document.getElementById('result');
    fileInput.addEventListener('change', function() {
        const file = fileInput.files[0]; // Получаем первый загруженный файл
        const div = document.createElement("div");
        div.classList.add('circle');
        div.classList.add('error');
        messageDiv.innerHTML = "";
        if (file) {
            let message = "";
            const fileType = file.type;
            const validFileType = 'text/plain'; // MIME-тип для .txt
            if (fileType !== validFileType) {
                message += "Ошибка: файл должен быть в формате .txt.<br>";
            }
            if (file.size > maxFileSize) {
                message += "Ошибка: файл слишком большой. Максимальный размер файла: 2 МБ.<br>";
            }
            if (message !== "") {
                messageDiv.appendChild(div);
                messageDiv.innerHTML += (message);
                fileInput.value = ''; // Сбрасываем поле ввода
            }
        }
    });
});