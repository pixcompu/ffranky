<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?></title>
    <?php printStyles(${PAGE_STYLE_SECRET_KEYWORD}); ?>
    <?php printScripts(${PAGE_TOP_SCRIPT_SECRET_KEYWORD}); ?>
</head>
<body>
    <?= $pageContent ?>
    <?php printScripts(${PAGE_BOTTOM_SCRIPT_SECRET_KEYWORD}) ?>
</body>
</html>