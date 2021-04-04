var t = document.querySelector('.navbar-nav')
var menu = [];
for (i=1;i<t.childElementCount;i++) { menu.push(t.children[i]) }

function removeMenu() {
    for (i=t.childElementCount-1;i>0;i--) { t.children[i].remove();}
}
// Por enquanto não está sendo utilizado
function enableMenu() {
    for (i=0;i<menu.length;i++) { t.append(menu[i]); }
}


