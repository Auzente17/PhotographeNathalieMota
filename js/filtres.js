/**
 * Fonction pour mettre à jour les photos sur la page en fonction des filtres ou de la demande de chargement supplémentaire.
 * @param {boolean} loadMore - Indique si la fonction est appelée pour charger plus de photos.
 */
const updatePhotos = () => {
  // Préparation des données à envoyer via POST.
  const formData = new FormData();
  formData.append("action", "load_more_photos");
  formData.append("categorie", jQuery("#categorie").val());
  formData.append("format", jQuery("#format").val());
  formData.append("order", jQuery("#annees").val());
  formData.append("offset", 0); // Réinitialiser l'offset pour les nouveaux filtres
  formData.append("nonce", ajax_filtres.ajax_nonce);

  // Ajoute l'offset actuel si l'on souhaite charger plus de photos.
  // if (loadMore) {
  //   const currentOffset = jQuery("#load-more-btn").data("offset") || 0;
  //   formData.append("offset", currentOffset);
  // } else {
  //   formData.append("offset", 0); // Réinitialiser l'offset pour les nouveaux filtres
  // }

  // Envoie la requête AJAX à WordPress
  fetch(ajax_filtres.ajax_url, {
    method: "POST",
    body: formData,
    headers: {
      Accept: "application/json", // Indique que la réponse attendue est en JSON.
    },
  })
    .then((response) => response.json())
    .then((data) => {
      const listePhotos = document.getElementById("liste__photo");
      if (data.success && data.data) {
        // Met à jour le contenu HTML avec les nouvelles photos.
        listePhotos.innerHTML = data.data.html;
        manageLoadMoreButton(data.data.has_more_photos);
        attachEventsToImages(); // Réattache les événements pour la lightbox sur les nouvelles images.

        // Mettre à jour l'offset pour le bouton
        const newOffset = document.querySelectorAll(".block__photo").length;
        jQuery("#load-more-btn").data("offset", newOffset);
      } else {
        console.error("Aucune donnée de photo reçue du serveur.");
        listePhotos.innerHTML = "<p>Aucune photo trouvée.</p>";
        manageLoadMoreButton(false);
      }
    })
    .catch((error) => console.error("Fetch error:", error));
};

/**
 * Gère l'affichage du bouton "Charger plus" en fonction de la disponibilité de plus de photos.
 * @param {boolean} hasMore - Indique s'il y a plus de photos à charger.
 */
const manageLoadMoreButton = (hasMore) => {
  const loadMoreButton = document.getElementById("load-more-btn");
  loadMoreButton.style.display = hasMore ? "block" : "none";
};

/**
 * Initialise les éléments de la page une fois que le DOM est entièrement chargé.
 */
jQuery(document).ready(function ($) {
  // Initialisation de Select2 pour les éléments de sélection.
  $("#categorie, #format, #annees").select2();

  // Met à jour les photos lorsque l'utilisateur change un filtre.
  $("#categorie, #format, #annees").on("select2:select", function () {
    console.log("Mise à jour des photos pour : ", this.id, $(this).val());
    updatePhotos();
  });

  // // Gestion du bouton "Charger plus"
  // $("#load-more-btn").on("click", function () {
  //   console.log("Bouton 'Charger plus' cliqué");
  //   updatePhotos(true);
  // });
});
