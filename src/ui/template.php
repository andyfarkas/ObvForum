<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Obv Forum UI</title>
</head>
<body>
<div class="container">
    <h1>ObvForum</h1>

    <form method="POST" action="/test">
        <div class="form-group">
            <label for="categoryName">Category name</label>
            <input type="text" name="categoryName" class="form-control" id="categoryName" placeholder="Enter category name">
        </div>
        <button type="submit" class="btn btn-primary" name="btnCreateCategory">Create</button>
    </form>

    <table class="table table-bordered table-dark">
        <thead>
        <tr>
            <th scope="col">Category name</th>
        </tr>
        </thead>
        <tbody>
        <?php
        use Obv\ObvForum\Categories\Category;
        use Obv\ObvForum\Topics\Topic;

        foreach($categories as $category) /**@var Category $category**/ {?>
            <tr>
                <th scope="row">
                    <?php echo $category->getName();?>
                    <p></p>

                    <ul class="list-group">
                        <?php foreach ($categoryTopics[$category->getId()] as $topic /** @var Topic $topic **/){?>
                            <li class="list-group-item" style="color: black"><?php echo $topic->getTitle();?></li>
                        <?php }?>
                    </ul>

                    <p></p>
                    <form method="POST" action="/topic">
                        <div class="form-group">
                            <input type="text" name="topicTitle" class="form-control form-control-sm" placeholder="Enter topic name">
                            <textarea class="form-control form-control-sm" name="topicText" rows="5"></textarea>
                            <input type="hidden" name="categoryId" value="<?php echo $category->getId();?>"/>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm" name="btnCreateTopic">Create</button>
                    </form>
                </th>
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>
</body>
</html>