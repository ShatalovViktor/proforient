function loadSchools(){
    var sel = document.getElementById("rayon"); // Получаем наш список
    var nameRayon = sel.options[sel.selectedIndex].text;
    var sel = document.getElementById("access"); // Получаем наш список
    var valAccess = sel.value;
    if (valAccess==3){
        $.ajax({
            type: "POST",
            url: "js/ajax/loadSchools.php",
            data: "nameRayon="+nameRayon,
            success: function(data){
                $("#show_schools").html(data);
            }
        });
    }
}


function mtRand(min, max)
{
    var range = max - min + 1;
    var n = Math.floor(Math.random() * range) + min;
    return n;
}

//генератор паролей
function showPass()
{
    var pass=document.getElementById("passwd");
    pass.value=mkPass(mtRand(10, 14));
}

function mkPass(len)
{
    var len=len?len:14;
    var pass = "";
    var rnd = 0;
    var c = "";
    for (i = 0; i < len; i++) {
        rnd = mtRand(0, 2); // Латиница или цифры
        if (rnd == 0) {
            c = String.fromCharCode(mtRand(48, 57));
        }
        if (rnd == 1) {
            c = String.fromCharCode(mtRand(65, 90));
        }
        if (rnd == 2) {
            c = String.fromCharCode(mtRand(97, 122));
        }
        pass += c;
    }
    return pass;
}



function loadRayon(){
    var sel = document.getElementById("access"); // Получаем наш список
    var valAccess = sel.value;
    if (valAccess!=1)
    {
    document.getElementById("show_rayon").style.display="block";

    }

}

