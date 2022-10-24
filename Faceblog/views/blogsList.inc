<?php $render('partial/header', $data); ?>
<?php if ($data['user'] and $data['user']->getUsersId() == $data['euser']): ?>
<h2>New Blog</h2>
<?php $beginForm('Blogs', 'NewPost', ['returnUrl' => $data['returnUrl']], method: 'post'); ?>
    <div>
        <div class="pb-2">
            <input class="form-control form-control-lg" type="text" placeholder="Title" name="title">
        </div>
        <div class="pb-3">
            <textarea class="w-100" placeholder="What's on your mind?" name="text"></textarea>
        </div>
        <div>
            <button class="btn btn-primary">Post</button>
        </div>
    </div>
<?php $endForm(); ?>
    <div class="mb-4">
        <hr class="solid">
    </div>
<?php endif; ?>
<h2><?php $htmlOut($data['displaynm']); ?>'s Blogs</h2>
<?php if ($data['blogs'] != null && sizeof($data['blogs']) > 0) {
    $render('partial/blogs', $data);
} else {?>
    <p>No Blogs Yet.</p>
<?php } ?>
<?php $render('partial/footer', $data); ?>