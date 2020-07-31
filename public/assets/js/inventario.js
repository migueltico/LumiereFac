$('#bodyContent').on("click", "#addProduct #AddProductFormBtn", function (e) {
    e.preventDefault();
    agregarProducto(e)
    //console.log("CLICK EN AGREGAR");
})

$('#bodyContent').on("click", "#addProduct #generarCodigo", function (e) {
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
    $("#addProduct #imageContainer").html('')
})
//DETECTA EL CLICK EN LA X PARA REMOVER IMAGEN DEL MODAL
$('#bodyContent').on("click", "#addProduct .imgContainerChildren span", function ({
    target
}) {
    removeItemFromDt(target, '#addProduct')
})


function agregarProducto(e) {

    if (!validarFormADD('#addProduct')) {
        let url = '/inventario/addproduct';
        let form = document.getElementById('AddProductForm')
        let formDatas = new FormData(form)
        let urls = []
        let sucursales = [];
        let checkeds = $("#addProduct .checkSucursal")
        checkeds.map((i, input) => {
            if ($(input).prop('checked')) {
                sucursales.push($(input).data('sucursal'))
            }
        })
        // $("#addProduct #imageContainer .imgContainerChildren img").each((i, input) => {
        //     let img = $(input).attr("src")
        //     urls.push(img)
        // })
        formDatas.append("urls", urls)
        formDatas.append("sucursales", sucursales)
        fetch(url, {
                method: 'POST',
                body: formDatas
            })
            .then((resp) => resp.json())
            .then((resp) => {
                if (resp.error == '0') {
                    Swal.fire({
                        position: 'top-end',
                        title: 'Producto Agregado',
                        text: resp.msg,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    })
                    $("#addProduct #imageContainer").html('')
                    $("#addProduct #txtcodigoBarra").val('')
                    loadTable()
                } else {
                    $("#addProduct #txtcodigoBarra").val('')
                    Swal.fire({
                        position: 'top-end',
                        title: resp.msg,
                        text: resp.errorData.errorMsg[2],
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })
                }
            })
            .catch((err) => {
                Swal.fire({
                    position: 'top-end',
                    title: 'Error!',
                    text: err,
                    icon: 'error',
                    confirmButtonText: 'Cool'
                })
                $("#addProduct #txtcodigoBarra").val('')
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
            $(`${modalId} #txtcodigoBarra`).val(resp.codigo)
        })
        .catch((err) => {
            console.log('error en FETCH:', err);
        });
}

function loadTable(e) {
    fetch('/inventario/refresh/producttable', {
            method: 'POST'
        })
        .then((result) => result.text())
        .then((html) => {
            $(".loadTable").html(html)
            console.log('Load New data');
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
        $(`${modalId} #imageContainer`).html('');
    }
}

function validarFormADD(modalId) {
    let descripcion = $(modalId + " #descripcion").val()
    let estilo = $(modalId + " #estilo").val()
    let marca = $(modalId + " #marca").val()
    let codigo = $(modalId + " #txtcodigoBarra").val()
    let cbTalla = $(modalId + " #cbTalla").children("option:selected").val()
    let cbCategoria = $(modalId + " #cbCategoria").children("option:selected").val()
    let iva = $(modalId + " #iva").prop("checked")
    let iva_valor = $(modalId + " #iva_valor").val()
    let validate = 0
    $(modalId + " #iva_valor").removeClass('is-invalid')
    $(modalId + " #descripcion").removeClass('is-invalid')
    $(modalId + " #estilo").removeClass('is-invalid')
    $(modalId + " #marca").removeClass('is-invalid')
    $(modalId + " #txtcodigoBarra").removeClass('is-invalid')
    $(modalId + " #cbTalla").removeClass('is-invalid')
    $(modalId + " #cbCategoria").removeClass('is-invalid')

    if (iva && iva_valor == '') {
        $(modalId + " #iva_valor").addClass('is-invalid')
        validate = 1
    }
    if (descripcion == '') {
        $(modalId + " #descripcion").addClass('is-invalid')
        validate = 1
    }
    if (estilo == '') {
        $(modalId + " #estilo").addClass('is-invalid')
        validate = 1
    }
    if (marca == '') {
        $(modalId + " #marca").addClass('is-invalid')
        validate = 1
    }
    if (codigo == '') {
        $(modalId + " #txtcodigoBarra").addClass('is-invalid')
        validate = 1
    }
    if (cbTalla == '0') {
        $(modalId + " #cbTalla").addClass('is-invalid')
        validate = 1
    }
    if (cbCategoria == '0') {
        $(modalId + " #cbCategoria").addClass('is-invalid')
        validate = 1
    }
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
$('#bodyContent').on("click", "#EditProduct #generarCodigo", function (e) {
    e.preventDefault();
    generarCodigo(e, '#EditProduct')
})
$("#bodyContent").on("click", ".EditProductBtn", function (e) {
    resetInputImage(e, '#EditProduct')
    $(`#EditProduct #imageContainer`).html('')
    console.log("EDIT");
    loadDataEditModal(e, '#EditProduct')
});
$("#bodyContent").on("click", "#EditProduct #EditProductFormBtn", function (e) {
    e.preventDefault()
    UpdateEditModal(e, '#EditProduct')
    loadTable()
});
//DETECTA EL CLICK EN LA X PARA REMOVER IMAGEN DEL MODAL
$('#bodyContent').on("click", "#EditProduct .imgContainerChildren span", function ({
    target
}) {
    removeItemFromDt(target, '#EditProduct')
})
//REMUEVE LA IMAGEN SELECCIONADA DEL DATA TRANSFER
function removeItemFromDt(target, modalId) {
    let url2 = $(target).data('url')
    let indexImg = $(target).data('index')
    let el = $(target).parent()
    let filesImages = $(`${modalId} #filesImages`)
    dt.items.remove(indexImg)
    $(el).remove()
    DeleteTransferItem(modalId)
}

function DeleteTransferItem(modalId) {
    let filesImages = $(`${modalId} #filesImages`)[0] // selecciono el elemento como tal pero con la utilidad de usar jquery con dos ID
    let filesImageHidden = $(`${modalId} #filesImageHidden`)[0]
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
    let id = $(e.target).data('id')
    let formDatas = new FormData()
    let filesImageHidden = $(`${modalId} #filesImageHidden`)[0]
    formDatas.append('idproducto', id)
    fetch('/inventario/getProductBySucursal', {
            method: 'POST',
            body: formDatas
        }).then((result) => result.json())
        .then((resp) => {
            if (!resp.error) {
                let datos = resp.data[0]
                let sucursales = datos.sucursales.split(',')
                let urls = datos.image_url.split(',')
                let id = datos.idproducto

                $(`${modalId} #imageContainer`).html('')
                $(`${modalId} #editIdProducto`).text(`Editar Producto #${id}`)
                $(`${modalId} :input#idproducto`).val(id)
                $(`${modalId} :input#originalUrl`).val(datos.image_url)

                urls.map((image, index) => {
                    let img = `<div class="imgContainerChildren imgWrapper shadow">
                            <span class="shadow-sm" data-hasurl='1' data-url="${image}" data-index="${index}">x</span>
                            <img src="${image}" />
                            </div>`;
                    $(`${modalId} #imageContainer`).append(img);
                })


                $(`${modalId} :input.checkSucursal`).prop('checked', false)
                sucursales.forEach(id => {
                    let idtag = `#EditProduct :input#idsucursal${id}`
                    $(idtag).prop("checked", true)
                });
                $(`${modalId} :input#descripcion`).val(datos.descripcion)
                $(`${modalId} :input#marca`).val(datos.marca)
                $(`${modalId} :input#estilo`).val(datos.estilo)
                $(`${modalId} :input#txtcodigoBarra`).val(datos.codigo)

                if (datos.activado_iva == '1') {
                    $(`${modalId} :input#iva`).prop('checked', true)
                }
                $(`${modalId} :input#iva_valor`).val(datos.iva)
                $(`${modalId} :input#cbTalla option`).each((i, option) => {
                    if ($(option).val() == datos.idtalla) {
                        $(option).prop("selected", true)
                    }
                })
                $(`${modalId} :input#cbCategoria option`).each((i, option) => {
                    if ($(option).val() == datos.idcategoria) {
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
    let form = $(`${modalId} #EditProductForm`)[0]
    //let form = document.getElementById('EditProductForm')
    let formData = new FormData(form)
    let sucursales = []
    let urls = []
    let cksucursales = $(`${modalId} .checkSucursal`)
    cksucursales.map((i, el) => {
        let data = $(el).data('sucursal')
        if ($(el).prop('checked')) {
            sucursales.push(data)
        }
    })
    formData.append("sucursales", sucursales)
    // for (var value of formData.values()) {
    //     console.log(value);
    // }

    fetch("/inventario/updateProduct", {
            method: 'POST',
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            console.log(resp);
        }).catch((err) => {
            console.log('error en FETCH:', err);
        });
}

//************END GROUP EDIT **********************************************************/


$("#bodyContent").on("change", "#addProduct #filesImages", function (e) {
    TransferInput('#addProduct')
});
$("#bodyContent").on("change", "#EditProduct #filesImages", function (e) {
    TransferInput('#EditProduct')
});
const dt = new DataTransfer()
/**
 * Se transfiere los input File al Input Principal y se añade la imagen al container pasado como
 * @param {string} modalId Main id del MODAL para no confundir con otros inputs de otros modals
 */
function TransferInput(modalId) {
    // console.log('TransferInput Change');
    $(`${modalId} #imageContainer`).html('');
    let filesImages = $(`${modalId} #filesImages`)[0] // selecciono el elemento como tal pero con la utilidad de usar jquery con dos ID
    let filesImageHidden = $(`${modalId} #filesImageHidden`)[0]
    let data = filesImages.files
    let dataArray = []
    for (var i = 0; i < data.length; i++) {
        // dt.items.add(new File([], data))
        dt.items.add(new File([data[i]], data[i].name, {
            type: data[i].type,
            lastModified: new Date().getTime()
        }))
    }
    filesImageHidden.files = dt.files
    $(`${modalId} #filesImages`).val('')
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
            $(`${modalId} #imageContainer`).append(img);
        };

    }

    // console.log(filesImageHidden);
}

function resetInputImage(e, modalId) {

    $(`${modalId} #filesImages`).val('')
    dt.clearData()
}

function makeBlobFile(urls, modalId) {
    let filesImageHidden = $(`${modalId} #filesImageHidden`)[0]
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
    return "";
}

//NO BORRAR, SIRVE PARA CONVERTIR URLS CON FETCH EN FILES

// fetch(url)
// .then(res => res.blob())
// .then(blob => {
//     const file = new File([blob], 'dot.png', blob)
//     console.log(file)
// })