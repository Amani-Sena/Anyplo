//addList
function abrirModal($var) {
    const modal = document.getElementById($var)
    modal.classList.toggle('abrir')

    modal.addEventListener("click", (e) => {
        if(e.target.id == 'fechar' || e.target.id == $var || e.target.id == 'btn-cancel') {
            modal.classList.remove('abrir')
        }
    })
}

function abriraddList() {
    const list = document.getElementById('con-form-addList')
    list.classList.add('show')

    const cancel = document.getElementById('con-h-addLista')
    cancel.classList.add('hide')
}

function fecharaddList() {
    const list = document.getElementById('con-form-addList')
    list.classList.remove('show')

    const cancel = document.getElementById('con-h-addLista')
    cancel.classList.remove('hide')
}

// Dropdown Generos -------------------------------------------------------------------------------------

//Obter todos os dropdowns para o documento
const dropdown = document.querySelectorAll('.dropdown')

//Loop através de todos os elementos dropdown
dropdown.forEach(dropdown => {
    //Obter elementos interiores a partir de cada dropdown
    const select = dropdown.querySelector('.select');
    const caret = dropdown.querySelector('.caret');
    const menu = dropdown.querySelector('.menu');
    //const options = dropdown.querySelectorAll('.menu li');
   //const selected = dropdown.querySelector('.selected');
     
    //Acrescentar um evento de clique ao elemento seleccionado
    select.addEventListener('click', () => {
        //Acrescentar os estilos seleccionados clicados ao elemento seleccionado
        select.classList.toggle('select-clicked');
        //Acrescentar os estilos de rotação ao elemento de caret
        caret.classList.toggle('caret-rotate');
        //Acrescentar os estilos abertos ao elemento do menu
        menu.classList.toggle('menu-open');
    });
})


//Dropdown Editar
let click = document.querySelector('.click-edit');
let list = document.querySelector('.list-drop');
click.addEventListener("click",()=>{
    list.classList.toggle('dropdown-edit');
    click.classList.toggle('selected');
});
