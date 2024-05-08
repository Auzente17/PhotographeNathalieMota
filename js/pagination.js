(function ($) {
  var offset = 8; // Suppose que les 8 premières photos sont déjà chargées
  var nberphotos = 8; // Nombre de photos à charger par requête

  function loadMorePhotos() {
    var data = {
      action: "load_more_photos",
      offset: offset,
      nonce: ajax_filtres.ajax_nonce,
    };

    $.post(ajax_filtres.ajax_url, data, function (response) {
      var $response = $(response);
      if (!$response.trim() || $response.children().length < nberphotos) {
        $("#load-more-btn").hide();
      } else {
        $("#liste__photo").append(response);
        offset += nberphotos; // Mettre à jour l'offset pour le prochain chargement
        $("#load-more-btn").show();
      }
    }).fail(function (xhr) {
      console.log("Erreur lors du chargement des photos :", xhr.responseText);
      $("#load-more-btn").text("Erreur, essayez de nouveau");
    });
  }

  $("#load-more-btn").click(function () {
    loadMorePhotos();
  });
})(jQuery);
