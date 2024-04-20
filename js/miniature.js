// Affichage d'un message dans la console pour vérifier que le JS s'est correctement chargé
console.log("Le JS des miniatures s'est correctement chargé");

// Attend que le document soit prêt avant d'exécuter le code
jQuery(document).ready(function ($) {
  // Sélectionne l'élément avec l'ID 'miniature'
  const miniature = $("#miniature");
  // Sélectionne les flèches gauche et droite avec la classe 'arrow-left' et 'arrow-right'
  const arrowSelectors = ".arrow-left, .arrow-right";

  // Fonction pour afficher la miniature lors du survol
  function showThumbnail() {
    miniature.css({
      visibility: "visible",
      opacity: 1,
    }).html(`<a href="${$(this).data("target-url")}">
                    <img src="${$(this).data(
                      "thumbnail-url"
                    )}" alt="${$(this).hasClass("arrow-left") ? "Photo précédente" : "Photo suivante"}">
                </a>`);
  }

  // Fonction pour masquer la miniature lorsqu'on quitte le survol
  function hideThumbnail() {
    miniature.css({
      visibility: "hidden",
      opacity: 0,
    });
  }

  // Fonction pour rediriger vers l'URL cible lors du clic sur une flèche
  function redirectToTarget() {
    window.location.href = $(this).data("target-url");
  }

  // Associe les fonctions aux événements des flèches
  $(arrowSelectors).on({
    mouseenter: showThumbnail,
    mouseleave: hideThumbnail,
    click: redirectToTarget,
  });
});
