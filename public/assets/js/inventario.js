$('#bodyContent').on("click", "#addProduct #AddProductFormBtn", function (e) {
    e.preventDefault();
    agregarProducto(e)
    ////console.log("CLICK EN AGREGAR");
})
//GENERA CODIGO DE BARRAS
$('#bodyContent').on("click", "#addProduct #addProduct_generarCodigo", function (e) {
    e.preventDefault();
    generarCodigo(e, '#addProduct')
})

//REFRESCA LA TABLA EN INVENTARIO
$('#bodyContent').on("click", "#btnRefrescarProducto", function (e) {
    e.preventDefault();
    let input = document.getElementById("productSearch").value
    if (!$(this).hasClass("disabled")) {
        let page = document.querySelector(".paginationBtn.active")
        loadTable(e, page.dataset.page, input)
    }
})

//SE EJECUTA AL PRESIONAR EL BTN NUEVO PARA NUEVO PRODUCTO
$('#bodyContent').on("click", "#newProduct", function (e) {
    let newProduct = document.getElementById("AddProductForm")
    newProduct.reset();
    resetInputImage(e, '#addProduct')
    $("#addProduct #addProduct_imageContainer").html('')
})

//Pagination Inventario
$('#bodyContent').on("click", ".paginationInventario", function (e) {
    let page = this.dataset.page
    let search = document.getElementsByClassName('inputSearchPagination')[0].value

    //console.log(this.dataset.page)
    if (!$(this).hasClass("disabled")) {
        loadTable(e, page, search)
    }
})
//SE EJECUTA AL PRESIONAR ENTER EN EL INPUT DE BUSQUEDA EN INVENTARIO
$('#bodyContent').on("keypress", "#productSearch", function (e) {
    if (e.charCode == 13) {
        let toSearch = document.getElementById('productSearch').value
        let element = document.getElementById('productSearch')
        let estado = document.getElementById('checkestado')
        let img = '<div class="loading"><img src="/public/assets/img/loading.gif"></div>';
        $(".loadTable").html('')
        $(".loadTable").append(img)
        //console.log(toSearch);
        let formData = new FormData()
        formData.append("toSearch", toSearch)
        formData.append('estado', (estado.checked ? 0 : 1))
        // formData.append('pagination', pagination)
        fetch("/inventario/search", {
                method: "POST",
                body: formData
            }).then(resp => resp.text())
            .then(resp => {

                selectText(toSearch, element)
                $(".loadTable").html(resp)
            })
    }

})

function paginationSearch(toSearch, page) {
    let formData = new FormData()
    let initLimit = page

    formData.append("toSearch", toSearch)
    formData.append("initLimit", initLimit)
    fetch("/clientes/search/searchclient", {
            method: "POST",
            body: formData
        })
        .then(resp => resp.text())
        .then(resp => {
            //console.log(resp);
        })


}

function selectText(text, element) {
    element.focus();
    element.setSelectionRange(0, text.length);
}
//SE EJECUTA AL PRESIONAR ENTER EN EL INPUT DE BUSQUEDA EN INVENTARIO
$('#bodyContent').on("keypress", "#productSearchStockInventario", function (e) {
    if (e.charCode == 13) {
        let toSearch = document.getElementById('productSearchStockInventario').value
        let element = document.getElementById('productSearchStockInventario')
        let estado = document.getElementById('checkestado')
        let img = '<div class="loading"><img src="/public/assets/img/loading.gif"></div>';
        $(".loadTable").html('')
        $(".loadTable").append(img)
        //console.log(toSearch);
        let formData = new FormData()
        formData.append('estado', (estado.checked ? 0 : 1))
        formData.append("toSearch", toSearch)
        fetch("/inventario/search/stock", {
                method: "POST",
                body: formData
            }).then(resp => resp.text())
            .then(resp => {
                $(".loadTable").html(resp)
                selectText(toSearch, element)
            })
    }

})
//Calcula el precio sugerido
$('#bodyContent').on("click", ".BtnCalcularSugerido", function (e) {
    let id = e.target.dataset.id
    let costo = document.getElementById(`costo_${id}`).value
    let unitario = document.getElementById(`unitario_${id}`).value
    let formData = new FormData()
    formData.append("id", id)
    formData.append("costo", costo)
    formData.append("unitario", unitario)
    fetch("/inventario/calcular/sugerido", {
            method: "POST",
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            let sugerido = document.getElementById(`sugerido_${id}`)
            let precioVenta = document.getElementById(`precioVenta_${id}`)
            if (precioVenta.value == "" || precioVenta.value == 0.00 || precioVenta.value == 0) {
                precioVenta.value = resp.precio_sugerido.toFixed(2)
            }
            sugerido.innerText = resp.precio_sugerido.toFixed(2)
            //console.log(sugerido.innerText);
        })

})
//DETECTA EL CLICK EN LA X PARA REMOVER IMAGEN DEL MODAL
$('#bodyContent').on("click", "#addProduct .imgContainerChildren span", function ({
    target
}) {
    removeItemFromDt(target, '#addProduct')
})
//Muestra imagenes
$('#bodyContent').on("click", ".SeeImgProduct", function (e) {
    e.preventDefault();
    let urls = e.target.dataset.urls
    let idProduct = e.target.dataset.idproductedit
    let name = e.target.dataset.name
    //  //console.log(idProduct);
    urls = urls.split(',')
    $('#galleryShow .carousel-inner').html('')
    $('#galleryShow .carousel-indicators').html('')
    $('#galleryShow #galleryShowTitle').text(`# ${idProduct} - ${name}`)


    urls.map((url, i) => {
        let img = `
        <div class="carousel-item ${(i==0?'active':'')}">
            <img src="${(url==""?"/public/assets/img/not-found.png":url)}" data-interval="1000" class="d-block w-100" alt="Imagen Articulo">
        </div>
        `
        let indicator = `
                        <li data-target="#carouselIndicators" data-slide-to=""${i}" class="${(i==0?'active':'')}"></li>
        `

        $('#galleryShow .carousel-indicators').append(indicator)
        $('#galleryShow .carousel-inner').append(img)
    })
})

$("#bodyContent").on('click', '.btnSaveProductPrice', function (e) {
    saveProductPrice(e)
})
$("#bodyContent").on('click', '.addStockBtn', function (e) {
    let id = e.target.dataset.id
    addStock(id)
})
$("#bodyContent").on('click', '.addMinStockBtn', function (e) {
    let id = e.target.dataset.id
    addMinStock(id)
})

function refreshStock() {
    let img = '<div class="loading"><img src="/public/assets/img/loading.gif" alt="Loading..."></div>';
    let toSearch = document.getElementById('productSearchStockInventario')
    let estado = document.getElementById('checkestado')
    let formData = new FormData()
    formData.append('estado', (estado.checked ? 0 : 1))
    formData.append('toSearch', toSearch.value)
    $(".loadTable").html('')
    $(".loadTable").append(img)
    let url = '/inventario/refreshProductstock';
    fetch(url, {
            method: 'POST',
            body: formData
        })
        .then((result) => result.text())
        .then((html) => {
            $(".loadTable").html(html)
        })
        .catch((err) => {
            //console.log('error en FETCH:', err);
        });
}


function saveProductPrice(e) {
    let id = e.target.dataset.id
    let precioVenta = document.getElementById(`precioVenta_${id}`)
    let unitario = document.getElementById(`unitario_${id}`)
    let sugerido = document.getElementById(`sugerido_${id}`)
    let costo = document.getElementById(`costo_${id}`)
    let formData = new FormData()
    formData.append('venta', precioVenta.value)
    formData.append('costo', costo.value)
    formData.append('unitario', unitario.value)
    formData.append('sugerido', sugerido.innerText)
    formData.append('id', id)
    fetch("/inventario/saveProductPrice", {
            method: 'POST',
            body: formData
        })
        .then((resp) => resp.json())
        .then((resp) => {
            //console.log(resp);
            if (resp.error == '00000') {
                //refreshStock()
                Swal.fire({
                    position: 'top',
                    title: 'Producto Actualizado',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 2500
                })
            } else {
                refreshStock()
                Swal.fire({
                    position: 'top',
                    title: resp.msg,
                    text: resp.errorData.errorMsg[2],
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
            }
        })
}

function addStock(id) {
    Swal.fire({
        title: 'Ingrese la cantidad para Agregar al stock actual',
        input: 'number',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Agregar',
        showLoaderOnConfirm: true,
        preConfirm: (data) => {
            let formData = new FormData()
            formData.append('stock', (data.length == 0 ? 0 : data))
            formData.append('id', id)
            return fetch('/inventario/updateStock', {
                    method: "POST",
                    body: formData
                })
                .then(resp => resp.json()).then(resp => {
                    let stock = document.getElementById(`StockInner_${id}`)
                    let now = stock.innerText
                    stock.innerText = parseInt((data.length == 0 ? 0 : data)) + parseInt(now)
                    return resp
                })
                .catch(error => {
                    Swal.showValidationMessage(
                        `Request failed: ${error}`
                    )
                })
        },
    }).then((result) => {
        // refreshStock()
        if (result.value.error == "00000") {

            Swal.fire({
                position: 'top',
                title: `Stock Actualizado a ${result.value.newStock}`,
                icon: 'success',
                confirmButtonText: 'OK',
                timer: 2500
            })
        } else {
            //console.log(result.value);
            refreshStock()
            Swal.fire({
                position: 'top',
                title: 'Error al actualizar el stock',
                icon: 'error',
                confirmButtonText: 'OK'
            })
        }

    })
}

function addMinStock(id) {
    Swal.fire({
        title: 'Ingrese la cantidad minima del stock de este producto',
        input: 'number',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Agregar',
        showLoaderOnConfirm: true,
        preConfirm: (data) => {
            let formData = new FormData()
            formData.append('MinStock', (data.length == 0 ? 0 : data))
            formData.append('id', id)
            return fetch('/inventario/updateMinStock', {
                    method: "POST",
                    body: formData
                })
                .then(resp => resp.json()).then(resp => {
                    ////console.log(resp);
                    let MinStock = document.getElementById(`MinStockInner_${id}`)
                    MinStock.innerText = (data.length == 0 ? 0 : data)
                    return resp
                })
                .catch(error => {
                    Swal.showValidationMessage(
                        `Request failed: ${error}`
                    )
                })
        },
    }).then((result) => {
        if (result.value.error == "00000") {
            let MinStock = document.getElementById(`MinStockInner_${id}`)
            let Stock = document.getElementById(`StockInner_${id}`)
            let Min = parseInt(MinStock.innerText)
            let StockNow = parseInt(Stock.innerText)
            if (StockNow <= Min) {
                //console.log(StockNow);
                Stock.classList.add("text-danger")
                Stock.classList.remove("text-success")
            } else {
                Stock.classList.remove("text-danger")
                Stock.classList.add("text-success")
            }
            Swal.fire({
                position: 'top',
                title: 'Stock Actualizado',
                icon: 'success',
                confirmButtonText: 'OK',
                timer: 2500
            })
        } else {
            refreshStock()
            Swal.fire({
                position: 'top',
                title: 'Error al actualizar el stock',
                icon: 'error',
                confirmButtonText: 'OK'
            })
        }

    })
}

function agregarProducto(e) {

    if (!validarFormADD('#addProduct')) {
        let url = '/inventario/addproduct';
        let form = document.getElementById('AddProductForm')
        let formDatas = new FormData(form)
        let urls = []
        formDatas.append("urls", urls)
        fetch(url, {
                method: 'POST',
                body: formDatas
            })
            .then((resp) => resp.json())
            .then((resp) => {
                //console.log(resp);
                if (resp.error == '0') {
                    Swal.fire({
                        position: 'top',
                        title: 'Producto Agregado',
                        text: resp.msg,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    })
                    $("#addProduct #addProduct_imageContainer").html('')
                    $("#addProduct #addProduct_txtcodigoBarra").val('')
                    loadTable(e, 1, "")
                } else {
                    $("#addProduct #addProduct_txtcodigoBarra").val('')
                    Swal.fire({
                        position: 'top',
                        title: resp.msg,
                        text: resp.errorData.errorMsg[2],
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })
                }
            })
            .catch((err) => {
                Swal.fire({
                    position: 'top',
                    title: 'Error!',
                    text: err,
                    icon: 'error',
                    confirmButtonText: 'Cool'
                })
                $("#addProduct #addProduct_txtcodigoBarra").val('')
            });
    }
}

function generarCodigo(e, modalId) {
    let url = '/inventario/generar/codigobarras';
    fetch(url, {
            method: 'POST',
        })
        .then((result) => result.json())
        .then((resp) => {
            $(`${modalId}_txtcodigoBarra `).val(resp.codigo)
        })
        .catch((err) => {
            //console.log('error en FETCH:', err);
        });
}

function loadTable(e, pagination, search = "") {
    let img = ` <div class = "loading"><img src ="/public/assets/img/loading.gif" ></div>`;
    let formData = new FormData()
    let url = document.getElementsByClassName('urlPagination')[0].dataset.url
    let estado = document.getElementById('checkestado')
    //console.log(url);
    formData.append('estado', (estado.checked ? 0 : 1))
    formData.append('pagination', pagination)
    formData.append('toSearch', search)
    //console.log("To search: " + search);
    $(".loadTable").html('')
    $(".loadTable").append(img)
    fetch(url, {
            method: 'POST',
            body: formData
        })
        .then((result) => result.text())
        .then((html) => {
            $(".loadTable").html(html)
        })
        .catch((err) => {
            //console.log('error en FETCH:', err);
        });
}

function removeImgAdd2({
    target
}, modalId) {
    let classes = $(target.classList)
    if (classes[1] == 'fade' || classes[0] == 'close' || classes[0] == 'closeBtn') {
        $(`${modalId}_imageContainer`).html('');
    }
}

function validarFormADD(modalId) {
    let descripcion = $(modalId + "_descripcion").val()
    let descripcion_short = $(modalId + "_descripcion_short").val()
    let estilo = $(modalId + "_estilo").val()
    let marca = $(modalId + "_marca").val()
    let codigo = $(modalId + "_txtcodigoBarra").val()
    let cbTalla = $(modalId + "_cbTalla").children("option:selected").val()
    let cbCategoria = $(modalId + "_cbCategoria").children("option:selected").val()
    let cbCategoriaPrecio = $(modalId + "_cbCategoriaPrecio").children("option:selected").val()
    let cbDescuento = $(modalId + "_cbDescuento").children("option:selected").val()
    let iva = $(modalId + "_iva").prop("checked")
    let iva_valor = $(modalId + "_iva_valor").val()
    let validate = 0
    $(modalId + "_iva_valor").removeClass('is-invalid')
    $(modalId + "_descripcion").removeClass('is-invalid')
    $(modalId + "_descripcion_short").removeClass('is-invalid')
    $(modalId + "_estilo").removeClass('is-invalid')
    $(modalId + "_marca").removeClass('is-invalid')
    $(modalId + "_txtcodigoBarra").removeClass('is-invalid')
    $(modalId + "_cbTalla").removeClass('is-invalid')
    $(modalId + "_cbCategoria").removeClass('is-invalid')
    $(modalId + "_cbCategoriaPrecio").removeClass('is-invalid')
    $(modalId + "_cbDescuento").removeClass('is-invalid')

    if (iva && iva_valor == '') {
        $(modalId + "_iva_valor").addClass('is-invalid')
        validate = 1
    }
    if (descripcion == '') {
        $(modalId + "_descripcion").addClass('is-invalid')
        validate = 1
    }
    if (descripcion_short == '') {
        $(modalId + "_descripcion_short").addClass('is-invalid')
        validate = 1
    }
    if (estilo == '') {
        $(modalId + "_estilo").addClass('is-invalid')
        validate = 1
    }
    if (marca == '') {
        $(modalId + "_marca").addClass('is-invalid')
        validate = 1
    }
    if (codigo == '') {
        $(modalId + "_txtcodigoBarra").addClass('is-invalid')
        validate = 1
    }
    if (cbTalla == '0') {
        $(modalId + "_cbTalla").addClass('is-invalid')
        validate = 1
    }
    if (cbCategoria == '0') {
        $(modalId + "_cbCategoria").addClass('is-invalid')
        validate = 1
    }
    if (cbCategoriaPrecio == '0') {
        $(modalId + "_cbCategoriaPrecio").addClass('is-invalid')
        validate = 1
    }
    // if (cbDescuento == '0') {
    //     $(modalId + "_cbDescuento").addClass('is-invalid')
    //     validate = 1
    // }
    return validate

}



//**************************************************************************** */
//**************************************************************************** */
//*****           ****        ********             ****                 ****** */
//*****    ***********   *****   **********   ***************    ************* */
//*****    ***********   *******   ********   ***************    ************* */
//*****         ******   *******   ********   ***************    ************* */
//*****    ***********   *******   ********   ***************    ************* */
//*****    ***********   *******   ********   ***************    ************* */
//*****    ***********   *****   **********   ***************    ************* */
//*****           ****        ********             **********    ************* */
//**************************************************************************** */
//**************************************************************************** */


//SE EJECUTA AL PRESIONAR EDITAR EN ALGUN PRODUCTO
$('#bodyContent').on("click", "#EditProduct #EditProduct_generarCodigo", function (e) {
    e.preventDefault();
    generarCodigo(e, '#EditProduct')
})

//CARGA DATOS AL MODAL DE EDICION
$("#bodyContent").on("click", ".EditProductBtn", function (e) {
    miStorage = window.localStorage;
    miStorage.setItem('deleteUrls', '');
    resetInputImage(e, '#EditProduct')
    $(`#EditProduct #EditProduct_imageContainer`).html('')
    loadDataEditModal(e, '#EditProduct')
});
$("#bodyContent").on("click", "#EditProduct #EditProductFormBtn", function (e) {
    e.preventDefault()
    UpdateEditModal(e, '#EditProduct')

});
//DETECTA EL CLICK EN LA X PARA REMOVER IMAGEN DEL MODAL
$('#bodyContent').on("click", "#EditProduct .imgContainerChildren span", function ({
    target
}) {
    let hasUrl = $(target).data('hasurl')
    miStorage = window.localStorage;
    let data = miStorage.getItem('deleteUrls')
    data = (data == null ? '' : data)
    let datoString = (hasUrl == '1' ? $(target).data('url') : '')
    let newData = data + (data == '' ? datoString : `,${datoString}`)
    miStorage.setItem('deleteUrls', newData);
    removeItemFromDt(target, '#EditProduct')
})
//REMUEVE LA IMAGEN SELECCIONADA DEL DATA TRANSFER
function removeItemFromDt(target, modalId) {
    let url2 = $(target).data('url')
    let indexImg = $(target).data('index')
    let el = $(target).parent()
    //let filesImages = $(`${modalId}_filesImages`)
    dt.items.remove(indexImg)
    $(el).remove()
    DeleteTransferItem(modalId)
}

function DeleteTransferItem(modalId) {
    let filesImages = $(`${modalId}_filesImages`)[0] // selecciono el elemento como tal pero con la utilidad de usar jquery con dos ID
    let filesImageHidden = $(`${modalId}_filesImageHidden`)[0]
    let data = filesImages.files
    for (var i = 0; i < data.length; i++) {
        // dt.items.add(new File([], data))
        dt.items.add(new File([data[i]], data[i].name, {
            type: data[i].type,
            lastModified: new Date().getTime()
        }))
    }
    filesImageHidden.files = dt.files
}

function loadDataEditModal(e, modalId) {
    let id = $(e.target).data('idproductedit')

    ////console.log(e.target.dataset.idproductedit);
    let formDatas = new FormData()
    let filesImageHidden = $(`${modalId}_filesImageHidden`)[0]
    formDatas.append('idproducto', id)
    fetch('/inventario/getProductById', {
            method: 'POST',
            body: formDatas
        }).then((result) => result.json())
        .then((resp) => {
            ////console.log(resp);
            if (!resp.error) {
                let datos = resp.data[0]
                let id = datos.idproducto
                $(`${modalId}_imageContainer`).html('')
                $(`${modalId}_editIdProducto`).text(`Editar Producto #${id}`)
                $(`${modalId}_idproducto`).val(id)

                let urls = ''
                if (datos.image_url !== '') {
                    // $(`${modalId}_originalUrl`).val(datos.image_url)
                    urls = datos.image_url.split(',')
                    urls.map((image, index) => {
                        if (image !== '') {

                            let img = `<div class="imgContainerChildren imgWrapper shadow">
                            <span class="shadow-sm" data-hasurl='1' data-url="${image}" data-index="${index}">x</span>
                            <img src="${image}" />
                            </div>`;
                            $(`${modalId}_imageContainer`).append(img);
                        }
                    })
                }
                $(`${modalId}_descripcion`).val(datos.descripcion)
                $(`${modalId}_descripcion_short`).val(datos.descripcion_short)
                $(`${modalId}_marca`).val(datos.marca)
                $(`${modalId}_estilo`).val(datos.estilo)
                $(`${modalId}_txtcodigoBarra`).val(datos.codigo)
                $(`${modalId}_editEstadoCheck`).prop('checked', (datos.estado == 1 ? true : false))

                if (datos.activado_iva == '1') {
                    $(`${modalId}_iva`).prop('checked', true)
                }
                $(`${modalId}_iva_valor`).val(datos.iva)

                $(`${modalId}_cbTalla option`).each((i, option) => {
                    if ($(option).val() == datos.idtalla) {
                        $(option).prop("selected", true)
                    }
                })
                $(`${modalId}_cbCategoria option`).each((i, option) => {
                    if ($(option).val() == datos.idcategoria) {
                        $(option).prop("selected", true)
                    }
                })
                $(`${modalId}_cbCategoriaPrecio option`).each((i, option) => {
                    if ($(option).val() == datos.categoriaPrecio) {
                        $(option).prop("selected", true)
                    }
                })
                $(`${modalId}_cbDescuento option`).each((i, option) => {
                    if ($(option).val() == datos.iddescuento) {
                        $(option).prop("selected", true)
                    }
                })


                makeBlobFile(urls, modalId)
            } else {
                //console.log(resp);
            }
        })
        .catch((err) => {
            //console.log('error en FETCH:', err);
        });
    //  TransferInput(modalId)
}

function UpdateEditModal(e, modalId) {
    if (!validarFormADD(modalId)) {
        let form = $(`${modalId} #EditProductForm`)[0]
        //let form = document.getElementById('EditProductForm')
        let formData = new FormData(form)
        let urlsToDelete = localStorage.getItem('deleteUrls')
        formData.append("urlsToDelete", urlsToDelete)
        //  for (var value of formData.values()) {
        //      //console.log(value);
        //  }

        fetch("/inventario/updateProduct", {
                method: 'POST',
                body: formData
            }).then(resp => resp.json())
            .then(resp => {
                if (resp.error == "00000") {
                    // Swal.fire({
                    //     position: 'top',
                    //     title: 'Producto Actualizado',
                    //     icon: 'success',
                    //     confirmButtonText: 'OK'
                    // })
                } else {
                    Swal.fire({
                        position: 'top',
                        title: 'Error al actualizar el Producto',
                        text: resp.error + ": Codigo de barra duplicado",
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })
                }
                $(`#EditProduct`).modal('toggle')
                let page = document.querySelector(".paginationBtn.active")
                let input = document.getElementById("productSearch").value
                loadTable(e, page.dataset.page, input)
            }).catch((err) => {
                //console.log('error en FETCH:', err);
                loadTable(e, 1, "")
            });
    }
}

//************END GROUP EDIT **********************************************************/


$("#bodyContent").on("change", "#addProduct_filesImages", function (e) {
    TransferInput('#addProduct')
});
$("#bodyContent").on("change", "#EditProduct_filesImages", function (e) {
    TransferInput('#EditProduct')
});
const dt = new DataTransfer()
/**
 * Se transfiere los input File al Input Principal y se añade la imagen al container pasado como
 * @param {string} modalId Main id del MODAL para no confundir con otros inputs de otros modals
 */
function TransferInput(modalId) {
    // //console.log('TransferInput Change');
    $(`${modalId}_imageContainer`).html('');
    let filesImages = $(`${modalId}_filesImages`)[0]
    let filesImageHidden = $(`${modalId}_filesImageHidden`)[0]
    let data = filesImages.files
    for (var i = 0; i < data.length; i++) {
        // dt.items.add(new File([], data))
        dt.items.add(new File([data[i]], data[i].name, {
            type: data[i].type,
            lastModified: new Date().getTime()
        }))
    }
    filesImageHidden.files = dt.files
    $(`${modalId}_filesImages`).val('')
    for (var i = 0; i < filesImageHidden.files.length; i++) {
        // //console.log(filesImageHidden.files[i]);
        let reader = new FileReader();
        reader.readAsDataURL(filesImageHidden.files[i]); // convert to base64 string
        let index = i
        reader.onload = function (e) {
            let image = e.target.result
            let img = `<div class="imgContainerChildren imgWrapper shadow">
            <span class="shadow-sm"  data-hasurl='0'  data-url="${image}" data-index="${index}">x</span>
            <img src="${image}" />
            </div>`;
            $(`${modalId}_imageContainer`).append(img);
        };

    }

    // //console.log(filesImageHidden);
}

function resetInputImage(e, modalId) {

    $(`${modalId}_filesImages`).val('')
    dt.clearData()
}

function makeBlobFile(urls, modalId) {
    if (urls !== '') {
        let filesImageHidden = $(`${modalId}_filesImageHidden`)[0]
        urls.map((url, i) => {
            fetch(urls[i])
                .then(res => res.blob())
                .then(blob => {
                    // let nameImg = makeid(3, blob.type);
                    let nameImg = GetFilename(url);
                    let long = (urls.length - 1)
                    //  dt.items.add(new File([blob], makeid(8), blob))
                    dt.items.add(new File([blob], nameImg, {
                        type: blob.type,
                        lastModified: new Date().getTime(),
                    }))
                    filesImageHidden.files = dt.files
                    // $(`${modalId} #imageContainer`).html('');
                })



        })

    }
}

function makeid(length, type) {
    let result = '';
    let characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let charactersLength = characters.length;
    for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    let mime = type
    mime = mime.split('/')
    mime = 'image_' + result + '.' + mime[1]
    return mime.toLowerCase()
}

function GetFilename(url) {
    if (url) {
        var m = url.toString().match(/.*\/(.+?)\./);
        if (m && m.length > 1) {
            let mime = url.split('.')[1]
            return m[1] + '.' + mime;
        }
    }
    return "nothing";
}
$("#bodyContent").on("click", '.printToast', function (e) {
    let codigo = e.target.dataset.idproduct
    let producto = e.target.dataset.name
    let estilo = e.target.dataset.estilo
    let talla = e.target.dataset.talla
    let precio = e.target.dataset.precio
    let toPrint = localStorage.getItem("toPrint")
    let newJson = {
        codigo,
        producto,
        precio,
        estilo,
        talla,
        cantidad: 1

    }
    if (toPrint !== null) {
        toPrint = JSON.parse(toPrint)
        toPrint.push(newJson)
    } else {
        toPrint = []
        toPrint.push(newJson)
    }
    //console.log(estilo, talla);
    localStorage.setItem('toPrint', JSON.stringify(toPrint))
    Swal.fire({
        position: 'top',
        title: `${codigo} - ${producto}`,
        text: "Agregado a la cola de impresion",
        icon: 'success',
        confirmButtonText: 'OK',
        timer: 2500,
        timerProgressBar: true
    })
    $(this).first().parent().parent().parent().css({
        backgroundColor: '#2780e3'
    })
})
$("#bodyContent").on("click", '#newQueque', function (e) {
    localStorage.removeItem('toPrint')
    $("#tbodyPrint").html("")
})
$("#bodyContent").on("change", '.inputPrintCantJson', function (e) {
    let toPrint = localStorage.getItem("toPrint")
    let cant = this.value
    let index = parseInt(this.dataset.index)
    //console.log(cant);
    toPrint = JSON.parse(toPrint)
    toPrint[index].cantidad = parseInt(cant)
    localStorage.setItem('toPrint', JSON.stringify(toPrint))
    //getLocalStoreToPrint()

})
$("#bodyContent").on("click", '#loadDataProduct', function (e) {
    getLocalStoreToPrint()
})
$("#bodyContent").on("click", '.disableProduct', function (e) {
    e.preventDefault()
    let disableProductEl = e.target
    let id = disableProductEl.dataset.enable
    let estado = parseInt(disableProductEl.dataset.estado)
    disableProduct(id, estado,e)
})
$("#bodyContent").on("click", '#makePdfPrint', function (e) {
    // fetch("/reportes/etiquetas", {
    //         method: "GET"
    //     }).then(resp => resp.text())
    //     .then(resp => //console.log(resp))
    printPDF()
})

function getLocalStoreToPrint() {
    $("#tbodyPrint").html("")
    let toPrint = localStorage.getItem("toPrint")
    toPrint = JSON.parse(toPrint)
    //console.log(toPrint);
    if (toPrint !== null) {
        toPrint.map((item, i) => {
            let row = /*html*/ `
                    <tr class="TrRow">
                        <td scope="row">${item.codigo}</td>
                        <td scope="row">${item.producto}</td>
                        <td scope="row">${item.estilo}</td>
                        <td scope="row">${item.talla}</td>
                        <td scope="row"><input class="inputPrintCantJson" style="width: 45px;" type="number" data-index=" ${i}" name="codigo_${item.codigo}" value="${item.cantidad}"></td>
                    </tr>
            `
            $("#tbodyPrint").append(row)
        })
    }

}

function printPDF() {
    let toPrint = localStorage.getItem("toPrint")
    let body = ''
    let headers = {
        "Content-Type": "application/json"
    }
    fetch("/reportes/etiquetas", {
            method: "POST",
            headers: headers,
            body: toPrint
        }).then(resp => resp.text())
        .then(resp => {
            let h = resp;
            let d = $("<div>").addClass("printContainer").html(h).appendTo("html");
            window.print();
            d.remove();
        })

}

function disableProduct(id, estado, e) {
    let msg = ['inhabilitado', 'habilitado']
    estado = estado == 0 ? 1 : 0
    let formData = new FormData()
    formData.append("id", id)
    formData.append("estado", estado)

    fetch("/inventario/update/product/estado", {
            method: 'POST',
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            if (resp.error == "00000") {
                loadTable(e, 1, "")
                Swal.fire({
                    position: 'top',
                    title: `Producto ${msg[estado]} correctamente`,
                    icon: 'success',
                    confirmButtonText: 'OK'
                })
            } else {
                loadTable(e, 1, "")
                Swal.fire({
                    position: 'top',
                    title: 'Error al actualizar estado',
                    text: `No se pudo actualizar el estado del Producto`,
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
            }

        }).catch((err) => {
            //console.log('error en FETCH:', err);
            loadTable(e, 1, "")
        });

}


//NO BORRAR, SIRVE PARA CONVERTIR URLS CON FETCH EN FILES

// fetch(url)
// .then(res => res.blob())
// .then(blob => {
//     const file = new File([blob], 'dot.png', blob)
//     //console.log(file)
// })