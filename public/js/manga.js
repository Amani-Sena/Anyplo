function addRow(url, url_partial, con) {

    fetch(url, {
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
            ajax.open('GET', url_partial);
            ajax.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

            ajax.onreadystatechange = () => {
                if(ajax.readyState == 4 && ajax.status == 200) {
                    document.getElementById(con).innerHTML = ajax.responseText
                    
                } else if(ajax.readyState == 4 && ajax.status == 404) {
                    document.getElementById(con).innerHTML = 'Requisição 404'
                
                }
            }
        ajax.send();

        ativar('Fila atualizada com sucesso!');

}

function createList(url, url_partial) {
    
    let form = document.querySelector("#form_addlist");

    form.addEventListener("submit", async(event) => {

        event.preventDefault();

        const dadosForm =  new FormData(form);

        const dados = await fetch(url, {
            method: "POST",
            body: dadosForm
        });
        
            const resp = await dados.json();

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
                ajax.open('GET', url_partial);
                ajax.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    
                ajax.onreadystatechange = () => {
                    if(ajax.readyState == 4 && ajax.status == 200) {
                        document.getElementById('janela-modal-addList').innerHTML = ajax.responseText
                        
                    } else if(ajax.readyState == 4 && ajax.status == 404) {
                        document.getElementById('janela-modal-addList').innerHTML = 'Requisição 404'
                    
                    }
                }
                ajax.send();

                let modal = document.getElementById('janela-modal-addList')
                modal.classList.remove('abrir')

        ativar(resp['msg']);
    
    });
}

function addList(url, url_partial) {

    fetch(url, {
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
            ajax.open('GET', url_partial);
            ajax.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

            ajax.onreadystatechange = () => {
                if(ajax.readyState == 4 && ajax.status == 200) {
                    document.getElementById('janela-modal-addList').innerHTML = ajax.responseText
                    
                } else if(ajax.readyState == 4 && ajax.status == 404) {
                    document.getElementById('janela-modal-addList').innerHTML = 'Requisição 404'
                
                }
            }
        ajax.send();

        let modal = document.getElementById('janela-modal-addList')
        modal.classList.remove('abrir')

        ativar('Lista atualizada com sucesso!');
    
}

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

var stars = document.querySelectorAll(".star-icon");

document.addEventListener("click", function(e){
    var classStar = e.target.classList;
    if(!classStar.contains("ativo")) {
        stars.forEach(function(star){
            star.classList.remove("ativo");
        });
        classStar.add("ativo");
        
    }
});


function aval(url) {
    
            fetch(url, {
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

                ativar('Avaliação enviada com sucesso!');
            
}