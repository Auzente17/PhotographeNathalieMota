document.addEventListener("DOMContentLoaded", function () {
  // Ajouter les classes de body
  // document.body.classList.add("<?php echo body_class(); ?>");

  // Récupérer les classes de body
  var bodyClasses = "<?php echo body_class(); ?>".split(" ");

  // Ajouter chaque classe individuellement au body
  bodyClasses.forEach(function (className) {
    document.body.classList.add(className);
  });
});
