<?php


class Form_AddBook extends Form
{
    public function handle()
    {
        $name = $_POST['name'] ?? '';
        $year = $_POST['year'] ?? 0;
        $authors = [$_POST['author1'] ?? '', $_POST['author2'] ?? '', $_POST['author3'] ?? ''];
        $description = $_POST['description'] ?? '';


        // Может сделать через регулярки? -_-  [Нужно переделать!]
        $name = trim($name);
        if(strlen($name) === 0){
            $this->showError("The 'name' field must not be empty");
        }
        if(!is_numeric($year) || !($year >= 1900 && $year <= 2020)){
            $this->showError('The year should be no less than 1900 and no more than 2020');
        }
        $description = trim($description);
        if(strlen($description) === 0){
            $this->showError("The 'description' field must not be empty");
        }
        $image = isset($_FILES['image']['name']) ? $image = $this->downloadImage() : 'default.jpg';

        // добавляем книгу
        $stmt = $this->db->prepare('INSERT INTO `library`.`books` (`name`, `img`, `year`, `description`) VALUES (:name, :img, :year, :description)');
        $stmt->execute([
            ':name' => htmlspecialchars($name),
            ':img' => htmlspecialchars($image),
            ':year' => htmlspecialchars($year),
            ':description' => htmlspecialchars($description)
        ]);
        $bookId = $this->db->lastInsertId();

        // Проверяем существует ли автор
        foreach($authors as $author){
            if($author === ''){
                continue;
            }
            $stmt = $this->db->prepare("INSERT INTO `library`.`authors` SET `name` =  :name ON DUPLICATE KEY UPDATE `id` = LAST_INSERT_ID(`id`), name = :name");
            $stmt->execute(['name' => $author]);
            $authorId = $this->db->lastInsertId();
            $this->db->query('INSERT INTO `library`.`booksAuthors` (`author_id`, `book_id`) VALUES ("'. $authorId .'", "'. $bookId .'")');
        }
        $this->redirectToReferer();
    }

    private function downloadImage(){
        // Перезапишем переменные для удобства
        $filePath  = $_FILES['image']['tmp_name'];
        $errorCode = $_FILES['image']['error'];

        // Проверим на ошибки
        if ($errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($filePath)) {

            // Массив с названиями ошибок
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE   => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
                UPLOAD_ERR_FORM_SIZE  => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
                UPLOAD_ERR_PARTIAL    => 'Загружаемый файл был получен только частично.',
                UPLOAD_ERR_NO_FILE    => 'Файл не был загружен.',
                UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
                UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
                UPLOAD_ERR_EXTENSION  => 'PHP-расширение остановило загрузку файла.',
            ];

            // Зададим неизвестную ошибку
            $unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';

            // Если в массиве нет кода ошибки, скажем, что ошибка неизвестна
            $outputMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : $unknownMessage;

            // Выведем название ошибки
            die($outputMessage);
        }

        // Создадим ресурс FileInfo
        $fi = finfo_open(FILEINFO_MIME_TYPE);

        // Получим MIME-тип
        $mime = (string) finfo_file($fi, $filePath);

        // Проверим ключевое слово image (image/jpeg, image/png и т. д.)
        if (strpos($mime, 'image') === false) die('Можно загружать только изображения.');

        // Сгенерируем новое имя файла на основе MD5-хеша
        $name = md5_file($filePath);

        // Сгенерируем расширение файла на основе типа картинки
        $extension = image_type_to_extension(IMAGETYPE_JPEG);

        // Сократим .jpeg до .jpg
        $format = str_replace('jpeg', 'jpg', $extension);

        // Переместим картинку с новым именем и расширением в папку /pics
        $new = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'books' . DIRECTORY_SEPARATOR . $name . $format;
        if (!move_uploaded_file($filePath, $new)) {
            die('При записи изображения на диск произошла ошибка.');
        }
        return $name . $format;
    }

}