jQuery(document).ready(function ($) {
  // Initialisation de Select2 pour les éléments select
  $("#categorie, #format, #order").select2();

  // Écouteur d'événements pour le changement sur les filtres
  $("#categorie, #format, #order").on("select2:select", function () {
    updatePhotos();
  });

  // Écouteur d'événements pour le clic sur le bouton "Charger plus"
  $("#load-more-btn").on("click", function () {
    updatePhotos(true);
  });

  // Fonction pour mettre à jour les photos basée sur les filtres appliqués
  function updatePhotos(loadMore = false) {
    const formData = new FormData();
    formData.append("action", "filter_photos"); // ou "load_more_photos" selon l'action désirée
    formData.append("nonce", ajax_params.ajax_nonce); // Récupérer le nonce correctement
    formData.append("categorie", $("#categorie").val());
    formData.append("format", $("#format").val());
    formData.append("order", $("#order").val());

    if (loadMore) {
      formData.append("offset", $(".block_photo").length); // Supposant que les photos sont dans des divs avec la classe block_photo
    }

    fetch(ajax_params.ajax_url, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          let photoContainer = $("#photo__container");
          if (loadMore) {
            photoContainer.append(data.html); // Utiliser la réponse HTML retournée par WordPress
          } else {
            photoContainer.html(data.html);
          }
          manageLoadMoreButton(data.hasMore); // Supposons que la réponse inclut un booléen hasMore pour gérer l'affichage du bouton
        } else {
          handleNoPhotos();
        }
      })
      .catch((error) => console.error("Erreur AJAX: ", error));
  }

  // Fonction pour masquer le bouton "Charger plus" si aucune photo supplémentaire n'est disponible
  function manageLoadMoreButton(hasMore) {
    const loadMoreButton = $("#load-more-btn");
    if (hasMore) {
      loadMoreButton.show();
    } else {
      loadMoreButton.hide();
    }
  }

  // Fonction pour gérer le cas où aucune photo n'est disponible
  function handleNoPhotos() {
    $("#photo__container").html("<p>Aucune photo n'est disponible.</p>");
    $("#load-more-btn").hide();
  }

  // Fonction pour attacher des événements aux images chargées
  function attachEventsToImages() {
    console.log("Les événements sur les nouvelles images ont été attachés.");
  }
});
