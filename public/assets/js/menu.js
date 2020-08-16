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
    loadPage(e)
})

function loadPage(e) {
    let url = $(e.target).data('linkto');
    let img = '<div class="loading"><img src="/public/assets/img/loading.gif"></div>';
    $(".bodyContent").html('')
    $(".bodyContent").append(img)
    fetch(url, {
            method: 'POST'
        })
        .then((result) => result.text())
        .then((html) => {
            $(".bodyContent").html(html)
        })
        .catch((err) => {
            console.log('error en FETCH:', err);
        });
}
//BORRAR ES TEMPORAL
function loadPage2() {
    let img = '<div class="loading"><img src="/public/assets/img/loading.gif" alt="Loading..."></div>';
    $(".bodyContent").html('')
    $(".bodyContent").append(img)
   // let url = '/inventario/listarproductos';
    let url = '/inventario/addstock';
    fetch(url, {
            method: 'POST'
        })
        .then((result) => result.text())
        .then((html) => {
            $(".bodyContent").html(html)
        })
        .catch((err) => {
            console.log('error en FETCH:', err);
        });
}
$(document).ready(function () {
    loadPage2()
})