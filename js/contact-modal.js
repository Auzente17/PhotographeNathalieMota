// JS pour la popup modal

console.log("Le JS de la modale s'est correctement chargé");

(function ($) {
  // Fonction pour ouvrir la modale
  function openModal() {
    $(".popup__overlay").css("display", "flex");
  }

  // Fonction pour fermer la modale
  function closeModal() {
    $(".popup__overlay").css("display", "none");
  }

  // Gestion du clic sur le bouton de contact
  $(".contact-btn, .menu-contact-link").on("click", function (event) {
    event.preventDefault();

    // Vérifier si le bouton cliqué est le bouton de contact sur la page single-photo.php
    if ($(this).hasClass("contact-btn")) {
      // Récupérer la valeur de l'attribut data-reference du bouton
      var reference = $("#single-reference").text();
      // Pour définir la valeur du champ #reference dans la modale de contact
      $("#refoto").val(reference);
    } else {
      // vider le champ #reference dans la modale de contact
      $("#refoto").val("");
    }
    openModal();
  });

  // Gestion du clic en dehors de la modale pour la fermer
  $(".popup__overlay").on("click", function (event) {
    if (event.target === this) {
      closeModal();
    }
  });

  // Ajoute un gestionnaire d'événement au clic sur la fenêtre
  $(window).on("click", function (event) {
    // Vérifie si l'élément cliqué est l'overlay de la modale
    if ($(event.target).is(".popup__overlay")) {
      closeModal();
    }
  });

  // Gestion du clic sur la croix pour fermer la modale
  $(".popup__close").on("click", function () {
    closeModal();
  });

  // Gestion du clic sur la touche "Echap" pour fermer la modale
  $(document).on("keydown", function (e) {
    if (e.key === "Escape") {
      closeModal();
    }
  });
})(jQuery);
