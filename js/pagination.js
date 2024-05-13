// Fonction pour attacher des événements aux images chargées
function attachEventsToImages() {
  // Votre logique d'attache d'événements ici
  console.log("Les photos se chargent");
}

// Fonction pour gérer le chargement du contenu additionnel
function loadMoreContent() {
  const offset = jQuery("#load-more-btn").data("offset");
  const ajaxurl = ajax_filtres.ajax_url;
  const nonce = ajax_filtres.ajax_nonce; // Récupérer le nonce depuis les paramètres localisés

  // Utilisation d'AJAX pour charger plus de contenu
  jQuery.ajax({
    url: ajaxurl,
    type: "post",
    data: {
      action: "load_more_photos", // Assurez-vous que ce soit le bon action hook
      offset: offset,
      nonce: nonce, // Inclure le nonce dans la requête
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

// Fonction pour traiter la réponse du chargement AJAX
function handleLoadResponse(response, offset) {
  if (response == "Aucune photo trouvée.") {
    handleNoPhotos();
  } else {
    appendPhotos(response);
    updateOffset(offset);
  }
}

// Fonction pour masquer le bouton "viewMore" en cas de l'absence de photos
function handleNoPhotos() {
  jQuery("#load-more-btn").hide();
  console.log("Aucune photo n'est disponible.");
}

// Fonction pour ajouter la réponse à la fin du conteneur des photos
function appendPhotos(response) {
  if (response && response.data) {
    jQuery("#liste__photo").append(response.data);
    attachEventsToImages();
  } else {
    console.error("Erreur: Aucune donnée reçue.");
  }
}

// Fonction pour mettre à jour l'offset pour la prochaine requête
function updateOffset(offset) {
  jQuery("#load-more-btn").data("offset", offset + 8);
}

// Utiliser la délégation d'événement sur un parent stable
jQuery(document).on(
  "click",
  "#load-more-container #load-more-btn",
  function () {
    loadMoreContent();
  }
);

// Ce message s'affichera dans la console lorsque le script JS sera chargé
console.log("Le JS du bouton charger plus s'est correctement chargé");
