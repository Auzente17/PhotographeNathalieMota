console.log("Le JS de filtres s'est correctement chargé");

// Attend que le document soit prêt avant d'appliquer les fonctionnalités
jQuery(function ($) {
  // Initialise le plugin Select2 sur les éléments avec la classe ".custom-select"
  $(".custom-select").select2({
    // Définit la position du menu déroulant en dessous
    dropdownPosition: "below",
  });

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
    console.log("loadPhotos appelée");
    var filters = getFilterValues();
    console.log("Appel de loadPhotos() avec les filtres suivants :", filters);
    var data = {
      action: "filter_photos",
      security: ajax_params.security,
      ...filters,
    };
    $.post(ajax_params.ajax_url, data)
      .done(function (response) {
        console.log("Réponse reçue :", response);
        if (response.trim() !== "") {
          $("#liste__photo").html(response);
        }
      })
      .fail(function (jqXRH, textStatus, errorThrown) {
        console.error(
          "Erreur lors de la requête AJAX :",
          textStatus,
          errorThrown
        );
      });
  }
  console.log("Photos initiales chargés");
  // Attendre 100 ms avant d'appeler loadPhotos() pour la première fois
  setTimeout(function () {
    // Charge les photos initiales
    loadPhotos();
  }, 100);
  console.log("Photos initiales chargés");

  // Écoute l'événement "change" sur les éléments avec la classe ".custom-select"
  $(".custom-select").change(function () {
    loadPhotos();
  });
});
