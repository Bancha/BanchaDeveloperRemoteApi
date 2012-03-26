<html>
    <head>
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" type="text/css" href="../BanchaDeveloperRemoteApi/css/highligther-zenburn.css">
    </head>
    <body>
        <?php hyperlight(file_get_contents($path), 'php'); ?>
    </body>
</html>