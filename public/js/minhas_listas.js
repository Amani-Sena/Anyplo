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

function deleteHist(url, url_partial) {
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
    ajax.open('GET', url_partial);
    ajax.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

    ajax.onreadystatechange = () => {
        if(ajax.readyState == 4 && ajax.status == 200) {
            document.getElementById('con-list').innerHTML = ajax.responseText
            
        } else if(ajax.readyState == 4 && ajax.status == 404) {
            document.getElementById('con-list').innerHTML = 'Requisição 404'
          
        }
    }
    ajax.send();

    ativar('Histórico Deletado com Sucesso!');
}

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


let click_mylista = document.querySelector('#btn-lista');
            click_mylista.addEventListener("click",()=>{
                let des = document.querySelector('#btn-fila');
                let des2 = document.querySelector('#btn-hist');
                click_mylista.classList.add('selected-list');
                des.classList.remove('selected-list');
                des2.classList.remove('selected-list');
            });

            let click_myfila = document.querySelector('#btn-fila');
            click_myfila.addEventListener("click",()=>{
                let des = document.querySelector('#btn-lista');
                let des2 = document.querySelector('#btn-hist');
                click_myfila.classList.add('selected-list');
                des.classList.remove('selected-list')
                des2.classList.remove('selected-list')
            });

            let click_myhist = document.querySelector('#btn-hist');
            click_myhist.addEventListener("click",()=>{
                let des = document.querySelector('#btn-lista');
                let des2 = document.querySelector('#btn-fila');
                click_myhist.classList.add('selected-list');
                des.classList.remove('selected-list')
                des2.classList.remove('selected-list')
            });


            //Abrir Modal Add List
            function abrirModal($var) {
                const modal = document.getElementById($var)
                modal.classList.toggle('abrir')

                modal.addEventListener("click", (e) => {
                    if(e.target.id == 'fechar' || e.target.id == $var || e.target.id == 'btn-cancel') {
                        modal.classList.remove('abrir')
                    }
                })
            }

            //Criar Lista
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
                                    document.getElementById('con-lists').innerHTML = ajax.responseText
                                    
                                } else if(ajax.readyState == 4 && ajax.status == 404) {
                                    document.getElementById('con-lists').innerHTML = 'Requisição 404'
                                
                                }
                            }
                            ajax.send();
            
                            let modal = document.getElementById('janela-modal-addList')
                            modal.classList.remove('abrir')
            
                    ativar(resp['msg']);
                
                });
            }