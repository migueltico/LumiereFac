$("#bodyContent").on("click", ".table.sort thead tr th", function () {
    let columnId = $(".table.sort thead tr th").index(this)
    let tipo = $(this).data('type')
    let inner = $(this).data('inner')
    let tbodyMain = $(this).parent().parent().next('tbody')
    let tbody = $(this).parent().parent().next('tbody').children()
    let sortr = $(tbodyMain).data('sorts')
    let result;
    if (!inner) {
        result = ordenarFila(columnId, tipo, sortr, tbody)
    } else {
        result = ordenarFilaByData(columnId, tipo, sortr, tbody)
    }
    console.log("Before",sortr);
    $(tbodyMain).html(result)
    if (sortr=='ASC') {
        $(tbodyMain).data('sorts', 'DESC')

    } else {
        $(tbodyMain).data('sorts', 'ASC')
    }
    console.log("After",$(tbodyMain).data('sorts'));
})
function hasClass(element, cls) {
    return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
}
function ordenarFila(columna, tipo, sortr, tr) {
    let rows;
    if (sortr=='ASC') {
        if (tipo == 1) {
            rows = tr.sort((a, b) => a.children[columna].innerText - b.children[columna].innerText);
        } else {
            rows = tr.sort((a, b) =>
                ("" + a.children[columna].innerText).localeCompare(b.children[columna].innerText)
            );
        }
    } else {
        if (tipo == 1) {
            rows = tr.sort((a, b) => b.children[columna].innerText - a.children[columna].innerText);
        } else {
            rows = tr.sort((a, b) =>
                ("" + b.children[columna].innerText).localeCompare(a.children[columna].innerText)
            );
        }
    }
    return rows
}

function ordenarFilaByData(columna, tipo, sortr, tr) {
    let rows;
    if (sortr=='ASC') {
        if (tipo == 1) {
            rows = tr.sort((a, b) => $(a.children[columna]).data("value") - $(b.children[columna]).data("value"));
        } else {
            rows = tr.sort((a, b) =>
                ("" + $(a.children[columna]).data("value")).localeCompare($(b.children[columna]).data("value"))
            );
        }
    } else {
        if (tipo == 1) {
            rows = tr.sort((a, b) => $(b.children[columna]).data("value") - $(a.children[columna]).data("value"));
        } else {
            rows = tr.sort((a, b) =>
                ("" + $(b.children[columna]).data("value")).localeCompare($(a.children[columna]).data("value"))
            );
        }
    }
    return rows
}