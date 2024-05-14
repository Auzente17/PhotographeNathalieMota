/**
 * Fonction pour mettre à jour les photos sur la page en fonction des filtres ou de la demande de chargement supplémentaire.
 * @param {boolean} loadMore - Indique si la fonction est appelée pour charger plus de photos.
 */
const updatePhotos = (loadMore = false) => {
  // Préparation des données à envoyer via POST.
  const formData = new FormData();
  formData.append("action", "load_more_photos");
  formData.append("categorie", jQuery("#categorie").val());
  formData.append("format", jQuery("#format").val());
  formData.append("order", jQuery("#annees").val());
  formData.append("nonce", ajax_filtres.ajax_nonce);

  // Ajoute l'offset actuel si l'on souhaite charger plus de photos.
  if (loadMore) {
    formData.append("offset", document.querySelectorAll(".block_photo").length);
  }

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
      if (data && data.data) {
        // Met à jour le contenu HTML avec les nouvelles photos.
        listePhotos.innerHTML = loadMore
          ? listePhotos.innerHTML + data.data
          : data.data;
        manageLoadMoreButton(data.hasMorePhotos);
        attachEventsToImages(); // Réattache les événements pour la lightbox sur les nouvelles images.
      } else {
        console.error("Aucune donnée de photo reçue du serveur.");
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
});
