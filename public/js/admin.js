function requestCap(id1, id2) {
    var pesquisarCap = document.getElementById(id1).value;

    if(pesquisarCap != '' && pesquisarCap != '---') {

        let ajax = new XMLHttpRequest();
        ajax.open('GET', '/requestPartialAdmin?partial=select_cap&pesquisarCap=' + pesquisarCap);
        ajax.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    
        ajax.onreadystatechange = () => {
            if(ajax.readyState == 4 && ajax.status == 200) {
                document.getElementById(id2).innerHTML = ajax.responseText
                        
            } else if(ajax.readyState == 4 && ajax.status == 404) {
                document.getElementById(id2).innerHTML = 'Requisição 404'
                    
            }
        }
        ajax.send();

    }
}

function dropdown_admin(id) {
    var drop = document.getElementById(id);
    drop.classList.toggle('showHide_drop');
}

function abrirPartial(url_partial) {

    //incluir o gif de loading na página
    if(!document.getElementById('loading')) {
        let imgLoading = document.createElement("div")
        imgLoading.id = "loading"
        imgLoading.src = "img/mengif.gif"
        imgLoading.className = "loading-center"

        document.getElementById('admin-G').appendChild(imgLoading)
    }


    let ajax = new XMLHttpRequest();
                ajax.open('GET', url_partial);
                ajax.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    
                ajax.onreadystatechange = () => {
                    if(ajax.readyState == 4 && ajax.status == 200) {
                        document.getElementById('admin-G').innerHTML = ajax.responseText
                        
                    } else if(ajax.readyState == 4 && ajax.status == 404) {
                        document.getElementById('admin-G').innerHTML = 'Requisição 404'
                    
                    }
                }
                ajax.send();
}

function ImgPreview() {
    let filePath = document.getElementById('arquivoImg');
    let photoPath = document.getElementById('img-Path');
    

    filePath.addEventListener('change', () => {
    
        let reader = new FileReader();
    
        reader.onload = () => {
            photoPath.src = reader.result;
        }
    
        console.log(filePath.files[0])
    
        reader.readAsDataURL(filePath.files[0])
        
    })
    
    

}

function BgPreview() {

    let fileBg = document.getElementById('arquivoBg');
    let photoBg = document.getElementById('img-BG');

    fileBg.addEventListener('change', () => {
        let reader = new FileReader();
    
        reader.onload = () => {
            photoBg.src = reader.result;
        }
    
        console.log(fileBg.files[0])
    
        reader.readAsDataURL(fileBg.files[0])
        
    })
}


function requestPartial(url, con, con2) {
    
    if(document.getElementById(con2)) {
        document.getElementById(con2).innerHTML = ''
    }
    
    document.getElementById(con).innerHTML = ''
    //incluir o gif de loading na página
    if(!document.getElementById('loading')) {
        let imgLoading = document.createElement("div")
        imgLoading.id = "loading"
        imgLoading.src = "img/mengif.gif"
        imgLoading.className = "loading-center"

        document.getElementById(con).appendChild(imgLoading)
    }

    let ajax = new XMLHttpRequest();
    ajax.open('GET', url);
    ajax.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

    ajax.onreadystatechange = () => {
        if(ajax.readyState == 4 && ajax.status == 200) {
            document.getElementById(con).innerHTML = ajax.responseText
        } else if(ajax.readyState == 4 && ajax.status == 404) {
            document.getElementById(con).innerHTML = 'Requisição 404' 
        }
    }
    ajax.send();
}






