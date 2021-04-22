$(document).ready(() => {
    $('#ajouter').click((e) => {
        $bool = true;
        var nom = document.forms["form"];

     if ($('#categorie_nom').val() == "") {
            $('#catN').show();
            $bool = false;
        } else {
            $('#catN').hide();
        }

        if ($bool) {
            $(this).unbind(e);
        } else {
            e.preventDefault();
        }
    })

    $("#categorie_nom").keyup(function(){
        $('#catN').hide();
    });


})