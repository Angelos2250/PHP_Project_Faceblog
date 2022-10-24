<?php foreach ($data['blogs'] as $blog) : ?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="media g-mb-30 media-comment">
                <div class="media-body u-shadow-v18 g-bg-secondary g-pa-30">
                    <div class="g-mb-15">
                        <h5 class="h5 g-color-gray-dark-v1 mb-0"><?php $htmlOut($blog->getTitle()); ?></h5>
                        <span class="g-color-gray-dark-v4 g-font-size-12"><?php $htmlOut($blog->getDate()); ?></span>
                    </div>
                    <p><?php $htmlOut($blog->getText()); ?></p>
                    <ul class="list-inline d-sm-flex my-0">
                        <li class="list-inline-item g-mr-20">
                            <a class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover pe-4">
                                <?php $beginForm('Blogs', 'Like',['blog' => $blog->getBlogsId(), 'returnUrl' => $data['returnUrl']], method : 'post'); ?>
                                    <button class="btn btn-primary"><i class="fa fa-thumbs-up"></i> | <?php $htmlOut($blog->getRating()); ?> Likes</button>
                                <?php $endForm(); ?>
                                <div>
                                    <h5 class="h5 g-color-gray-dark-v1 mb-0">Liked By:</h5>
                                    <span class="g-color-gray-dark-v4 g-font-size-12">
                                        <?php foreach ($blog->getLikedBy() as $lb) : ?>
                                            <?php $htmlOut($lb); ?>
                                        <?php endforeach; ?>
                                    </span>
                                </div>
                            </a>
                            <a class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover">
                                <?php if ($data['user']->getUsersId() == $data['euser']): ?>
                                    <?php $beginForm('Blogs', 'Delete',['bid' => $blog->getBlogsId(), 'returnUrl' => $data['returnUrl']], method : 'post'); ?>
                                        <button class="btn btn-danger"><i class="fa fa-trash"></i> | Delete</button>
                                    <?php $endForm(); ?>
                                <?php endif; ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mb-4">
    <hr class="solid">
</div>
<?php endforeach; ?>
