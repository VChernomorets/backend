<div class="container">
    <header>
        <div class="row">
            <div class="col-lg-8">
                <h1>Библиотека++</h1>
            </div>
            <div class="col-sm">
                <div class="logout text-right align-middle">
                    <a href="/logout/">Выход</a>
                </div>
            </div>
        </div>
    </header>
    <div class="row mb-5">
        <div class="col-lg-6 addBook">
            <h4>Добавить новую книгу</h4>
            <form name="addBook" action="/form/addBook/" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group col">
                        <label for="exampleInputEmail1">Название книги</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="form-group col">
                        <label for="exampleInputPassword1">Год издания</label>
                        <input type="number" min="1900" max="2020" class="form-control" id="year" name="year">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label for="exampleFormControlFile1">Изображение</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                    </div>
                    <div class="authors col">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Автор 1</label>
                            <input type="text" class="form-control" id="author1" name="author1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Автор 2</label>
                            <input type="text" class="form-control" id="author2" name="author2">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Автор 3</label>
                            <input type="text" class="form-control" id="author3" name="author3">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Описание</label>
                    <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <div class="row justify-content-between">
        <div class="col-lg-12 books">
            <div class="books"></div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Название</th>
                    <th scope="col">Автор</th>
                    <th scope="col">Год</th>
                    <th scope="col">Кликов</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data['books'] as $book) { ?>
                    <tr>
                        <td><img src="/img/books/<?= $book['img'] ?>" alt="" style="width: 50px"></td>
                        <td><?= $book['name'] ?></td>
                        <td><?= $book['author'] ?></td>
                        <td><?= $book['year'] ?></td>
                        <td><?= $book['click'] ?></td>
                        <td><a href="/form/deleteBook?id=<?= $book['id'] ?>">удалить</a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= (($_GET['page'] ?? 1) > 1) ? '' : 'disabled' ?>">
                        <a class="page-link" href="?page=<?=$_GET['page'] -1?>" tabindex="-1">Previous</a>
                    </li>
                    <?php
                    $numberPages = ceil($data['numberBooks'] / 20);
                    for ($i = 1; $i <= $numberPages; $i++){
                    ?>
                        <li class="page-item <?= ($_GET['page'] ?? 1) == $i ? 'disabled' : ''?>">
                            <a class="page-link" href="?page=<?=$i?>"><?=$i?></a>
                        </li>
                    <?php } ?>
                    <li class="page-item <?= ($numberPages > ($_GET['page'] ?? 1))  ? '' : 'disabled' ?>">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>