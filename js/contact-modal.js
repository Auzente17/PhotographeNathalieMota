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
  $(".contact-btn").on("click", function (event) {
    event.preventDefault();
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
