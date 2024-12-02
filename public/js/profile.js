function updateIcone(url) {

    fetch(url, {
        method: "GET"
    })

    const divMessage = document.querySelector(".alert")

    function ativar(msg) {
        const message = document.createElement('div');
        message.classList.add('message');
        message.innerText = msg;
        divMessage.appendChild(message);

        setTimeout(() => {
            message.style.display = 'none';
        }, 3000);
    }

    let ajax = new XMLHttpRequest();
    ajax.open('GET', '/requestPartial?partial=user_icon');
    ajax.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

    ajax.onreadystatechange = () => {
        if(ajax.readyState == 4 && ajax.status == 200) {
            document.getElementById('con-img-profile').innerHTML = ajax.responseText
            
        } else if(ajax.readyState == 4 && ajax.status == 404) {
            document.getElementById('con-img-profile').innerHTML = 'Requisição 404'
          
        }
    }
    ajax.send();

    let ajaxAlt = new XMLHttpRequest();
    ajaxAlt.open('GET', '/requestPartial?partial=user_icon_header');
    ajaxAlt.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

    ajaxAlt.onreadystatechange = () => {
        if(ajaxAlt.readyState == 4 && ajaxAlt.status == 200) {
            document.getElementById('header-profile').innerHTML = ajaxAlt.responseText
            
        } else if(ajaxAlt.readyState == 4 && ajaxAlt.status == 404) {
            document.getElementById('header-profile').innerHTML = 'Requisição 404'
          
        }
    }
    ajaxAlt.send();

    let modal = document.getElementById('janela-modal-icones')
    modal.classList.remove('abrir')

    ativar('Icone alterado com sucesso!');

}

function updateBack(url) {

fetch(url, {
    method: "GET"
})

const divMessage = document.querySelector(".alert")

function ativar(msg) {
    const message = document.createElement('div');
    message.classList.add('message');
    message.innerText = msg;
    divMessage.appendChild(message);

    setTimeout(() => {
        message.style.display = 'none';
    }, 3000);
}

let ajax = new XMLHttpRequest();
ajax.open('GET', '/requestPartial?partial=user_bg');
ajax.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

ajax.onreadystatechange = () => {
    if(ajax.readyState == 4 && ajax.status == 200) {
        document.getElementById('img-ban-profile').innerHTML = ajax.responseText
        
    } else if(ajax.readyState == 4 && ajax.status == 404) {
        document.getElementById('img-ban-profile').innerHTML = 'Requisição 404'
      
    }
}
ajax.send();

let modal = document.getElementById('janela-modal-bg')
modal.classList.remove('abrir')

ativar('Background alterado com sucesso!');

}

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



function mudarLei() {
    var lei = document.getElementById('leitura').value

    if(lei != '') {

        fetch('/updateLei?leitura=' + lei, {
            method: "GET"
        });

        const divMessage = document.querySelector(".alert")
                
        function ativar(msg) {
            const message = document.createElement('div');
            message.classList.add('message');
            message.innerText = msg;
            divMessage.appendChild(message);
    
            setTimeout(() => {
                message.style.display = 'none';
            }, 3000);
        }

        ativar('Leitura Atualizada com sucesso!');
    }
}

function mudarTitle() {
    var title = document.getElementById('titulo').value

    if(title != '') {

        fetch('/updateTitle?titulo=' + title, {
            method: "GET"
        });

        const divMessage = document.querySelector(".alert")
                
        function ativar(msg) {
            const message = document.createElement('div');
            message.classList.add('message');
            message.innerText = msg;
            divMessage.appendChild(message);
    
            setTimeout(() => {
                message.style.display = 'none';
            }, 3000);
        }

        let ajax = new XMLHttpRequest();
                ajax.open('GET', '/requestPartial?partial=title');
                ajax.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    
                ajax.onreadystatechange = () => {
                    if(ajax.readyState == 4 && ajax.status == 200) {
                        document.getElementById('name-profile').innerHTML = ajax.responseText
                    } else if(ajax.readyState == 4 && ajax.status == 404) {
                    document.getElementById('name-profile').innerHTML = 'Requisição 404'
                    }
                }
            ajax.send();

        ativar('Título Atualizado com Sucesso!');
    }
}

function mudarClass() {
    
    var classi = document.getElementById('switch-input').checked;

    console.log(classi)

        if(classi == true) {
            var classiF = 1;
        } else {
            var classiF = 0;
        }

        fetch('/updateClass?class=' + classiF, {
            method: "GET"
        });

    const divMessage = document.querySelector(".alert")
                
        function ativar(msg) {
            const message = document.createElement('div');
            message.classList.add('message');
            message.innerText = msg;
            divMessage.appendChild(message);
    
            setTimeout(() => {
                message.style.display = 'none';
            }, 3000);
        }

        ativar('Classificação Atualizada com Sucesso!');
}
