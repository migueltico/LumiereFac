$('#bodyContent').on("click", "#addProduct #AddProductFormBtn", function (e) {
    e.preventDefault();
    agregarProducto(e)
    //console.log("CLICK EN AGREGAR");
})
//GENERA CODIGO DE BARRAS
$('#bodyContent').on("click", "#addProduct #addProduct_generarCodigo", function (e) {
    e.preventDefault();
    generarCodigo(e, '#addProduct')
})

//REFRESCA LA TABLA EN INVENTARIO
$('#bodyContent').on("click", "#btnRefrescarProducto", function (e) {
    e.preventDefault();
    loadTable(e)
})

//SE EJECUTA AL PRESIONAR EL BTN NUEVO PARA NUEVO PRODUCTO
$('#bodyContent').on("click", "#newProduct", function (e) {
    document.getElementById("AddProductForm").reset();
    resetInputImage(e, '#addProduct')
    $("#addProduct #addProduct_imageContainer").html('')
})
//SE EJECUTA AL PRESIONAR ENTER EN EL INPUT DE BUSQUEDA EN INVENTARIO
$('#bodyContent').on("keypress", "#productSearch", function (e) {
    if (e.charCode == 13) {
        let toSearch = document.getElementById('productSearch').value
        let element = document.getElementById('productSearch')
        let img = '<div class="loading"><img src="/public/assets/img/loading.gif"></div>';
        $(".loadTable").html('')
        $(".loadTable").append(img)
        console.log(toSearch);
        let formData = new FormData()
        formData.append("toSearch", toSearch)
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

function selectText(text, element) {
    element.focus();
    element.setSelectionRange(0, text.length);
}
//SE EJECUTA AL PRESIONAR ENTER EN EL INPUT DE BUSQUEDA EN INVENTARIO
$('#bodyContent').on("keypress", "#productSearchStockInventario", function (e) {
    if (e.charCode == 13) {
        let toSearch = document.getElementById('productSearchStockInventario').value
        let element = document.getElementById('productSearchStockInventario')
        let img = '<div class="loading"><img src="/public/assets/img/loading.gif"></div>';
        $(".loadTable").html('')
        $(".loadTable").append(img)
        console.log(toSearch);
        let formData = new FormData()
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
            console.log(sugerido.innerText);
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
    //  console.log(idProduct);
    urls = urls.split(',')
    $('#galleryShow .carousel-inner').html('')
    $('#galleryShow .carousel-indicators').html('')
    $('#galleryShow #galleryShowTitle').text(`# ${idProduct} - ${name}`)


    urls.map((url, i) => {
        let img = `
        <div class="carousel-item ${(i==0?'active':'')}">
            <img src="${url}" data-interval="1000" class="d-block w-100" alt="Imagen Articulo">
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
    let formData = new FormData()
    console.log(toSearch);
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
            console.log('error en FETCH:', err);
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
            console.log(resp);
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
                    //console.log(resp);
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
                console.log(StockNow);
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
                console.log(resp);
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
                    loadTable()
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
            console.log('error en FETCH:', err);
        });
}

function loadTable(e) {
    let img = ` <div class = "loading"><img src ="/public/assets/img/loading.gif" ></div>`;
    $(".loadTable").html('')
    $(".loadTable").append(img)
    fetch('/inventario/refresh/producttable', {
            method: 'POST',
        })
        .then((result) => result.text())
        .then((html) => {
            $(".loadTable").html(html)
        })
        .catch((err) => {
            console.log('error en FETCH:', err);
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

    //console.log(e.target.dataset.idproductedit);
    let formDatas = new FormData()
    let filesImageHidden = $(`${modalId}_filesImageHidden`)[0]
    formDatas.append('idproducto', id)
    fetch('/inventario/getProductById', {
            method: 'POST',
            body: formDatas
        }).then((result) => result.json())
        .then((resp) => {
            //console.log(resp);
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
                console.log(resp);
            }
        })
        .catch((err) => {
            console.log('error en FETCH:', err);
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
        //      console.log(value);
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
                        text: resp.error+": Codigo de barra duplicado",
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })
                }
                $(`#EditProduct`).modal('toggle')
                loadTable(e)
            }).catch((err) => {
                console.log('error en FETCH:', err);
                loadTable(e)
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
    // console.log('TransferInput Change');
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
        // console.log(filesImageHidden.files[i]);
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

    // console.log(filesImageHidden);
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

//NO BORRAR, SIRVE PARA CONVERTIR URLS CON FETCH EN FILES

// fetch(url)
// .then(res => res.blob())
// .then(blob => {
//     const file = new File([blob], 'dot.png', blob)
//     console.log(file)
// })