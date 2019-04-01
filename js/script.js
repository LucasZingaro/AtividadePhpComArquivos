/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function ischeck(frm) {

    var check = document.getElementsByName("checkP[]");
    var cont = 0;
    if (check.length > 0) {
        for (var i = 0; i < check.length; i++) {
            if (check[i].checked == true) {
                cont++;
                frm.submit();
                return true;
            }
        }
        alert("Nenhum produto selecionado");
        return false;
    } else {
        alert("Nenhum produto cadastrado");
        return false;
    }

}