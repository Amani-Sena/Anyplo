function requestPartial(url, con, con2) {
    
    if(document.getElementById(con2)) {
        document.getElementById(con2).innerHTML = ''
    }
    
    document.getElementById(con).innerHTML = ''
    //incluir o gif de loading na página
    if(!document.getElementById('loading')) {
        let imgLoading = document.createElement("img")
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


function pesquisar() {

    var pesquisaValor = document.getElementById('pesquisarPor').value

    if(pesquisaValor != '') {

        document.getElementById('con_card-search').innerHTML = ''
        //incluir o gif de loading na página
        if(!document.getElementById('loading')) {
            let imgLoading = document.createElement("img")
            imgLoading.id = "loading"
            imgLoading.src = "img/mengif.gif"
            imgLoading.className = "loading-center"

            document.getElementById('con_card-search').appendChild(imgLoading)
        }

        let ajax = new XMLHttpRequest();
        ajax.open('GET', '/requestPartial?partial=con_pesquisar&pesquisarPor=' + pesquisaValor);
        ajax.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    
        ajax.onreadystatechange = () => {
            if(ajax.readyState == 4 && ajax.status == 200) {
                document.getElementById('con_card-search').innerHTML = ajax.responseText
                        
            } else if(ajax.readyState == 4 && ajax.status == 404) {
                document.getElementById('con_card-search').innerHTML = 'Requisição 404'
                    
            }
        }
        ajax.send();

    }

}