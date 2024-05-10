jQuery(document).ready(function ($) {
  // Je récupère les valeurs des filtres sélectionnés
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

  // Je charge les photos en fonction des filtres sélectionnés
  function loadPhotos() {
    // Je récupère les valeurs des filtres sélectionnés
    var filters = getFilterValues();
    // J'envoie une requête AJAX au serveur
    $.ajax({
      url: ajax_filtres.ajax_url,
      type: "POST",
      data: {
        action: "filter_photos",
        categorie: filters.categorie,
        format: filters.format,
        order: filters.annees,
      },
      success: function (response) {
        // J'affiche les photos filtrées
        $("#liste__photos").html(response.data);
      },
      error: function (xhr, status, error) {
        console.error(error);
      },
    });
  }

  // J'écoute les changements sur les filtres
  $(".custom-select").on("change", function () {
    loadPhotos();
  });

  // Je charge les photos au chargement de la page
  loadPhotos();
});
