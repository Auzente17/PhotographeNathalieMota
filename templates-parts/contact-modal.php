<!-- MODAL DE CONTACT -->

<div class="popup__overlay">
  <div class="popup__contact">
    <div class="popup-title__container">
    <span class="popup__close"></span>
    <img src="<?php echo get_template_directory_uri() . '/assets/images/contact.png'; ?>" alt="contact">
  </div>
  <div class="popup__informations">
    <?php
    // Insertion du formulaire
    echo do_shortcode('[contact-form-7 id="cbec88d" title="ContactModal"]');
    ?>
    </div>
</div>
