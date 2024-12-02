function editList(url, url_partial) {
    let form = document.querySelector("#form_edit");

    form.addEventListener("submit", async(event) => {

        event.preventDefault();

        const dadosForm =  new FormData(form);

        const dados = await fetch(url, {
            method: "POST",
            body: dadosForm
        });

            const resp = await dados.json();
            console.log(resp);

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
                        document.getElementById('h-title-home_list').innerHTML = ajax.responseText
                        
                    } else if(ajax.readyState == 4 && ajax.status == 404) {
                        document.getElementById('h-title-home_list').innerHTML = 'Requisição 404'
                    
                    }
                }
                ajax.send();

                let modal = document.getElementById('janela-modal-edit')
                modal.classList.remove('abrir')

        ativar(resp['msg']);
    });
}

function abrirModal($var) {
    const modal = document.getElementById($var)
    modal.classList.toggle('abrir')

    modal.addEventListener("click", (e) => {
        if(e.target.id == 'fechar' || e.target.id == $var || e.target.id == 'btn-cancel') {
            modal.classList.remove('abrir')
        }
    })
}

//dropdown edit
function dropE() {
    $con = document.querySelector('.list-drop');

    $con.classList.toggle('list-drop-show');
}