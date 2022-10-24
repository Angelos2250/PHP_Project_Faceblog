<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Faceblog</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- DONE: navigation home -->
            <?php $link('Faceblog', 'Home', 'Index', cssClass: 'navbar-brand'); ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
                <nav class="navbar-nav me-auto">
                    <!-- DONE: navigation -->
                    <?php if ($data['user']): ?>
                        <?php $link('MyBlog', 'Blogs', 'Index', ['bid' => $data['user']->getUsersid()], cssClass: 'nav-link');?>
                        <?php $link('People', 'People', 'Index', cssClass: 'nav-link'); ?>
                    <?php endif; ?>
                </nav>
                <!-- TODO: navigation user -->
                <?php $render('partial/user', $data['user']); ?>
            </div>
        </div>
    </nav>
    <div class="container mt-3">
        <?php if(isset($data['errors'])) {
            $render('partial/errors', $data['errors']);
        } ?>