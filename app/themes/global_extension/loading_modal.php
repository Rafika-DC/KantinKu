<div id="loadingModal" class="modal-loading">
  <div class="modal-loading-content">
      <div class="base-spinner">
        <?php if($setting->icon && file_exists('./data/setting/'.$setting->icon)) : ?>
        <img src="<?= image_check($setting->icon,'setting'); ?>" alt="">
        <?php endif;?>
        <div class="spinner-loader"></div>
      </div>
      <p id="text_loading">Tunggu sebentar...</p>
  </div>
</div>
