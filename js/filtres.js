console.log("Le JS de filtres s'est correctement chargé");

// Attend que le document soit prêt avant d'appliquer les fonctionnalités
jQuery(function ($) {
  // Initialise le plugin Select2 sur les éléments avec la classe ".custom-select"
  $(".custom-select").select2();

  // Fonction pour récupérer les valeurs sélectionnées dans les filtres
  function getFilterValues() {
    var filters = {};
    $(".custom-select").each(function () {
      var selectId = $(this).attr("id");
      var selectValue = $(this).val();
      if (selectValue !== null && selectValue !== "") {
        filters[selectId] = selectValue;
      }
    });
    return filters;
  }

  // Fonction pour charger les photos en fonction des filtres sélectionnés
  function loadPhotos() {
    var filters = getFilterValues();
    console.log("Filtres envoyés :", filters);

    $.ajax({
      url: ajax_params.ajax_url,
      type: "POST",
      data: {
        action: "filter_photos",
        security: ajax_params.security,
        ...filters,
      },
      success: function (response) {
        // Gestion de la réponse
      },
      error: function (xhr, status, error) {
        console.error("Erreur AJAX :", error);
      },
    });
  }

  // Écoute l'événement "change" sur les éléments avec la classe ".custom-select"
  $(".custom-select").change(loadPhotos);

  // Charge les photos initiales au chargement de la page
  loadPhotos();
});
