var swiper = new Swiper(".mySwiper", {
    pagination: {
      el: ".swiper-pagination",
      type: "progressbar",
    },
    navigation: {
      nextEl: ".next-chapter",
      prevEl: ".prev-chapter",
    },
    spaceBetween: 2,
    keyboard: {
      enabled: true,
    },
    keyboard: true
});


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

function MudarLei($ori) {
    if($ori == 'H') {
        $con = document.querySelector('.con-leiV');
        $con2 = document.querySelector('.con-leiH');

        $con2.classList.remove('show-leitura'); 
        $con.classList.add('hide-leitura');
        $con2.classList.remove('hide-leitura'); 
        $con2.classList.toggle('show-leitura');

        $btn = document.querySelector('.btn-lei');
        $btn.innerHTML = "Leitura Vertical";
        $btn.setAttribute("onclick", "MudarLei('V')");
    } 

    if($ori == 'V') {
        $con = document.querySelector('.con-leiH');
        $con2 = document.querySelector('.con-leiV');

        $con2.classList.remove('show-leitura'); 
        $con.classList.add('hide-leitura');
        $con2.classList.remove('hide-leitura'); 
        $con2.classList.toggle('show-leitura');

        $btn = document.querySelector('.btn-lei');
        $btn.innerHTML = "Leitura Horizontal";
        $btn.setAttribute("onclick", "MudarLei('H')");
    }
}

//dropdown chapter
function dropC() {
    $con = document.querySelector('#con-chaptersT');

    $con.classList.toggle('show-chapters');
}


    
    