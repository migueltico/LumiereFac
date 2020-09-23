//SE EJECUTA AL PRESIONAR ENTER EN EL INPUT DE BUSQUEDA EN INVENTARIO
$('#bodyContent').on("change", ".cantInputFact", function (e) {
    let tr = $(e.target).parent().parent().children()
    RefreshCalcTotalRowPrice(tr, 0)
    getSubTotalAndTotal()
})
$('#bodyContent').on("change", "#MultiTipoPagoFact", function (e) {
    const cb = document.getElementById('MultiTipoPagoFact');
    const InputSwitch = document.getElementsByClassName('fact_switchBtns');
    const InputRadio = document.getElementsByClassName('fact_rbRadiosBtns');
    if (cb.checked) {
        for (let i = 0; i < InputSwitch.length; i++) {
            InputSwitch[i].checked = false
            InputSwitch[i].style.display = "block"
            InputRadio[i].style.display = "none"

        }
    } else {
        InputRadio[0].checked = true
        for (let i = 0; i < InputSwitch.length; i++) {
            InputSwitch[i].checked = false
            InputSwitch[i].style.display = "none"
            InputRadio[i].style.display = "block"
            cb.style.display = "block"
        }
    }


})
$(window).keypress(function (e) {
    if (e.charCode == 17 && e.ctrlKey == true && $("#bodyFactMain").val() == 1) {
        $('#paginationModal').html('')
        $('#contentSearchFac').html('')
        $("#SearchProductModal").modal('toggle')

        let element = document.getElementById('SearchProductInputCtrlQ')
        element.focus();
    }
})
$("#bodyContent").on("click", "#btnCodigoBarrasModal", function (e) {
    $('#paginationModal').html('')
    $('#contentSearchFac').html('')
    $("#SearchProductModal").modal('toggle')

    let element = document.getElementById('SearchProductInputCtrlQ')
    element.focus();

})
$("#bodyContent").on("blur", ".cantInputFact", function (e) {
    if (this.value < 1) {
        this.value = 1
        let tr = $(e.target).parent().parent().children()
        RefreshCalcTotalRowPrice(tr, 0)
        getSubTotalAndTotal()
        Swal.fire({
            position: 'top',
            title: "Error en la cantidad",
            text: "La cantidad no puede ser 0 o una cantidad negativa, se cambia cantidad a 1 UND de. " + tr[1].innerText,
            icon: 'error',
            confirmButtonText: 'OK'
        })
    }

})
$("#bodyContent").on("change", ".cantInputFact", function (e) {

    if (this.value < 1) {
        this.value = 1
        let tr = $(e.target).parent().parent().children()
        RefreshCalcTotalRowPrice(tr, 0)
        getSubTotalAndTotal()
        Swal.fire({
            position: 'top',
            title: "Error en la cantidad",
            text: "La cantidad no puede ser 0 o una cantidad negativa, se cambia cantidad a 1 UND. " + tr[1].innerText,
            icon: 'error',
            confirmButtonText: 'OK'
        })
    }

})
$('#bodyContent').on("keypress", "#ScanCode", function (e) {
    if (e.charCode == 13) {
        getProductFact(e)
    }

})
$('#bodyContent').on("click", "#PrintFactBtn2", function (e) {

    let body = ''
    console.log("imprimir 1");
    fetch("/facturacion/facturaVenta", {
            method: "POST",
        }).then(resp => resp.text())
        .then(resp => {
            //$('#printContainer').html(resp)
            console.log("imprimir 2");
            let h = resp;
            let d = $("<div>").addClass("printContainer").html(h).appendTo("html");
            window.print();
            d.remove();
            console.log("imprimir 3");
        })





})

function getProductFact(e) {
    let element = document.getElementById('ScanCode')
    let toSearch = document.getElementById('ScanCode').value
    element.focus();
    element.setSelectionRange(0, toSearch.length);
    let resultCompare = existProductRow(toSearch)
    if (resultCompare == true) {
        let element = document.getElementById('productSearch')
        let formData = new FormData()
        formData.append("toSearch", toSearch)
        fetch("/facturacion/search/product", {
                method: "POST",
                body: formData
            }).then(resp => resp.json())
            .then(resp => {
                if (resp.data !== false) {
                    let data = resp.data
                    let descuento = (data.descuento == null ? 'N/A' : data.descuento + '%')
                    let des_descuento = (data.descuento_descripcion == null ? 'Sin Descuento' : data.descuento_descripcion)
                    let precios = calcTotalRowPrice(data.precio_venta, (data.descuento == null ? 0 : data.descuento), (data.activado_iva == 0 ? 0 : data.iva))
                    let row = /*html*/ `
                        <tr class="productRowFac" id="itemRowProduct_${data.idproducto}">
                            <td scope="row" data-id="${data.idproducto}" data-toggle="tooltip"data-placement="bottom" title="${data.idproducto}">${data.codigo}</td>
                            <td scope="row">${data.descripcion} | ${data.marca}</td>
                            <td scope="row">${data.talla}</td>
                            <td scope="row">${(data.activado_iva == 0 ? 0 : data.iva)}</td>
                            <td scope="row"><input type="number" min="1" class="cantInputFact" id="id_${data.idproducto}" style="width: 43px !important;text-align:center" name="" id="" value="1"></td>
                            <td scope="row">${data.precio_venta}</td>
                            <td scope="row" data-toggle="tooltip" data-descuento="${(data.descuento == null ? 0 : data.descuento)}" data-placement="bottom" title="${des_descuento}">${descuento}</td>
                            <td scope="row" class="productRowFac_subtotal">${precios[0]}</td>
                            <td scope="row" class="productRowFac_total">${precios[1]}</td>
                            <td scope="row"><button class="btn btn-danger removeItemProductBtn" data-id="${data.idproducto}">X</button></td>
                        </tr>
            `
                    $('#appendItemRowProduct').append(row)
                    getSubTotalAndTotal()

                } else {
                    Swal.fire({
                        position: 'top',
                        title: resp.msg,
                        text: resp.errorData.errorMsg[2],
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })
                }
            })
    } else {

        RefreshCalcTotalRowPrice(resultCompare, 1)
        getSubTotalAndTotal()

    }
    getSubTotalAndTotal()
}

function ConvertLabelFormat(amount) {
    let valor = amount;
    valor = valor
        .toFixed(2)
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    return valor
}

function roundHundred(value, rd1, rd2) {
    return Math.round(value / rd1) * rd2
}
$("#bodyContent").on("click", ".removeItemProductBtn", function (e) {
    console.log(e.target.dataset.id);
    removeItemProduct(e.target.dataset.id)
})

function removeItemProduct(id) {
    $(`#itemRowProduct_${id}`).remove()
    getSubTotalAndTotal()
}

function getSubTotalAndTotal() {
    let total = 1.00
    let cantRow = 0
    $(".productRowFac .productRowFac_total").each((i, element) => {
        let amount = $(element).text()
        total += parseFloat(amount)
        cantRow++
    })
    $("#CantidadFooterFact").text(`Cantidad de Lineas: ${cantRow}`)
    let numRound = roundHundred(total, 5, 5)
    let newFormat = ConvertLabelFormat(numRound)
    //console.log(newFormat);
    $("#totalFactAmount").text(newFormat)
    $("#lbMonto").val(newFormat)
    $("#lbMontoCard").val(newFormat)
}

function calcTotalRowPrice(precio, descuento, iva) {
    let descuentoPorcent = parseFloat(descuento / 100)
    let ivaPorcent = parseFloat(iva / 100)
    let precioVentaSub = parseFloat(precio - parseFloat(precio * descuentoPorcent))
    let TotaliVa = 0
    if (iva == 0) {
        TotaliVa = parseFloat(precioVentaSub)
    } else {

        TotaliVa = parseFloat(precioVentaSub + parseFloat(precioVentaSub * ivaPorcent))
    }


    return [precioVentaSub.toFixed(2), TotaliVa.toFixed(2)]
}

function RefreshCalcTotalRowPrice(tds, sum) {
    let cant = $(tds[4]).children().val()
    let total = parseInt(cant) + parseInt(sum)
    let precio = parseFloat($(tds[5]).text())
    let descuento = $(tds[6]).data('descuento')
    let descuento_porcentaje = 0
    let monto_reducir = 0
    let totalAll = 0
    if (descuento > 0) {
        descuento_porcentaje = parseFloat(descuento / 100)
    }
    monto_reducir = parseFloat(precio) * parseFloat(descuento_porcentaje)
    precio -= monto_reducir
    totalAll = parseFloat(precio) * parseInt(total)



    $(tds[4]).children('input').val(total)
    $(tds[7]).text(totalAll.toFixed(2))
    let ivaPercent = (parseInt($(tds[3]).text()) == 0 ? 1 : parseInt($(tds[3]).text()))
    if (ivaPercent > 0) {
        let iva = parseInt(ivaPercent) / 100
        let iva_sum = parseFloat(totalAll * iva)
        if (ivaPercent == 1) {
            iva = 1
            iva_sum = 0
        }
        let newTotal = parseFloat(totalAll + iva_sum)
        $(tds[8]).text(newTotal.toFixed(2))
    }
}

function existProductRow(toSearch) {
    let body = $("#appendItemRowProduct")[0]
    let body2 = document.getElementById('appendItemRowProduct')
    for (let item of body2.children) {
        let inner = item.children[0].innerText
        if (toSearch == inner) {
            // console.log(item.children[4]);
            return item.children
        }
    }
    return true
}

$('#bodyContent').on("keypress", "#SearchProductInputCtrlQ", function (e) {
    if (e.charCode == 13) {
        SearchProductModalFact(this.value, 1)

    }

})
$('#bodyContent').on("click", "#paginationModal .paginationBtn", function (e) {
    let valueInput = document.getElementById('SearchProductInputCtrlQ').value
    SearchProductModalFact(valueInput, this.dataset.page)



})
$('#bodyContent').on("click", "#paginationModalCliente .paginationBtn", function (e) {
    let valueInput = document.getElementById('SearchClient_input').value
    searchClient(valueInput, this.dataset.page)



})
$('#bodyContent').on("click", "#paginationModal .pre_nex", function (e) {
    let valueInput = document.getElementById('SearchProductInputCtrlQ').value

    SearchProductModalFact(valueInput, this.dataset.page)



})
$('#bodyContent').on("click", "#paginationModalCliente .pre_nexCliente", function (e) {
    let valueInput = document.getElementById('SearchClient_input').value

    searchClient(valueInput, this.dataset.page)



})
$('#bodyContent').on("click", ".codeToAddInputSearch", function (e) {
    $("#bodyContent #ScanCode").val(this.innerText)
    $("#SearchProductModal").modal('toggle')

    let element = document.getElementById('ScanCode')
    let toSearch = document.getElementById('ScanCode').value
    element.focus();
    element.setSelectionRange(0, toSearch.length);



})
$('#bodyContent').on("click", ".codeToAddInputSearchClient", function (e) {
    let id = e.target.dataset.id
    let name = e.target.dataset.name
    let inputCliente = document.getElementById("fac_cliente_input")
    inputCliente.value = name
    inputCliente.dataset.cliente = id

    $("#SearchClientModal").modal('toggle')



})
$('#bodyContent').on("click", "#fac_cliente", function (e) {
    clearBodySearchClient()
})

function clearBodySearchClient() {
    $('#contentSearchClient').html('')
    $('#paginationModalCliente').html('')
}

function SearchProductModalFact(toSearch, page) {
    let formData = new FormData()
    let initLimit = page

    formData.append("toSearch", toSearch)
    formData.append("initLimit", initLimit)
    fetch("/facturacion/search/product/ctrlq", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            $('#contentSearchFac').html('')
            let paginacion = resp.paginacion
            let items = `<li class="page-item pre_nex ${resp.previouspage <= 0? 'disabled' : ''}" data-minpage="1" data-page="${resp.previouspage <= 0 ? 1 : resp.previouspage}"><p class="page-link">Previous</p></li>`
            for (let index = 0; index < paginacion.paginas; index++) {
                let pageNow = index + 1
                items += `<li class="page-item paginationBtn ${pageNow == page? 'active' : ''}" data-page="${index+1}"><a class="page-link" href="#">${index+1}</a></li>`
                // console.log(items);
            }
            items += `<li class="page-item pre_nex ${resp.nextpage > paginacion.paginas ? 'disabled' : ''}" data-maxpage="${paginacion.paginas }" data-page="${resp.nextpage >= paginacion.paginas ? paginacion.paginas : resp.nextpage}"><p class="page-link">Next</p></li>`
            //console.log(resp);
            resp.data.map((el, i) => {
                let url = el.image_url.split(',')
                let producto = `    <div class="col-6">
                                        <div class="card mb-3" style="width: 100%;">
                                        <div class="row no-gutters">
                                            <div class="col-md-4 cardImgBody">
                                            <img src="${url[0]}" class="card-img" alt="...">
                                            </div>
                                            <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title">${el.descripcion}</h5>
                                                <p class="card-text">₡ ${el.precio_venta}</p>
                                                <div class="icon_codeToAddInputSearch"><p class="card-text codeToAddInputSearch">${el.codigo}</p></div>
                                                <p class="card-text"><small class="text-muted">Marca: ${el.marca} | Categoria: ${el.categoria}</small></p>
                                            </div>
                                            </div>
                                        </div>
                                    </div>                                
                                    </div>                                
              `

                $('#contentSearchFac').append(producto)
            })
            $('#paginationModal').html('')
            $('#paginationModal').html(items)
        })
}
$('#bodyContent').on("click", "#callModalAddClient", function (e) {
    $('#SearchClientModal').modal('hide')
    $('#clientes_addCliente').modal('toggle')
})
$('#bodyContent').on("keypress", "#SearchClient_input", function (e) {
    if (e.charCode == 13) {
        searchClient(this.value, 1);
    }

})

function searchClient(toSearch, page) {
    let formData = new FormData()
    let initLimit = page

    formData.append("toSearch", toSearch)
    formData.append("initLimit", initLimit)
    fetch("/clientes/search/searchclient", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            $('#contentSearchClient').html('')
            let paginacion = resp.paginacion
            let items = `<li class="page-item pre_nexCliente ${resp.previouspage <= 0? 'disabled' : ''}" data-minpage="1" data-page="${resp.previouspage <= 0 ? 1 : resp.previouspage}"><p class="page-link">Previous</p></li>`
            for (let index = 0; index < paginacion.paginas; index++) {
                let pageNow = index + 1
                items += `<li class="page-item paginationBtn ${pageNow == page? 'active' : ''}" data-page="${index+1}"><a class="page-link" href="#">${index+1}</a></li>`
                // console.log(items);
            }
            items += `<li class="page-item pre_nexCliente ${resp.nextpage > paginacion.paginas ? 'disabled' : ''}" data-maxpage="${paginacion.paginas }" data-page="${resp.nextpage >= paginacion.paginas ? paginacion.paginas : resp.nextpage}"><p class="page-link">Next</p></li>`
            //console.log(resp);
            resp.data.map((el, i) => {
                let cliente = `    <div class="col-6">
                                        <div class="card mb-2" style="width: 100%;">
                                        <div class="row no-gutters">                                           
                                            <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <div class="icon_codeToAddInputSearch"><p class="card-text codeToAddInputSearchClient" data-name="${el.nombre}"  data-id="${el.idcliente}">${el.nombre}</p></div>
                                                </h5>
                                                <p class="card-text">${el.email}</p>
                                            </div>
                                            </div>
                                        </div>
                                    </div>                                
                                    </div>                                
              `

                $('#contentSearchClient').append(cliente)
            })
            $('#paginationModalCliente').html('')
            $('#paginationModalCliente').html(items)
        })

}
// $('#bodyContent').on('click', '.tabItem a', function (e) {
//     console.log(e.target.dataset);
//     e.preventDefault()
//     let id = e.target.dataset.tabshow
//     alert(id)
// })