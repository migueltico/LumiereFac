$("#main_menu li a.btnSlideDown").click(function (e) {
    e.preventDefault();
    if ($(this).next('.listitems').hasClass('isDown')) {
        $('.listitems.isDown').slideToggle()
        $('.listitems').removeClass('isDown')
        $('.active').removeClass('active')
        $(this).removeClass('activeBtn')

    } else {
        $('.listitems.isDown').slideToggle()
        $('.listitems').removeClass('isDown')
        $('.activeBtn').removeClass('activeBtn')
        $(this).next('.listitems').slideToggle()
        $(this).next('.listitems').addClass('isDown')
        $(this).next('.listitems').addClass('active')
        $(this).addClass('activeBtn')
    }
})
$("#main_menu li.uniq_menu").click(function (e) {
    // e.preventDefault();
    //alert('aaa')


})
$("li.dataLink").click((e) => {
    loadPage(e, null)
})
$("li.redirectLink").click((e) => {
    window.location.replace(e.target.dataset.linkto);
})
$("#btn_menu_toggle").click((e) => {
    $(".lateral").toggle(100)
    let bodyMain = document.getElementById('bodyMain')
    bodyMain.style.width ='100%'
    //console.log('click');
})

$(".dataLink").click((e) => {
    let w = $(window).width()
    if (w <= 768) {
        $(".lateral").toggle(500)
    }
})
$(window).resize(function (e) {
    let w = $(window).width()
    if (w > 768) {
        $(".lateral").css({
            display: 'block'
        })
    }
});

function scrollToTop() {
    let BodyMain = document.getElementsByClassName('bodyMain')[0];
    if (BodyMain) {
        BodyMain.scrollTop = 0;
    }
}

function loadPage(e, link) {
    scrollToTop()
    localStorage.removeItem('saldo')
    let url = (link == null ? $(e.target).data('linkto') : link);
    let img = '<div class="loading"><img src="/public/assets/img/loading.gif"></div>';
    $(".bodyContent").html('')
    $(".bodyContent").append(img)
    fetch(url, {
            method: "POST"
        })
        .then((result) => result.text())
        .then((html) => {
            $(".bodyContent").html(html)
            let w = $(window).width()
            // if (w > 768) {
            //     $(".lateral").css({
            //         display: 'none'
            //     })
            // }
        })
        .catch((err) => {
            //console.log('error en FETCH:', err);
        });
}
//BORRAR ES TEMPORAL
function loadPage2(e) {
    scrollToTop()
    let img = '<div class="loading"><img src="/public/assets/img/loading.gif" alt="Loading..."></div>';
    $(".bodyContent").html('')
    $(".bodyContent").append(img)
    // let url = '/inventario/listarproductos';
    let url = '/dashboard/general';
    fetch(url, {
            method: 'POST'
        })
        .then((result) => result.text())
        .then((html) => {
            $(".bodyContent").html(html)

            // window['startChars']()
        })
        .catch((err) => {
            //console.log('error en FETCH:', err);
        });
}
$(document).ready(function () {
    //loadPage2()
})