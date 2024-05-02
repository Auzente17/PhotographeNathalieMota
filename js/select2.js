console.log("Le JS de select2 s'est correctement chargé");

// Attend que le document soit prêt avant d'appliquer les fonctionnalités
jQuery(function ($) {
  // Initialise le plugin Select2 sur les éléments avec la classe ".custom-select"
  $(".custom-select").select2({
    // Définit la position du menu déroulant en dessous
    dropdownPosition: "below",
  });
});
