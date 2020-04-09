<section id="main" class="main-wrapper">
    <div class="container">
        <div id="content" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php foreach ($data['books'] as $book) { ?>
                <div data-book-id="<?= $book['id'] ?>" class="book_item col-xs-6 col-sm-3 col-md-2 col-lg-2">
                    <div class="book">
                        <a href="/book/<?= $book['id'] ?>"><img src="/img/books/<?= $book['img'] ?>"
                                                                alt="<?= $book['name'] ?>">
                            <div data-title="<?= $book['name'] ?>" class="blockI" style="height: 46px;">
                                <div data-book-title="<?= $book['name'] ?>" class="title size_text">
                                    <?= $book['name'] ?>
                                </div>
                                <div data-book-author="<?= $book['author'] ?>"
                                     class="author"><?= $book['author'] ?></div>
                            </div>
                        </a>
                        <a href="/book/<?= $book['id'] ?>">
                            <button type="button" class="details btn btn-success">Читать</button>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <center>
        <?php if (($_GET['offset'] ?? 0) > 1): ?>
            <a href="<?= '/?offset=' . (($_GET['offset'] - 20) < 0 ? 0 : $_GET['offset'] - 20) ?>">
                <button type="button" class="details btn btn-success">Назад</button>
            </a>
        <?php endif; ?>
        <?php
        ?>
        <?php if (($data['numberBooks'] > 20 + ($_GET['offset'] ?? 0))): ?>
            <a href="?offset=<?= ($_GET['offset'] ?? 0) + 20 ?>">
                <button type="button" class="details btn btn-success">Вперед</button>
            </a>
        <?php endif; ?>
    </center>
</section>