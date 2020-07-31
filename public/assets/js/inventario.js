$('#bodyContent').on("click", "#addProduct #AddProductFormBtn", function (e) {
    e.preventDefault();
    agregarProducto(e)
    //console.log("CLICK EN AGREGAR");
})
// $('#bodyContent').on("change", "#filesImages", function (e) {
//     //e.preventDefault();
//     //uploadFiles(e, 'AddImage', '#imageContainer', 'imgContainerChildren')
//     // loadImagePreview(e, '#addProduct')
// })
$('#bodyContent').on("click", "#generarCodigo", function (e) {
    e.preventDefault();
    generarCodigo(e)
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
$('#bodyContent').on("click", ".imgContainerChildren span", function ({
    target
}) {
    let url2 = $(target).data('url')
    let indexImg = $(target).data('index')
    let el = $(target).parent()
    let filesImages = $('#addProduct #filesImages')
    dt.items.remove(indexImg)
    TransferInput('#addProduct')
})
// $("#bodyContent").on("click", "#addProduct", "hidden.bs.modal", function (e) {
//     removeImgAdd2(e)


// });


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
                console.log(resp);
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
/**
 * //Solo la variable Container lleva simbolo de clase o ID
 * @param {*} e evento
 * @param {*} formId Id del Form
 * @param {*} containerID ( Lleva el simbolo antepuesto )Id o Clase del contenedor donde se agregaran las imagenes
 * @param {*} wrappImgeId  Clase del wrapper de la imagen y el span
 */
function uploadFiles(e, formId, containerID, wrappImgeId) {
    let url = '/upload/files';
    let form = document.getElementById(formId)
    let formDatas = new FormData(form)

    fetch(url, {
            method: 'POST',
            body: formDatas
        })
        .then((resp) => resp.json())
        .then((resp) => {
            console.log(resp);
            resp.urls.map(image => {
                let img = `<div class="${wrappImgeId} shadow  imgWrapper"><span class="shadow-sm" data-url="${image.url}">x</span><img src="${image.url}" alt=""></div>`
                $(containerID).append(img)
                console.log(containerID);
                console.log(img);
            });
        })
        .catch((err) => {
            console.log('error en FETCH:', err);
        });
}

function generarCodigo(e) {
    let url = '/inventario/generar/codigobarras';
    fetch(url, {
            method: 'POST',
        })
        .then((result) => result.json())
        .then((resp) => {
            $("#txtcodigoBarra").val(resp.codigo)
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


//************GROUP EDIT **********************************************************/


//SE EJECUTA AL PRESIONAR EDITAR EN ALGUN PRODUCTO
$("#bodyContent").on("click", ".EditProductBtn", function (e) {
    resetInputImage(e, '#EditProduct')
    $(`#EditProduct #imageContainer`).html('')
    console.log("EDIT");
    loadDataEditModal(e, '#EditProduct')
});

//
$("#bodyContent").on("click", "#EditProductFormBtn", function (e) {
    e.preventDefault()
    document.getElementById("EditProductForm").reset();
    resetInputImage(e, '#EditProduct')
    $(`#EditProduct #imageContainer`).html('')
    UpdateEditModal(e)
});
$("#bodyContent").on("click", "#EditProduct .imgContainerChildren span", function (e) {
    removeimgEdit(e)
});
// $('#bodyContent').on("change", "#EditProduct #filesImage", function (e) {
//     //e.preventDefault();
//     loadImagePreview(e, '#EditProduct')
//     //uploadFiles(e, 'EditImage', '#imageContainer', 'imgContainerChildren')
//     console.log('change 2');
// })

function removeimgEdit(e) {
    console.log($(e.target).parent());
    $(e.target).parent().remove()
}

function loadDataEditModal(e,modalId) {
    let id = $(e.target).data('id')
    let formDatas = new FormData()
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

                urls.map((image,i) => {
                    let url =makeBlobFile(image)
                    dt.files = url
                    TransferInput(modalId)
                   // let img = `<div class="imgContainerChildren imgWrapper"><span data-url="${image}">x</span><img src="${image}" alt=""></div>`
                    let img = `<div class="imgContainerChildren imgWrapper shadow">
                    <span class="shadow-sm" data-url="${image}" data-index="${i}">x</span>
                    <img src="${image}" />
                    </div>`;
                    $(`${modalId} #imageContainer`).append(img)
                });
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
            } else {
                console.log(resp);
            }
        })
        .catch((err) => {
            console.log('error en FETCH:', err);
        });
}

function UpdateEditModal() {
    let form = document.getElementById('EditProductForm')
    let formData = new FormData(form)
    let sucursales = []
    let urls = []
    let cksucursales = $(".checkSucursal.edit")
    let images = $("#imageContainer2.edit .imgContainerChildren2 span")
    cksucursales.map((i, el) => {
        let data = $(el).data('sucursal')
        if ($(el).prop('checked')) {
            sucursales.push(data)
        }
    })
    images.map((i, el) => {
        let data = $(el).data('url')
        urls.push(data)
    })
    formData.append("sucursales", sucursales)
    formData.append("urls", urls)

    for (var value of formData.values()) {
        console.log(value);
    }

    fetch("/inventario/updateProduct", {
            method: 'POST',
            body: formData
        }).then(resp => resp.json())
        .then(resp => {
            console.log(resp);
        })
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
    let filesImageHidden = document.getElementById('filesImageHidden')
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
    // console.log(filesImageHidden.files);

    for (var i = 0; i < filesImageHidden.files.length; i++) {
        // console.log(filesImageHidden.files[i]);
        let reader = new FileReader();
        reader.readAsDataURL(filesImageHidden.files[i]); // convert to base64 string
        let index = i
        reader.onload = function (e) {
            let image = e.target.result
            let img = `<div class="imgContainerChildren imgWrapper shadow">
            <span class="shadow-sm" data-url="${image}" data-index="${index}">x</span>
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

function makeBlobFile(url){
    
fetch(url)
.then(res => res.blob())
.then(blob => {
  const file = new File([blob], makeid(8), blob)
  console.log(file)
  return file
})
}
function makeid(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
       result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
 }
 