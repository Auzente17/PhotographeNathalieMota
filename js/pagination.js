/**
 * Attache des événements aux images pour activer la lightbox lorsqu'elles sont cliquées.
 */
function attachEventsToImages() {
  console.log("Les photos se chargent");
  const images = document.querySelectorAll(".icon-fullscreen");
  images.forEach((image) => {
    image.removeEventListener("click", imageClickHandler); // Supprimer l'ancien gestionnaire pour éviter les doublons
    image.addEventListener("click", imageClickHandler); // Attacher le nouvel gestionnaire
  });
}
/**
 * Charge plus de contenu en utilisant AJAX en fonction de l'offset actuel.
 */
function loadMoreContent() {
  const offset = parseInt(jQuery("#load-more-btn").data("offset"), 10);
  const ajaxurl = ajax_filtres.ajax_url;
  const nonce = ajax_filtres.ajax_nonce; // Récupérer le nonce depuis les paramètres localisés

  // Utilisation d'AJAX pour charger plus de contenu
  jQuery.ajax({
    url: ajaxurl,
    type: "post",
    data: {
      action: "load_more_photos",
      offset: offset,
      nonce: nonce, // Passer le nonce pour la validation côté serveur.
    },
    success: function (response) {
      handleLoadResponse(response, offset);
    },
    error: function (xhr, status, error) {
      console.error("Erreur AJAX : " + status + ", détails : " + error);
      console.error("Réponse du serveur : ", xhr.responseText);
    },
  });
}

/**
 * Traite la réponse AJAX pour ajouter des photos et mettre à jour l'interface.
 * @param {Object} response - La réponse du serveur.
 * @param {number} initialOffset - L'offset initial avant le chargement des nouvelles photos.
 */
function handleLoadResponse(response, initialOffset) {
  console.log("Response from AJAX request: ", response);
  if (response && response.data) {
    appendPhotos(response);
    const newOffset = initialOffset + 8; // Augmenter l'offset de 8 après chaque chargement.
    jQuery("#load-more-btn").data("offset", newOffset); // Mettre à jour l'offset stocké dans le bouton
    attachEventsToImages(); // Ré-attacher les événements pour la lightbox sur les nouvelles images.
  } else if (response === "Aucune photo trouvée.") {
    handleNoPhotos();
  } else {
    console.error("Erreur: Aucune donnée reçue.");
  }
}

/**
 * Cache le bouton "Charger plus" si aucune photo supplémentaire n'est disponible.
 */
function handleNoPhotos() {
  jQuery("#load-more-btn").hide();
  console.log("Aucune photo n'est disponible.");
}

/**
 * Ajoute les nouvelles photos chargées au conteneur de la liste des photos.
 * @param {Object} response - La réponse contenant les données des nouvelles photos.
 */
function appendPhotos(response) {
  jQuery("#liste__photo").append(response.data);
}

// Configuration de l'événement de clic pour le bouton de chargement supplémentaire.
jQuery(document)
  .off("click", "#load-more-container #load-more-btn")
  .on("click", "#load-more-container #load-more-btn", function () {
    console.log("Bouton cliqué");
    loadMoreContent();
  });

// Message pour indiquer que le script a été chargé correctement.
console.log("Le JS du bouton charger plus s'est correctement chargé");
