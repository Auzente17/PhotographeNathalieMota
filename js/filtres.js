console.log("Le js pour les filtres s'est correctement chargé");

jQuery(document).ready(function ($) {
  var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
  console.log(ajaxurl);

  // Initialise Select2 sur les sélecteurs
  $(".custom-select").select2(); // pour cibler les nouveaux sélecteurs custom

  // Charger dynamiquement les options de catégorie d'événement
  $("#event-category").on("change", function () {
    filterPhotos();
  });

  // Charger dynamiquement les options de format de photo
  $("#photo-format").on("change", function () {
    filterPhotos();
  });

  // Gestionnaire d'événement pour le changement dans le champs de sélection pour le tri par date
  $("#annes").on("change", function () {
    filterPhotos();
  });

  // Fonction pour filtrer les photos en fonction des options sélectionnés dans les champs de sélection
  function filterPhotos() {
    var category = $("#event-category").val();
    var format = $("#photo-format").val();
    var sortByDate = $("#annees").val(); // Utilise la valeur du champ de tri par date

    $.ajax({
      url: ajax_params.ajaxurl,
      type: "POST",
      data: {
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
        console.log(xhr.status.error);
      },
    });
  }
});
