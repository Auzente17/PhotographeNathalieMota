jQuery(document).ready(function ($) {
  console.log("Nonce récupéré:", ajax_params.security); // Affiche la valeur du nonce dans la console

  // Cliquez sur le bouton "Charger plus"
  $("#load-more-btn").on("click", function () {
    var $(this) = $(this); // Définition de $this ici pour capturer le bouton qui a déclenché l'événement
    console.log("ok");
    var offset = $this.data("offset");
    var security = ajax_params.security; // Capturez le nonce

    console.log("Envoi de la requête AJAX avec nonce:", security); // Confirmer le nonce utilisé

    // Requête AJAX
    $.ajax({
      url: ajax_params.ajax_url, // URL de l'API AJAX de WordPress
      type: "POST",
      data: {
        action: "load_more_photos", // Action à exécuter dans la fonction PHP
        offset: offset, // Offset pour obtenir les prochaines photos
        security: security, // Envoi du nonce pour la vérification
      },

      beforeSend: function () {
        // Afficher un indicateur de chargement
        $(this).html("Chargement en cours...");
      },
      success: function (response) {
        console.log("Réponse reçue:", response);
        // Ajouter les nouvelles photos au conteneur
        if (response.trim() != "") {
          $("#liste__photo").append(response);
          $(this).data("offset", offset + 8); // Mise à jour de l'offset pour le prochain chargement
          $(this).html("Charger plus"); // Réinitialisation du texte du bouton
        } else {
          $this.html("Aucune photo trouvée"); // // Mise à jour du texte si aucune photo n'est trouvée
        }
      },

      error: function (xhr) {
        console.error("Erreur AJAX : " + xhr.statusText); // Affichage des erreurs AJAX
        $(this).html("Erreur lors du chargement"); // Mise à jour du texte en cas d'erreur
      },
    });
  });
});
