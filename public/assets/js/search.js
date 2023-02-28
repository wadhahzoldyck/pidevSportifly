// Attendez que la page soit chargée
$(document).ready(function() {

    // Écoutez l'événement de soumission du formulaire de recherche
    $('#search-form').submit(function(event) {

        // Empêcher le formulaire de se soumettre normalement
        event.preventDefault();

        // Récupérer la chaîne de recherche de l'entrée utilisateur
        var query = $('#search').val();

        // Envoyer une requête AJAX pour récupérer les résultats de la recherche
        $.ajax({
            url: '/search',
            type: 'POST',
            data: { query: query },
            success: function(results) {
                // Mettre à jour le contenu de la page avec les résultats de la recherche
                $('#search').html(results);
            },
            error: function() {
                alert('Une erreur s\'est produite lors de la recherche');
            }
        });

    });

});
