jQuery(document).ready(function ($) {
  $("#load-more-btn").click(function () {
    var btn = $(this);
    var offset = btn.data("offset");
    var nonce = btn.data("security");

    $.ajax({
      url: ajaxobject.ajax_url, // Utilisez l'URL localisée ici
      type: "POST",
      data: {
        action: "load_more_photos", // L'action que WordPress doit exécuter
        nonce: nonce,
        offset: offset,
      },
      beforeSend: function () {
        btn.text("Chargement..."); // Feedback de chargement pour l'utilisateur
      },
      success: function (response) {
        if (response.success) {
          $("#liste__photo").append(response.data);
          btn.data("offset", offset + 8);
          btn.text("Charger plus"); // Incrémenter l'offset pour le prochain chargement
        } else {
          btn.text("Plus de photos à charger");
          btn.prop("disabled", true); // Désactiver le bouton s'il n'y a plus de photos à charger
        }
      },
      error: function (xhr) {
        alert("Erreur de chargement : " + xhr.responseText);
        btn.text("Charger plus");
      },
    });
  });
});
