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

    $(".cardHeaderSwitch").removeClass('selectedMethodPay')
    let pago = document.getElementById("pagoContraEntrega").checked
    if (!pago) {
        if (cb.checked) {
            $('.lbMontoToPay').prop('disabled', false)
            $(".lbMontoToPay").val('0.00')
            for (let i = 0; i < InputSwitch.length; i++) {
                InputSwitch[i].checked = false
                InputSwitch[i].style.display = "block"
                InputRadio[i].style.display = "none"

            }
        } else {
            let amounts = document.getElementById('totalFactAmount')
            $(".lbMontoToPay").val(amounts.dataset.amount)
            $(".cardHeaderSwitch").first().addClass('selectedMethodPay')
            $(".fact_switchBtns input[type='checkbox").prop("checked", false)
            $('.lbMontoToPay').prop('disabled', true)
            InputRadio[0].checked = true
            for (let i = 0; i < InputSwitch.length; i++) {
                InputSwitch[i].checked = false
                InputSwitch[i].style.display = "none"
                InputRadio[i].style.display = "block"
                cb.style.display = "block"
            }
        }
    }


})
$("#bodyContent").on("change", "#pagoContraEntrega", function (e) {
    let tr = document.getElementById("appendItemRowProduct")
    let Multi = document.getElementById("MultiTipoPagoFact").checked
    let count = tr.getElementsByTagName("tr")
    console.log(Multi);
    if (Multi && this.checked) {
        $(".lbMontoToPay").prop("disabled", true)
    } else {
        $(".lbMontoToPay").prop("disabled", false)
    }
    if (this.checked && count.length > 0) {
        $("#btnMakeFact").prop("disabled", false)
        $(".lbMontoToPay").prop("disabled", true)
        $(".lbMontoToPay").val("0.00")
    } else if (count.length > 0) {
        $("#btnMakeFact").prop("disabled", false)
        $(".lbMontoToPay").prop("disabled", false)
    } else {
        $("#btnMakeFact").prop("disabled", true)

    }
})
$("#bodyContent").on("click", "#PrintFactBtn", function (e) {
    let tr = document.getElementById("appendItemRowProduct")
    let count = tr.getElementsByTagName("tr")
    if (count.length == 0) {
        Swal.fire({
            position: 'top',
            title: '',
            text: "Asegurese de tener algun producto a facturar",
            icon: 'error',
            confirmButtonText: 'OK',
            timer: 2500,
            timerProgressBar: true
        })
        $("#btnMakeFact").prop("disabled", true)
    }
    let btn_Envio = document.getElementById("btnTypeEnvio")
    let btnApartado = document.getElementById("btnTypeApartado")
    let btn_pagoContraEntrega = document.getElementById("pagoContraEntregaContainer")
    let pagoContraEntrega = document.getElementById("pagoContraEntrega")
    pagoContraEntrega.checked = false
    $(".tarjertaInputs_tarjeta").val('')
    $(".transferenciaInputs_referencia").val('')
    $(".transferenciaInputs_banco").val(0)
    console.log();
    if (hasClass(btn_Envio, "active")) {
        btn_pagoContraEntrega.style.display = "block"
    } else {
        btn_pagoContraEntrega.style.display = "none"
    }

    let amount = document.getElementsByClassName("totalFactAmount")[0]
    let btn = document.getElementById('btnMakeFact')
    let amountFloat = parseFloat(amount.dataset.amount.replace(",", ""))
    if (amountFloat > 0.00) {
        $(btn).prop("disabled", false)
    } else {
        $(btn).prop("disabled", true)
    }
    if (hasClass(btnApartado, "active")) {
        $('.lbMontoToPay').prop('disabled', false)
        $('.lbMontoToPay').val('0.00')
    } else {
        $('.lbMontoToPay').prop('disabled', true)
    }
})
$("#bodyContent").on("click", "#group_type_fac .btn", function (e) {
    console.log("CLICK");
    $("#group_type_fac .btn").removeClass("active")
    $("#group_type_fac .btn").removeClass("btn-primary")
    $("#group_type_fac .btn").addClass("btn-info")
    $(this).removeClass("btn-info")
    $(this).addClass("btn-primary")
    $(this).addClass("active")
})

function resetFactScreen() {
    // let totalFactAmount = document.getElementById("totalFactAmount")
    // let cliente = document.getElementById("fac_cliente_input")
    // let ScanCode = document.getElementById("ScanCode")
    // totalFactAmount.dataset.amount = 0.00
    // totalFactAmount.innerHTML = 0.00
    // cliente.dataset.cliente = 0
    // cliente.value = "Generico"
    // ScanCode.value = ""
    //Resetea los botones de local envio o apartado
    // $("#group_type_fac .btn").removeClass("active")
    // $("#group_type_fac .btn").removeClass("btn-primary")
    // $("#group_type_fac .btn").addClass("btn-info")
    // $("#group_type_fac .btn").first().addClass("btn-primary")
    // $("#group_type_fac .btn").first().removeClass("btn-info")
    $(`.modal-backdrop`).remove()
    loadPage(null, "facturacion/facturar")
}
$('#bodyContent').on("click", "#btnMakeFact", function (e) {
    //ANCLA
    e.preventDefault();
    const cb = document.getElementById('MultiTipoPagoFact');
    let pagoContraEntrega = document.getElementById('pagoContraEntrega').checked;
    pagoContraEntrega = (pagoContraEntrega ? 0 : 1)
    if (cb.checked) {
        let method = PagoMultipleFac(pagoContraEntrega)
        console.log("JSON", method);
        if (method.state) {
            getProductsRowsForFac(method.methodsArray, pagoContraEntrega)
        }
    } else {
        let method = PagoUnicoFac()
        //let isOk = true
        console.log("JSON", method);
        // method.map(e => (e.state == false ? isOk = true : isOk = false))
        if (method[0].state) {
            getProductsRowsForFac(method, pagoContraEntrega)
        } else if (pagoContraEntrega.checked) {

        }


    }
})

function convertToFacNumber() {
    ConvertLabelFormat(111)
}

function getProductsRowsForFac(method, pago) {
    let rows = document.getElementsByClassName('productRowFac')
    let amounts = document.getElementById('totalFactAmount').dataset.amount
    let idCliente = document.getElementById('fac_cliente_input').dataset.cliente
    let nameCliente = document.getElementById('fac_cliente_input').value
    let idVendedor = document.getElementById('InputVendedorFact').dataset.vendedor
    let nameVendedor = document.getElementById('InputVendedorFact').value
    let itemsFac = []
    let gran_subtotal = 0.00
    let gran_subtotal_descuento = 0.00
    let methodPay = method
    let cantidadArticulos = 0
    let ivaMonto = 0.00
    for (let row of rows) {
        let id = row.children[0].dataset.id
        let descripcion = row.children[1].textContent
        let talla = row.children[2].textContent
        let cantidad = parseInt(row.children[4].children[0].value)
        let iva = (row.children[3].textContent > 0 ? row.children[3].textContent : 0)
        let precio = ConvertLabelFormat(parseFloat(row.children[6].textContent))
        let subtotal = ConvertLabelFormat(parseFloat(row.children[8].textContent))
        let total_iva = ConvertLabelFormat(parseFloat(row.children[9].textContent))

        let descuento = (row.children[7].textContent !== "N/A" ? row.children[7].textContent : 0)
        cantidadArticulos += cantidad
        let json = {
            id,
            descripcion,
            talla,
            cantidad,
            iva: iva,
            descuento,
            precio,
            subtotal,
            total_iva
        }
        gran_subtotal_descuento += parseFloat(row.children[8].textContent)
        gran_subtotal += parseFloat(row.children[6].textContent) * parseInt(cantidad)
        itemsFac.push(json)

    }
    if (itemsFac.length == 0) {

        itemsFac = 0
    }
    let Okprint = document.getElementById('SendFactBoolean');
    let tipoVenta = parseInt($("#group_type_fac .active").data("tipo"))
    let finalJson = {
        items: itemsFac,
        total: amounts,
        subtotal_descuento: ConvertLabelFormat(gran_subtotal_descuento),
        descuento: ConvertLabelFormat((gran_subtotal - gran_subtotal_descuento)), // precio sin descuento menos precio con descuento
        iva: ConvertLabelFormat((parseFloat(amounts.replace(",", "")) - gran_subtotal_descuento)),
        idCliente,
        nameCliente,
        idVendedor,
        nameVendedor,
        methodPay,
        cantidadArticulos,
        tipoVenta,
        sendFac: (Okprint.checked ? 1 : 0),
        estado: (tipoVenta == 1 ? 1 : 0),
        hasPay: pago
    }
    console.log(finalJson);
    printFact(finalJson)
}


function PagoUnicoFac() {
    let InputsRadio = document.querySelectorAll(".fact_rbRadiosBtns")

    for (let input of InputsRadio) {
        if (input.checked) {
            let inputClass = input.dataset.inputval
            let result = verificaCamposPago(inputClass)
            if (result.state) {
                return [result]
            } else {
                Swal.fire({
                    position: 'top',
                    title: 'Campos Incompletos',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    timer: 2500,
                    timerProgressBar: true
                })
                return [result]
            }
        }
    }
}

function PagoMultipleFac(pago) {
    let montoToPay = document.getElementsByClassName("lbMontoToPay")
    let amounts = document.getElementById('totalFactAmount').dataset.amount
    let Allswitch = document.getElementsByClassName('switchGroupAmount')
    let finalAmount = 0.00
    let result;
    let methodsArray = []
    for (let switchItem of Allswitch) {
        if (switchItem.checked) {
            let itemId = switchItem.dataset.inputval
            result = verificaCamposPago(itemId)
            if (result.state) {
                let monto = document.getElementsByClassName(`${itemId}_monto`)[0].value
                //console.log(monto);
                let valor = monto
                //console.log(valor);
                valor = valor.replace(',', "");
                finalAmount = parseInt(finalAmount) + parseInt(valor)
                methodsArray.push(result)
            } else {
                methodsArray.push(result)
                Swal.fire({
                    position: 'top',
                    title: 'Campos Incompletos',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    timer: 2500,
                    timerProgressBar: true
                })
                return methodsArray
            }
        }
    }
    if (parseInt(finalAmount) == parseInt(amounts.replace(',', "")) && pago == 1) {
        return {
            state: true,
            methodsArray
        }
    } else if (pago == 0) {
        methodsArray = {
            state: true,
            methodsArray
        }
    } else {
        methodsArray = {
            state: false,
            methodsArray
        }
        Swal.fire({
            position: 'top',
            title: 'Monto Incorrecto',
            icon: 'error',
            confirmButtonText: 'OK',
            timer: 2500
        })
    }
    return methodsArray
}

function verificaCamposPago(inputClass) {
    switch (inputClass) {
        case 'efectivoInputs':
            let Emonto = document.getElementsByClassName(`${inputClass}_monto`)[0].value
            if (Emonto.length > 0) {
                let methods = {
                    tipo: "efectivo",
                    monto: parseFloat(Emonto.replace(",", "")).toFixed(2),
                    montoWithFormat: Emonto
                }
                return {
                    state: true,
                    methods
                }
            } else {
                return {
                    state: false
                }
            }
            break;
        case 'tarjertaInputs':
            let Tmonto = document.getElementsByClassName(`${inputClass}_monto`)[0].value
            let tarjeta = document.getElementsByClassName(`${inputClass}_tarjeta`)[0].value
            if (Tmonto.length > 0 && tarjeta.length > 0) {
                let methods = {
                    tipo: "tarjeta",
                    monto: parseFloat(Tmonto.replace(",", "")).toFixed(2),
                    tarjeta,
                    montoWithFormat: Tmonto
                }
                return {
                    state: true,
                    methods
                }
            } else {
                return {
                    state: false
                }
            }
            break;
        case 'transferenciaInputs':
            let BnSelected = document.getElementsByClassName(`transferenciaInputs_banco`)[0].selectedIndex
            let banco = document.getElementsByClassName(`transferenciaInputs_banco`)[0].options[BnSelected].text
            let referencia = document.getElementsByClassName(`${inputClass}_referencia`)[0].value
            let Trmonto = document.getElementsByClassName(`${inputClass}_monto`)[0].value
            if (banco.length > 0 && banco !== "Seleccione" && referencia.length > 0 && Trmonto.length > 0) {
                let methods = {
                    tipo: "transferencia",
                    monto: parseFloat(Trmonto.replace(",", "")).toFixed(2),
                    banco,
                    referencia,
                    montoWithFormat: Trmonto
                }
                return {
                    state: true,
                    methods
                }
            } else {
                return {
                    state: false
                }
            }
            break;
    }
}

function printFact(datos) {
    let body = ''
    let headers = {
        "Content-Type": "application/json"
    }

    let Okprint = document.getElementById('SendFactBoolean');
    // let formData = new FormData()
    // formData.append("datos", JSON.stringify(datos))
    fetch("/facturacion/facturaVenta", {
            method: "POST",
            headers: headers,
            body: JSON.stringify(datos)
        }).then(resp => resp.text())
        .then(resp => {
            //console.log(resp);
            if (Okprint.checked) {
                $(`#FacSendModal`).modal('toggle')
                //$('#printContainer').html(resp)
                let h = resp;
                let d = $("<div>").addClass("printContainer").html(h).appendTo("html");
                window.print();
                d.remove();
            } else {
                $(`#FacSendModal`).modal('toggle')
                Swal.fire({
                    position: 'top',
                    title: "Factura",
                    text: "Factura generada correctamente",
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 2500,
                    timerProgressBar: true
                })
                Okprint.checked = true
            }
            resetFactScreen()
        })

}
$('#bodyContent').on("change", ".fact_switchBtns input[type='checkbox']", function (e) {
    let check = e.target.checked
    if (check) {

        $(this).parent().parent().parent().addClass('selectedMethodPay')
    } else {
        $(this).parent().parent().parent().removeClass('selectedMethodPay')
    }
})

$('#bodyContent').on("blur", ".lbMontoToPay", function (e) {
    if (this.value == '') this.value = 0.00
    e.preventDefault();
    this.value = parseFloat(this.value.replace(/,/g, ""))
        .toFixed(2)
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    totalGastosLabel()
    //document.getElementById("display").value = this.value.replace(/,/g, "")
})

/////////Cambia el color del titulo del metodo de pago
$('#bodyContent').on("change", ".fact_rbRadiosBtns", function (e) {
    $(".fact_rbRadiosBtns").removeClass('selectedMethodPay')
    $(this).parent().parent().addClass('selectedMethodPay')

})

$('#bodyContent').on("click", ".cardHeaderSwitch", function (e) {
    const cb = document.getElementById('MultiTipoPagoFact');
    if (!cb.checked) {
        $(".cardHeaderSwitch").removeClass('selectedMethodPay')
        $(this).children().children().prop("checked", true)
        $(this).addClass('selectedMethodPay')
    } else {
        let label = $(this).children('div').find('label');
        if ($(this).hasClass('selectedMethodPay')) {
            $(this).removeClass('selectedMethodPay')
        } else {
            $(this).addClass('selectedMethodPay')
        }
        let check = $(this).find('.fact_switchBtns').find('input')[0];
        check.checked = !check.checked
    }


})

////////////////
$(window).keypress(function (e) {
    let FactMain = document.getElementById("bodyFactMain")
    if (e.charCode == 17 && e.ctrlKey == true && FactMain) {
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
        if (e.target.value.length > 0) {
            getProductFact(e)
        } else {
            Swal.fire({
                position: 'top',
                title: 'Falta codigo',
                text: 'Debes ingresar el codigo de un producto',
                icon: 'error',
                confirmButtonText: 'OK',
                timer: 2500,
                timerProgressBar: true
            })
        }
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
                    if (data.stock <= 0) {
                        if (data.stock < 0) {
                            Swal.fire({
                                position: 'top',
                                title: "Producto sin stock",
                                text: `Este producto tiene un stock negativo de ${data.stock}`,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            })
                            return
                        }
                        Swal.fire({
                            position: 'top',
                            title: "Producto sin stock",
                            icon: 'error',
                            confirmButtonText: 'OK'
                        })
                        return
                    }
                    let descuento = (data.descuento == null ? 'N/A' : data.descuento + '%')
                    let des_descuento = (data.descuento_descripcion == null ? 'Sin Descuento' : data.descuento_descripcion)
                    let precios = calcTotalRowPrice(data.precio_venta, (data.descuento == null ? 0 : data.descuento), (data.activado_iva == 0 ? 0 : data.iva))
                    let row = /*html*/ `
                        <tr class="productRowFac" id="itemRowProduct_${data.idproducto}">
                            <td scope="row" data-id="${data.idproducto}" data-toggle="tooltip"data-placement="bottom" title="${data.idproducto}">${data.codigo}</td>
                            <td scope="row">${data.descripcion_short} | ${data.marca}</td>
                            <td scope="row">${data.talla}</td>
                            <td scope="row">${(data.activado_iva == 0 ? 0 : data.iva)}</td>
                            <td scope="row"><input type="number" min="1" class="cantInputFact" id="id_${data.idproducto}" style="width: 43px !important;text-align:center" name="" id="" value="1"></td>
                            <td scope="row">${data.stock}</td>
                            <td scope="row" ${(data.precio_venta < 1 ?'style="color:red;"':"")}>${data.precio_venta}</td>
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
    // return Math.round(value / rd1) * rd2
    return value
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
    let total = 0.00
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
    $("#totalFactAmount").attr("data-amount", newFormat)
    $(".lbMontoToPay").val(newFormat)
    $("#amountModalTitle").text(newFormat)
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
    let precio = parseFloat($(tds[6]).text())
    let descuento = $(tds[8]).data('descuento')
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
    $(tds[8]).text(totalAll.toFixed(2))
    let ivaPercent = (parseInt($(tds[3]).text()) == 0 ? 1 : parseInt($(tds[3]).text()))
    if (ivaPercent > 0) {
        let iva = parseInt(ivaPercent) / 100
        let iva_sum = parseFloat(totalAll * iva)
        if (ivaPercent == 1) {
            iva = 1
            iva_sum = 0
        }
        let newTotal = parseFloat(totalAll + iva_sum)
        $(tds[9]).text(newTotal.toFixed(2))
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
$('#bodyContent').on("click", "#SearchProductInputCtrlQBtn", function (e) {
    SearchProductModalFact("", 1)

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
    $("#bodyContent #ScanCode").val("")
    $("#bodyContent #ScanCode").val(this.innerText)
    $("#SearchProductModal").modal('toggle')

    let element = document.getElementById('ScanCode')
    let toSearch = document.getElementById('ScanCode').value
    element.focus();
    element.setSelectionRange(0, toSearch.length);



})
$('#bodyContent').on("click", ".codeToAddInputSearchCard", function (e) {
    let codigo = this.dataset.codebar
    console.log(codigo);
    $("#bodyContent #ScanCode").val(codigo)
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
                let producto = `    <div class="col-6 ">
                                        <div class="card mb-3 codeToAddInputSearchCard" style="width: 100%;" data-codebar="${el.codigo}">
                                        <div class="row no-gutters">
                                            <div class="col-md-4 cardImgBody">
                                            <img src="${(url[0]==""?"/public/assets/img/not-found.png":url[0])}" class="card-img" alt="...">
                                            </div>
                                            <div class="col-md-8">
                                            <div class="card-body">
                                                <h6 class="card-title">${el.descripcion}</h6>
                                                <p class="${el.precio_venta<1?"text-danger":""}">₡ ${el.precio_venta} |  Stock:${el.stock} </p>
                                                <span class="icon_codeToAddInputSearch"><span class="codeToAddInputSearch">${el.codigo}</span></span>
                                                </br>
                                                <span class=""><small class="text-muted">${(el.iva > 0 ?"<strong>IVA: </strong>"+el.iva +"%": "")}${(el.descuento > 0 ?" | <strong>Descuento: </strong>"+el.descuento +"%": "")}</small></span>
                                                </br>
                                                <span class=""><small class="text-muted">Marca: ${el.marca} | Categoria: ${el.categoria} | Talla: ${el.talla}</small></span>
                                                <p class=""><small class="text-muted">Estado: ${(el.estado == 1?"Activo":"Inactivo")}</small></p>
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
$('#bodyContent').on("click", "#SearchClient_inputBtn", function (e) {

    searchClient('', 1);

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
                                        <div class="card mb-2 codeToAddInputSearchClientCard" style="width: 100%;">
                                        <div class="row no-gutters">                                           
                                            <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <div class="icon_codeToAddInputSearch"><p class="card-text codeToAddInputSearchClient" data-name="${el.nombre}"  data-id="${el.idcliente}">${el.nombre}</p></div>
                                                </h5>
                                                <p class="card-text">${el.email}</p>
                                                <p class="card-text"><strong>Tel: </strong> ${el.telefono}</p>
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
$('#bodyContent').on("click", "#btnTypeApartado", function (e) {
    //abrirCaja();
})
$('#bodyContent').on("click", "#btnAbrirCaja", function (e) {
    abrirCaja();
})

function abrirCaja() {
    let form = document.getElementById("cajas_form_addcaja")
    let formData = new FormData(form)
    let cb = document.getElementById("cbSelectuser")
    let monto = parseInt(document.getElementById("cajas_monto").value)
    let user = parseInt(cb.options[cb.selectedIndex].value)
    if (user !== 0 && !isNaN(monto)) {
        fetch("/facturacion/cajas/abrirCaja", {
                method: "POST",
                body: formData
            }).then(resp => resp.json())
            .then(resp => {
                console.log(resp);

                if (resp.error == "00000") {
                    $("#cajas_addcaja").modal("toggle")
                    form.reset()
                    loadPage(null, "/facturacion/cajas")
                    Swal.fire({
                        position: 'top',
                        title: `Rol agregado correctamente`,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        timer: 2500,
                        timerProgressBar: true
                    })


                }
            })
    } else {
        alert('Debe rellenar los campos con la informacion correcta')
    }
}
$('#bodyContent').on("click", ".btnAbrirCajaEstado", function (e) {
    let id = this.dataset.caja
    AbrirCajaEstado(id);
})

function AbrirCajaEstado(id) {
    let formData = new FormData()
    formData.append("idcaja", id)
    fetch("/facturacion/cajas/abrirCajaEstado", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            console.log(resp);

            if (resp.error == "00000") {
                loadPage(null, "/facturacion/cajas")
                Swal.fire({
                    position: 'top',
                    title: `Caja Abierta`,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 2500,
                    timerProgressBar: true
                })


            }
        })
}

function btnCerrarCajaEstado(id) {
    let formData = new FormData()
    formData.append("idcaja", id)
    fetch("/facturacion/cajas/cerrarCajaEstado", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            console.log(resp);

            if (resp.error == "00000") {
                loadPage(null, "/facturacion/cajas")
                Swal.fire({
                    position: 'top',
                    title: `Caja Abierta`,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 2500,
                    timerProgressBar: true
                })


            }
        })
}
// $('#bodyContent').on('click', '.tabItem a', function (e) {
//     console.log(e.target.dataset);
//     e.preventDefault()
//     let id = e.target.dataset.tabshow
//     alert(id)
// })