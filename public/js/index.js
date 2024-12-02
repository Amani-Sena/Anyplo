var swiper_home = new Swiper(".js-swiper-home", {
    direction: 'horizontal',
    effect: 'slide',
    loop: true,
    spaceBetween: 6,
    slidesPerView: 1,
    centeredSlides: true,
    autoplay: {
      delay: 6000,
      disableOnInteraction: false,
    },
    navigation: {
      nextEl: ".js-next-home",
      prevEl: ".js-prev-home",
    },
    
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


//Swiper Section

var swiper_section = new Swiper(".js-swiper-section", {
    loop: true,
    direction: 'horizontal',
    navigation: {
      nextEl: ".js-next-section",
      prevEl: ".js-prev-section",
    },
  
    // Responsive breakpoints
  breakpoints: {
    300: {
      slidesPerGroup: 2,
      slidesPerView: 2,
      spaceBetween: 6
    },
    // when window width is >= 820px
    720: {
      slidesPerGroup: 4,
      slidesPerView: 4,
      spaceBetween: 6
    },
  
    1150: {
      slidesPerGroup: 6,
      slidesPerView: 6,
      spaceBetween: 6 
    },
    // when window width is >= 1600px
    1600: {
      slidesPerGroup: 7,
      slidesPerView: 7,
      spaceBetween: 8
    },
    // when window width is >= 1600px
    1920: {
      slidesPerGroup: 8,
      slidesPerView: 8,
      spaceBetween: 14
    }
  
  }
  });
  
  
  var swiper_section = new Swiper(".js-swiper-section-2", {
    slidesPerView: 6,
    slidesPerGroup: 6,
    loop: true,
    direction: 'horizontal',
    navigation: {
      nextEl: ".js-next-section-2",
      prevEl: ".js-prev-section-2",
    },
  
    // Responsive breakpoints
  breakpoints: {
    300: {
      slidesPerGroup: 2,
      slidesPerView: 2,
      spaceBetween: 6
    },
    // when window width is >= 820px
    720: {
      slidesPerGroup: 4,
      slidesPerView: 4,
      spaceBetween: 6
    },
  
    1150: {
      slidesPerGroup: 6,
      slidesPerView: 6,
      spaceBetween: 6 
    },
    // when window width is >= 1600px
    1600: {
      slidesPerGroup: 7,
      slidesPerView: 7,
      spaceBetween: 8
    },
    // when window width is >= 1600px
    1920: {
      slidesPerGroup: 8,
      slidesPerView: 8,
      spaceBetween: 14
    }
  
  }
  });
  
  var swiper_section = new Swiper(".js-swiper-section-3", {
    slidesPerView: 6,
    slidesPerGroup: 6,
    loop: true,
    direction: 'horizontal',
    navigation: {
      nextEl: ".js-next-section-3",
      prevEl: ".js-prev-section-3",
    },
  
    // Responsive breakpoints
  breakpoints: {
    300: {
      slidesPerGroup: 2,
      slidesPerView: 2,
      spaceBetween: 6
    },
    // when window width is >= 820px
    720: {
      slidesPerGroup: 4,
      slidesPerView: 4,
      spaceBetween: 6
    },
  
    1150: {
      slidesPerGroup: 6,
      slidesPerView: 6,
      spaceBetween: 6 
    },
    // when window width is >= 1600px
    1600: {
      slidesPerGroup: 7,
      slidesPerView: 7,
      spaceBetween: 8
    },
    // when window width is >= 1600px
    1920: {
      slidesPerGroup: 8,
      slidesPerView: 8,
      spaceBetween: 14
    }
  
  }
  });
  
  var swiper_section = new Swiper(".js-swiper-section-4", {
    slidesPerView: 6,
    slidesPerGroup: 6,
    loop: true,
    direction: 'horizontal',
    navigation: {
      nextEl: ".js-next-section-4",
      prevEl: ".js-prev-section-4",
    },
  
    // Responsive breakpoints
  breakpoints: {
    300: {
      slidesPerGroup: 2,
      slidesPerView: 2,
      spaceBetween: 6
    },
    // when window width is >= 820px
    720: {
      slidesPerGroup: 4,
      slidesPerView: 4,
      spaceBetween: 6
    },
  
    1150: {
      slidesPerGroup: 6,
      slidesPerView: 6,
      spaceBetween: 6 
    },
    // when window width is >= 1600px
    1600: {
      slidesPerGroup: 7,
      slidesPerView: 7,
      spaceBetween: 8
    },
    // when window width is >= 1600px
    1920: {
      slidesPerGroup: 8,
      slidesPerView: 8,
      spaceBetween: 14
    }
  
  }
  });
  
  