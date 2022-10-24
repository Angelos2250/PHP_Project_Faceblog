<?php $render('partial/header', $data); ?>

<h1>Welcome</h1>
<p>Welcome to Faceblog</p>
<div class="row">
  <div class="col-sm-6 pb-2">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Anzahl registrierter Nutzer</h5>
        <p class="card-text"><?php $htmlOut($data['userCount']); ?></p>
      </div>
    </div>
  </div>
  <div class="col-sm-6 pb-2">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Insgesamt geschriebene Blogs</h5>
        <p class="card-text"><?php $htmlOut($data['count']); ?></p>
      </div>
    </div>
  </div>
  <div class="col-sm-6 pb-2">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Geschriebene Blogs in den Letzten 24 Stunden</h5>
        <p class="card-text"><?php $htmlOut($data['24count']); ?></p>
      </div>
    </div>
  </div>
  <div class="col-sm-6 pb-2">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Datum des Letzten Blogs</h5>
        <p class="card-text"><?php $htmlOut($data['latest']); ?></p>
      </div>
    </div>
  </div>
</div>

<?php $render('partial/footer', $data); ?>
    