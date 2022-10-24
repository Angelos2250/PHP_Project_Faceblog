<?php $render('partial/header', $data); ?>

<?php $beginForm('People', 'Search', method: 'post'); ?>
    <div class="container justify-content-center">
        <div class="input-group mb-3">
            <input type="text" class="form-control input-text" placeholder="Find your Friends...." id="dnm" name="dnm"/>
            <div class="input-group-append">
                <button class="btn btn-outline-warning btn-lg"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </div>
<?php $endForm(); ?>
<?php foreach ($data['people'] as $p) : ?>
    <div class="d-flex justify-content-center pb-5">
        <div class="col-md-8">
            <div class="panel panel-white panel-shadow">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="image-container bg2">
                            <img src="https://bootdey.com/img/Content/user_3.jpg" class="avatar" alt="avatar">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="details">
                            <h4><?php $htmlOut($p->getDisplayName()); ?> <i class="fa fa-sheild"></i></h4>
                            <div>Mitglied seit:</div>
                            <div>DATUM</div>
                            <div class="mg-top-10">
                                <?php $beginForm('Blogs', 'Search', method: 'post', params: ['uid' => ($p->getUsersId()),'dpn' => ($p->getDisplayName()), 'returnUrl' => $data['returnUrl']]); ?>
                                     <button class="btn btn-outline-warning btn-lg">About <?php $htmlOut($p->getDisplayName()); ?> </button>
                                <?php $endForm(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?php $render('partial/footer', $data); ?>