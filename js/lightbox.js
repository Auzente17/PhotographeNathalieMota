// Écoute l'événement 'DOMContentLoaded' pour s'assurer que le DOM est complètement chargé
document.addEventListener("DOMContentLoaded", () => {
  // Sélection des éléments du DOM nécessaires
  const lightbox = document.getElementById("lightbox");
  console.log("lightbox:", lightbox);
  const lightboxImage = document.getElementById("lightbox-image");
  const lightboxCategory = document.querySelector(".lightbox-category");
  const lightboxReference = document.querySelector(".lightbox-reference");
  let currentIndex = 0; // Indice de l'image actuellement affichée dans la lightbox

  // Fonction pour mettre à jour le contenu de la lightbox en fonction de l'index de l'image
  function updateLightbox(index) {
    // Sélection de l'image correspondant à l'index
    const images = document.querySelectorAll(".icon-fullscreen");
    const image = images[index];

    // Récupération des données associées à l'image
    const categoryText = image.getAttribute("data-category").toUpperCase();
    const referenceText = image.getAttribute("data-reference").toUpperCase();

    // Mise à jour des éléments de la lightbox avec les nouvelles données
    lightboxImage.src = image.getAttribute("data-full");
    lightboxCategory.textContent = categoryText;
    lightboxReference.textContent = referenceText;
    currentIndex = index;
  }

  // Fonction pour ouvrir la lightbox avec une image spécifique (index)
  function openLightbox(index) {
    console.log("La fonction openLightbox est appelée !");
    updateLightbox(index);
    lightbox.style.display = "block";
  }

  // Fonction pour fermer la lightbox
  function closeLightbox() {
    lightbox.style.display = "none";
  }

  // Gestionnaire d'événement pour le clic sur une image
  const imageClickHandler = (event) => {
    const images = Array.from(document.querySelectorAll(".icon-fullscreen"));
    const index = images.indexOf(event.currentTarget);
    openLightbox(index);
  };

  // Fonction pour attacher les événements aux images
  window.attachEventsToImages = function () {
    const images = document.querySelectorAll(".icon-fullscreen");
    images.forEach((image) => {
      image.removeEventListener("click", imageClickHandler);
      image.addEventListener("click", imageClickHandler);
    });
  };

  // Attachement des événements aux images lors du chargement initial
  attachEventsToImages();

  // Gestionnaire d'événement pour le clic sur le bouton de fermeture
  document
    .querySelector(".lightbox-close")
    .addEventListener("click", closeLightbox);

  // Gestionnaire d'événement pour le clic sur le bouton précédent
  document.querySelector(".lightbox-previous").addEventListener("click", () => {
    const images = document.querySelectorAll(".icon-fullscreen");
    currentIndex = currentIndex > 0 ? currentIndex - 1 : images.length - 1;
    updateLightbox(currentIndex);
  });

  // Gestionnaire d'événement pour le clic sur le bouton suivant
  document.querySelector(".lightbox-next").addEventListener("click", () => {
    const images = document.querySelectorAll(".icon-fullscreen");
    currentIndex = currentIndex < images.length - 1 ? currentIndex + 1 : 0;
    updateLightbox(currentIndex);
  });
});
