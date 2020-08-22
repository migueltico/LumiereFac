//SE EJECUTA AL PRESIONAR ENTER EN EL INPUT DE BUSQUEDA EN INVENTARIO
$('#bodyContent').on("change", ".cantInputFact", function (e) {
    let tr = $(e.target).parent().parent().children()
    RefreshCalcTotalRowPrice(tr, 0)
    getSubTotalAndTotal()
})
$(window).keypress(function (e) {
    if (e.charCode == 17 && e.ctrlKey == true && $("#bodyFactMain").val() == 1) {
        $("#SearchProductModal").modal('toggle')

        let element = document.getElementById('SearchProductInputCtrlQ')
        element.focus();
    }
})
$('#bodyContent').on("keypress", "#ScanCode", function (e) {
    if (e.charCode == 13) {
        getProductFact(e)
    }

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
                    let row = `
                        <tr class="productRowFac">
                            <td scope="row" data-id="${data.idproducto}" data-toggle="tooltip"data-placement="bottom" title="${data.idproducto}">${data.codigo}</td>
                            <td scope="row">${data.descripcion} | ${data.marca}</td>
                            <td scope="row">${data.talla}</td>
                            <td scope="row">${(data.activado_iva == 0 ? 0 : data.iva)}</td>
                            <td scope="row"><input type="number" min="1" class="cantInputFact" id="id_${data.idproducto}" style="width: 43px !important;text-align:center" name="" id="" value="1"></td>
                            <td scope="row">${data.precio_venta}</td>
                            <td scope="row" data-toggle="tooltip" data-descuento="${(data.descuento == null ? 0 : data.descuento)}" data-placement="bottom" title="${des_descuento}">${descuento}</td>
                            <td scope="row" class="productRowFac_subtotal">${precios[0]}</td>
                            <td scope="row" class="productRowFac_total">${precios[1]}</td>
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
    //console.log("amount:", amount);
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

function getSubTotalAndTotal() {
    let total = 1.00
    let cantRow = 0
    $(".productRowFac .productRowFac_total").each((i, element) => {
        let amount = $(element).text()
        total += parseFloat(amount)
        cantRow++
    })
    $("#CantidadFooterFact").text(`Cantidad: ${cantRow}`)
    let numRound = roundHundred(total, 5, 5)
    let newFormat = ConvertLabelFormat(numRound)
    //console.log(newFormat);
    $("#totalFactAmount").text(newFormat)
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
        SearchProductModalFact(this.value)
        console.log(this.value)
    }

})


function SearchProductModalFact(toSearch) {
    let formData = new FormData()
    let initElement = document.getElementById('paginationModal')
    let initLimit = initElement.dataset.init
    console.log(initLimit);
    formData.append("toSearch", toSearch)
    formData.append("initLimit", initLimit)
    fetch("/facturacion/search/product/ctrlq", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            $('#contentSearchFac').html('')
            let paginacion = resp.paginacion
            console.log(resp);
            let items = '<li class="page-item" data-page="1"><a class="page-link" href="#">Previous</a></li>'
            for (let index = 0; index < paginacion.paginas; index++) {
                items += `<li class="page-item" data-page="${index+1}"><a class="page-link" href="#">${index+1}</a></li>`
                // console.log(items);
            }
            items += `<li class="page-item" data-page="5"><a class="page-link" href="#">Next</a></li>`
            //console.log(resp);

            resp.data.map((el, i) => {
                console.log(el, i);
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
                                                <p class="card-text"><strong>${el.codigo}<strong></p>
                                                <p class="card-text"><small class="text-muted">Marca: ${el.marca} | Categoria: ${el.categoria}</small></p>
                                            </div>
                                            </div>
                                        </div>
                                    </div>                                
                                    </div>                                
              `

                $('#contentSearchFac').append(producto)
            })
            $('#paginationModal').html(items)
        })
}