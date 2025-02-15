$(document).ready(function() {
    $('#uploadForm').on('submit', function(e) {
        e.preventDefault(); // Отменяем стандартное поведение формы

        const formData = new FormData(this); // Создаем объект FormData

        $.ajax({
            url: 'php/upload.php', // Укажите путь к вашему PHP-скрипту
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === 'success') {
                    $('#result').html('<div class="circle success"></div>' + 'Файл успешно отправлен <br>' + response.results.join('<br>'));
                } else {
                    $('#result').html('<div class="circle error"></div>' + response.message);
                }
            }
        });
    });
});