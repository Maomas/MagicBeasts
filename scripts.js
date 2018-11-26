$(document).ready(function()
{
    $("#profileImage").mouseover(function(){
        $(this).css({'width' : '55px', 'height' : '55px'});
    });
    $("#profileImage").mouseout(function(){
        $(this).css({'width' : '50px' , 'height' : '50px'});
    });

    $("#panierImage").mouseover(function(){
        $(this).css({'width' : '45px', 'height' : '45px'});
    });
    $("#panierImage").mouseout(function(){
        $(this).css({'width' : '40px' , 'height' : '40px'});
    });

    $("#buttonFormEdition").click(function()
    {
        window.confirm("Si vous avez modifié votre adresse mail, vous serez déconnecté.");
    });
}
);