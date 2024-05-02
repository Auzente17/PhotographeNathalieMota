// Affichage d'un message dans la console pour vérifier que le JS s'est correctement chargé
console.log("Le JS de la lightbox s'est correctement chargé");

document.addEventListener("DOMContentLoaded", function () {
  // Fonction pour ouvrir la lightbox au clic sur l'icône fullscreen
  function openLightbox(event) {
    console.log("La fonction openLightbox est appelée !");
    // Empêche le comportement par défaut du lien
    event.preventDefault();

    // Récupère les attributs de données de l'icône fullscreen cliquée
    var imageURL = this.getAttribute("data-full");
    console.log(imageURL);
    var imageCategory = this.getAttribute("data-category");
    console.log(imageCategory);

    console.log("Avant de sélectionner les éléments de la lightbox");
    // Sélectionne les éléments de la lightbox
    var lightbox = document.getElementById("lightbox");
    var lightboxImage = document.getElementById("lightbox-image");
    var lightboxCaption = document.getElementById("lightbox-caption");

    // Met à jour l'image et la légende de la lightbox avec les données récupérées
    lightboxImage.setAttribute("src", imageURL);
    lightboxCaption.innerHTML = imageCategory;

    // Ajoute la classe pour afficher la lightbox
    lightbox.classList.add("lightbox-open");

    // Affiche la lightbox
    lightbox.style.display = "block";
  }

  // Sélectionne tous les icônes fullscreen
  var fullscreenIcons = document.querySelectorAll(".icon-fullscreen");

  // Ajoute un écouteur d'événements à chaque icône fullscreen
  fullscreenIcons.forEach(function (icon) {
    icon.addEventListener("click", openLightbox);
  });

  // Fonction pour fermer la lightbox
  function closeLightbox() {
    var lightbox = document.getElementById("lightbox");
    // Supprime la classe pour masquer la lightbox
    lightbox.classList.remove("lightbox-open");
    // Réactive le défilement de la page
    document.body.style.overflow = "auto";
  }

  // Sélectionne l'icône de fermeture de la lightbox
  var closeIcon = document.querySelector(".lightbox-close");

  // Ajoute un écouteur d'événements au clic sur l'icône de fermeture
  closeIcon.addEventListener("click", closeLightbox);

  // Ajoute un écouteur d'événements au clic en dehors de la lightbox pour la fermer
  document.addEventListener("click", function (event) {
    var lightbox = document.getElementById("lightbox");
    if (event.target === lightbox) {
      closeLightbox();
    }
  });
});
