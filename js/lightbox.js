// Fonction principale exécutée lorsque le DOM est chargé
function initializeLightbox() {
  console.log("Le JS de la lightbox s'est correctement chargé");

  // Attacher un gestionnaire d'événements lorsque le DOM est chargé
  document.addEventListener("DOMContentLoaded", function () {
    // Ajouter un gestionnaire d'événements à chaque icône fullscreen
    const fullscreenIcons = document.querySelectorAll(".icon-fullscreen");
    fullscreenIcons.forEach((icon) => {
      icon.addEventListener("click", openLightbox.bind(icon));
    });

    // Ajouter un gestionnaire d'événements au bouton de fermeture
    const closeButton = document.querySelector(".lightbox-close");
    closeButton.addEventListener("click", closeLightbox);
  });
}

// Fonction pour ouvrir la lightbox
function openLightbox(event) {
  console.log("La fonction openLightbox est appelée !");
  console.log("L'icône fullscreen a été cliquée !");
  // Empêche le comportement par défaut du lien
  event.preventDefault();

  // Récupère les données de l'icône fullscreen cliquée
  const imageURL = event.currentTarget.getAttribute("data-full");
  console.log("URL de l'image:", imageURL);
  const imageCategory = event.currentTarget.getAttribute("data-category");
  console.log("Catégorie de l'image:", imageCategory);

  console.log("Avant de sélectionner les éléments de la lightbox");
  // Sélectionne les éléments de la lightbox
  const lightbox = document.getElementById("lightbox");
  console.log("lightbox:", lightbox);
  const lightboxImage = document.getElementById("lightbox-image");
  console.log("lightboxImage:", lightboxImage);
  const lightboxCaption = document.getElementById("lightbox-caption");
  console.log("lightboxCaption:", lightboxCaption);

  // Mettre à jour l'image et la légende de la lightbox
  lightboxImage.setAttribute("src", imageURL);
  lightboxCaption.innerHTML = imageCategory;

  // Ajoute la classe pour afficher la lightbox
  lightbox.classList.add("lightbox-open");
  console.log("La lightbox est ouverte !");
}
// Fonction pour fermer la lightbox
function closeLightbox() {
  const lightbox = document.querySelector(".lightbox");
  lightbox.style.display = "none";
}
// Appel de la fonction principale
initializeLightbox();
