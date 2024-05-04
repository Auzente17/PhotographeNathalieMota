console.log("Le js pour les filtres s'est correctement chargé");

jQuery(document).ready(function ($) {
  var ajaxurl = ajax_params.ajax_url;
  var security = ajax_params.security;
  console.log(security);

  console.log(ajax_params.ajax_url);

  // Initialise Select2 sur les sélecteurs
  $(".custom-select").select2(); // pour cibler les nouveaux sélecteurs custom

  // Charger dynamiquement les options de catégorie d'événement
  $("#categorie").on("change", function () {
    console.log("Changement détecté dans la catégorie d'événement.");
    filterPhotos();
  });

  // Charger dynamiquement les options de format de photo
  $("#format").on("change", function () {
    console.log("Changement détecté dans le format de photo.");
    filterPhotos();
  });

  // Gestionnaire d'événement pour le changement dans le champs de sélection pour le tri par date
  $("#annees").on("change", function () {
    console.log("Changement détecté dans le tri par date.");
    filterPhotos();
  });

  // Fonction pour filtrer les photos en fonction des options sélectionnés dans les champs de sélection
  function filterPhotos() {
    var category = $("#categorie").val();
    var format = $("#format").val();
    var sortByDate = $("#annees").val(); // Utilise la valeur du champ de tri par date

    $.ajax({
      url: ajax_params.ajax_url,
      type: "POST",
      data: {
        security: security, // Jeton de sécurité
        action: "filter_photos",
        category: category,
        format: format,
        sortByDate: sortByDate,
      },
      success: function (response) {
        // Mettre à jour la liste des photos avec les résultats de la requête AJAX
        $("#liste__photo").html(response);
      },

      error: function (xhr, status, error) {
        console.error(xhr.responseText);
        console.log(xhr.status);
      },
      fail: function (jqXHR, textStatus, errorThrown) {
        console.error(
          "Échec de la requête AJAX : " + textStatus + " - " + errorThrown
        );
        console.error("Réponse du serveur : " + jqXHR.responseText);
      },
    });
  }
});
