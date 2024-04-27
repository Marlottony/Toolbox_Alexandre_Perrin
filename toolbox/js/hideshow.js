// Cette ligne indique à jQuery d'exécuter la fonction suivante une fois que le DOM est prêt.
$(document).ready(function() {

    // Choisir le texte pour le lien afficher/masquer - peut contenir du HTML (par exemple, une image).
    var showText='Afficher';
    var hideText='Masquer';

    // Initialiser la vérification de visibilité.
    var is_visible = false;

    // Ajouter des liens afficher/masquer à l'élément juste avant l'élément avec la classe "toggle".
    $('.toggle').prev().append(' <a href="#" class="toggleLink">'+hideText+'</a>');

    // Masquer tous les éléments avec la classe 'toggle'.
    $('.toggle').show();

    // Capturer les clics sur les liens afficher/masquer.
    $('a.toggleLink').click(function() {

        // Inverser la visibilité.
        is_visible = !is_visible;

        // Changer le texte du lien en fonction de l'état actuel de l'élément.
        if ($(this).text()==showText) {
            $(this).text(hideText);
            $(this).parent().next('.toggle').slideDown('slow');
        }
        else {
            $(this).text(showText);
            $(this).parent().next('.toggle').slideUp('slow');
        }

        // Retourner false pour empêcher le suivi de l'URL du lien.
        return false;

    });

});
