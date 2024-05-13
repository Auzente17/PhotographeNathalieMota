// Fonction pour mettre à jour les photos en fonction des filtres
const updatePhotos = (loadMore = false) => {
  // Crée un FormData pour envoyer les données en POST
  const formData = new FormData();
  formData.append("action", "load_more_photos");
  formData.append("categorie", jQuery("#categorie").val());
  formData.append("format", jQuery("#format").val());
  formData.append("order", jQuery("#annees").val());
  formData.append("nonce", ajax_filtres.ajax_nonce);

  // Ajoute l'offset si l'on souhaite charger plus de photos
  if (loadMore) {
    formData.append("offset", document.querySelectorAll(".block_photo").length);
  }

  // Envoie la requête AJAX à WordPress
  fetch(ajax_filtres.ajax_url, {
    method: "POST",
    body: formData,
    headers: {
      Accept: "application/json", // S'assurer que le serveur sait que le client s'attend à du JSON
    },
  })
    .then((response) => response.json())
    .then((data) => {
      const listePhotos = document.getElementById("liste__photo");
      if (data && data.data) {
        listePhotos.innerHTML = loadMore
          ? listePhotos.innerHTML + data.data
          : data.data;
        manageLoadMoreButton(data.hasMorePhotos);
      } else {
        console.error("No photos data returned from the server.");
      }
    })
    .catch((error) => console.error("Fetch error:", error));
};

// Fonction pour gérer l'affichage du bouton "Charger plus"
const manageLoadMoreButton = (hasMore) => {
  const loadMoreButton = document.getElementById("load-more-btn");
  loadMoreButton.style.display = hasMore ? "block" : "none";
};

// Initialise Select2 une fois le DOM chargé
jQuery(document).ready(function ($) {
  // Initialise Select2 sur les éléments <select>
  $("#categorie, #format, #annees").select2();

  // Met à jour les photos lorsqu'une option est sélectionnée via Select2
  $("#categorie, #format, #annees").on("select2:select", function () {
    console.log("Mise à jour des photos pour : ", this.id, $(this).val());
    updatePhotos();
  });

  // Gère l'événement clic sur le bouton "Charger plus"
  $("#load-more-btn").on("click", function () {
    updatePhotos(true);
  });
});
