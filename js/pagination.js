jQuery(document).ready(function ($) {
  console.log("script chargé");
  // Cliquez sur le bouton "Charger plus"
  $("#load-more-btn").on("click", function () {
    console.log("ok");
    var offset = $(this).data("offset");
    var security = ajax_params.security;

    // Requête AJAX
    $.ajax({
      url: ajax_params.ajax_url, // URL de l'API AJAX de WordPress
      type: "POST",
      data: {
        action: "load_more_photos", // Action à exécuter dans la fonction PHP
        offset: offset, // Offset pour obtenir les prochaines photos
        security: ajax_params.security, // Jeton de sécurité
      },
      beforeSend: function () {
        // Afficher un indicateur de chargement
        $("#load-more-btn").html("Chargement en cours...");
      },
      success: function (response) {
        // Ajouter les nouvelles photos au conteneur
        $("#liste__photo").append(response);

        // Mettre à jour l'offset
        $("#load-more-btn").data("offset", offset + 8);

        // Masquer l'indicateur de chargement
        $("#load-more-btn").html("Charger plus");
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
      },
    });
  });
});
