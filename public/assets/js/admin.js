//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
/////////////////////////----GASTOS----///////////////////////////////
//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////

$('#bodyContent').on("click", "#addNewLineGasto", function (e) {
	e.preventDefault();
	addNewLineGasto(e)
})

$('#bodyContent').on("click", "#btnSaveGastos", function (e) {
	e.preventDefault();
	SaveGastos(e)
})
$('#bodyContent').on("dblclick", ".gastosLabel", function (e) {
	$(this).prop('contenteditable', true)
	$(this).focus()
})

//DETECTA EL DOBLE CLICK EN TOUCH
var touchtime = 0;
$('#bodyContent').on("click", ".gastosLabel", function () {
	if (touchtime == 0) {
		touchtime = new Date().getTime();
	} else {
		if (((new Date().getTime()) - touchtime) < 800) {

			//AQUI SE EJECUTA LA FUNCION SI SE CUMPLE EL DOBLE CLICK
			$(this).prop('contenteditable', true)
			$(this).focus()
			touchtime = 0;
		} else {
			touchtime = 0;
		}
	}
});



$('#bodyContent').on("keypress", ".gastosLabel", function (e) {
	if (e.charCode == 13) {
		$(this).prop('contenteditable', false)
	}
})
$('#bodyContent').on("blur", ".gastosLabel", function (e) {
	$(this).prop('contenteditable', false)

})
$('#bodyContent').on("click", ".RemoveInputGastos", function (e) {
	$(this).parent().remove()
	totalGastosLabel()

})

$('#bodyContent').on("blur", ".inputGastos", function (e) {
	if (this.value == '') this.value = 0.00
	e.preventDefault();
	this.value = parseFloat(this.value.replace(/,/g, ""))
		.toFixed(2)
		.toString()
		.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	totalGastosLabel()
	//document.getElementById("display").value = this.value.replace(/,/g, "")
})

function addNewLineGasto(e) {
	let nombre = $("#txtAddNewLineGasto").val()
	let inputRow = ` <div class="input-group mb-3 col-lg-12 col-md-12 col-sm-12">
                        <div class="input-group-prepend tagNameGastos">
                            <span class="input-group-text gastosLabel" data-toggle="tooltip" data-placement="bottom" title="Doble click para cambiar nombre" id="inputGroup-sizing-default">${nombre}</span>
                            <span class="input-group-text">₡</span>
                        </div>
                        <input type="text" class="form-control inputGastos" data-name="${nombre}" value="0.00">
                        <div class="RemoveInputGastos">x</div>
                    </div>`
	$("#inputGroupGastos").append(inputRow)
}

function SaveGastos() {
	let items = []
	$(".inputGastos").each((i, item) => {
		let name = $(item).parent().children('.tagNameGastos').children('span.gastosLabel').text();
		let value = item.value.trim()
		//name = name.replace(',', '')
		name = name.replace(':', '')
		if (value == 'NaN') value = 0.00
		let data = `${name.trim()}:${value}`
		items.push(data.replace(',', ''))
	})
	let formData = new FormData()
	formData.append("gastos", items)
	fetch("/admin/gastos/saveGastos", {
			method: "POST",
			body: formData
		}).then(resp => resp.json())
		.then(resp => {
			if (resp.error == '00000') {
				Swal.fire({
					position: 'top',
					icon: 'success',
					title: 'Datos Guardados correctamente',
					showConfirmButton: true,
					timer: 1500
				})
			} else {
				Swal.fire({
					position: 'top',
					icon: 'error',
					title: 'Error al Guardar los datos',
					text: resp.errorMsg,
					showConfirmButton: true,
					timer: 1500
				})
			}
		})
}

function totalGastosLabel(amount) {
	let total = parseFloat(0.00)
	$(".inputGastos").each((i, item) => {
		let valor = $(item).val();
		valor = parseFloat(valor.replace(',', ''))
		total = parseFloat(total + valor)
	})
	total = total
		.toFixed(2)
		.toString()
		.replace(/\B(?=(\d{3})+(?!\d))/g, ",");


	$("#bodyContent #totalGastosLabel").text('₡ ' + total)
}

//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
///////////////////////----END GASTOS----/////////////////////////////
//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
//////////////////----CATEGORIA DE PRECIOS----////////////////////////
//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////

$('#bodyContent').on("click", "#addNewLineCategoriaPrecio", function (e) {
	e.preventDefault();
	addNewLineCategoriaPrecio(e)
})
$('#bodyContent').on("click", ".EditCategoriaPreciosBtn", function (e) {
	e.preventDefault();
	LoadEditCategoriaPrecio(e)
})
$('#bodyContent').on("click", ".DeleteCategoriaPreciosBtn", function (e) {
	e.preventDefault();
	let id = e.target.dataset.id;
	DeleteCategoriaPrecio(id)
})
$('#bodyContent').on("click", "#editCategoriaPrecio_save", function (e) {
	e.preventDefault();
	SaveEditLineCategoriaPrecio(e)
})

function RefreshCategoriaPrecios() {
	fetch("/admin/categoriaprecios", {
			method: "POST"
		}).then(resp => resp.text())
		.then(resp => {
			$(".bodyContent").html(resp)
		})
}

function addNewLineCategoriaPrecio(e) {
	let descripcion = $("#txtDescripcionCategoriaPrecio").val()
	let factor = $("#txtFactorCategoriaPrecio").val()


	if (factor !== "" && descripcion !== "") {
		let formData = new FormData()
		formData.append("descripcion", descripcion)
		formData.append("factor", factor)
		fetch("/admin/categoriaprecios/add", {
				method: "POST",
				body: formData
			}).then(resp => resp.json())
			.then(resp => {
				if (resp.error == '00000') {
					RefreshCategoriaPrecios()
					Swal.fire({
						position: 'top',
						icon: 'success',
						title: 'Datos Guardados correctamente',
						showConfirmButton: true,
						timer: 1500
					})

				} else {
					RefreshCategoriaPrecios()
					Swal.fire({
						position: 'top',
						icon: 'error',
						title: 'Error al Guardar los datos',
						text: resp.errorMsg,
						showConfirmButton: true,
					})
				}

			})
	} else {
		Swal.fire({
			position: 'top',
			icon: 'error',
			title: 'Los campos deben contener informacion',
			showConfirmButton: true,
		})
	}
}

function loadTableCategoriasPrecios(e) {

	fetch("/admin/categoriaprecios/table", {
			method: "POST",
		}).then(resp => resp.text())
		.then(resp => {
			$("#bodyContent .tableJoin").html(resp)
			$(`#editCategoriaPrecios`).modal('toggle')
		})
}

function DeleteCategoriaPrecio(id) {
	let formData = new FormData()
	formData.append("id", id)
	fetch("/admin/categoriaprecios/delete", {
			method: "POST",
			body: formData
		}).then(resp => resp.json())
		.then(resp => {

			if (resp.error == '00000') {
				Swal.fire({
					position: 'top',
					icon: 'success',
					title: 'Datos Guardados correctamente',
					showConfirmButton: true,
					timer: 1500
				})
			} else if (resp.errorMsg[1] == '1451') {
				Swal.fire({
					position: 'top',
					icon: 'error',
					title: 'Error al eliminar la categoria',
					text: "No se puede eliminar la categoria, por que existen productos dependientes de la misma.",
					showConfirmButton: true,
				})
			}
		})
}

function LoadEditCategoriaPrecio(e) {
	let descripcionLabel = document.getElementById("editCategoriaPrecio_descripcion_label")
	let descripcion = document.getElementById("editCategoriaPrecio_descripcion")
	let factor = document.getElementById("editCategoriaPrecio_factor")
	let id = document.getElementById("editCategoriaPrecio_id")
	descripcion.value = e.target.dataset.descripcion
	descripcionLabel.innerText = `Editar Categoria de precio #${e.target.dataset.id}`
	factor.value = e.target.dataset.factor
	id.value = e.target.dataset.id
}

function SaveEditLineCategoriaPrecio(e) {
	let descripcion = $("#editCategoriaPrecio_descripcion").val()
	let factor = $("#editCategoriaPrecio_factor").val()
	let id = $("#editCategoriaPrecio_id").val()
	let formData = new FormData()
	formData.append("descripcion", descripcion)
	formData.append("factor", factor)
	formData.append("id", id)
	fetch("/admin/categoriaprecios/edit", {
			method: "POST",
			body: formData
		}).then(resp => resp.json())
		.then(resp => {

			if (resp.error == '00000') {
				Swal.fire({
					position: 'top',
					icon: 'success',
					title: 'Datos Guardados correctamente',
					showConfirmButton: true,
					timer: 1500
				})
				loadTableCategoriasPrecios(e)
			} else {
				Swal.fire({
					position: 'top',
					icon: 'error',
					title: 'Error al Guardar los datos',
					text: resp.errorMsg,
					showConfirmButton: true,
					timer: 1500
				})
			}
		})
}

//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
////////////////----END CATEGORIA DE PRECIOS----//////////////////////
//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
///////////////////----CATEGORIA Y TALLAS----/////////////////////////
//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////


$('#bodyContent').on("click", "#addNewLineCategoriaBtn", function (e) {
	e.preventDefault();
	addCategoria(e)
})
$('#bodyContent').on("click", "#addNewLineTallaBtn", function (e) {
	e.preventDefault();
	addTalla(e)
})
$('#bodyContent').on("click", "#editCategoriasModal_save", function (e) {
	e.preventDefault();
	editCategoriasModal_save(e)
})
$('#bodyContent').on("click", "#editTallasModal_save", function (e) {
	e.preventDefault();
	editTallasModal_save(e)
})
$('#bodyContent').on("click", ".EditCategoriaBtn", function (e) {
	e.preventDefault();
	let id = e.target.dataset.id
	let descripcion = e.target.dataset.descripcion
	let inputId = document.getElementById('editCategoriasModal_id')
	let inputCategoria = document.getElementById('editCategoriasModal_descripcion')
	inputId.value = id
	inputCategoria.value = descripcion
})
$('#bodyContent').on("click", ".EditTallasBtn", function (e) {
	e.preventDefault();
	let id = e.target.dataset.id
	let descripcion = e.target.dataset.descripcion
	let talla = e.target.dataset.talla
	let inputId = document.getElementById('editTallasModal_id')
	let inputDescripcion = document.getElementById('editTallasModal_descripcion')
	let inputTalla = document.getElementById('editTallasModal_talla')
	inputId.value = id
	inputDescripcion.value = descripcion
	inputTalla.value = talla
})

function addTalla() {
	let descripcion = document.getElementById('txtDescripcionTalla').value
	let talla = document.getElementById('txtTallaMedida').value
	if (descripcion.length > 0 && talla.length > 0) {
		let formData = new FormData()
		formData.append("talla", talla.toUpperCase())
		formData.append("descripcion", descripcion)
		fetch("/admin/categoriastallas/AddTalla", {
				method: "POST",
				body: formData
			}).then(resp => resp.json())
			.then(resp => {
				if (resp.error == '00000') {
					Swal.fire({
						position: 'top',
						icon: 'success',
						title: 'Datos Guardados correctamente',
						showConfirmButton: true,
						timer: 1500
					})
					RefreshCategoriaTallas()
				} else if (resp.errorMsg[1] == '1451') {
					Swal.fire({
						position: 'top',
						icon: 'error',
						title: 'Error al Ingresar la nueva talla',
						text: "No se puede eliminar la categoria, por que existen productos dependientes de la misma.",
						showConfirmButton: true,
					})
				}
			})
	} else {
		Swal.fire({
			position: 'top',
			icon: 'error',
			title: 'Error al Ingresar la Talla',
			text: (descripcion.length > 0 ? "Debes Ingresar una talla" : (talla.length > 0 ? "Debes ingresar una descripcion" : "Debes ingresar una descripcion y talla")),
			showConfirmButton: true,
		})
	}
}

function addCategoria() {
	let categoria = document.getElementById('txtDescripcionCategoria').value
	if (categoria.length > 0) {
		let formData = new FormData()
		formData.append("categoria", categoria)
		fetch("/admin/categoriastallas/AddCategoria", {
				method: "POST",
				body: formData
			}).then(resp => resp.json())
			.then(resp => {
				if (resp.error == '00000') {
					Swal.fire({
						position: 'top',
						icon: 'success',
						title: 'Datos Guardados correctamente',
						showConfirmButton: true,
						timer: 1500
					})
					RefreshCategoriaTallas()
				} else if (resp.errorMsg[1] == '1451') {
					Swal.fire({
						position: 'top',
						icon: 'error',
						title: 'Error al Ingresar la categoria',
						text: "No se puede eliminar la categoria, por que existen productos dependientes de la misma.",
						showConfirmButton: true,
					})
				}
			})
	} else {
		Swal.fire({
			position: 'top',
			icon: 'error',
			title: 'Error al Ingresar la categoria',
			text: "Debes ingresar un nombre de categoria.",
			showConfirmButton: true,
		})
	}
}

function editCategoriasModal_save() {
	let id = document.getElementById('editCategoriasModal_id').value
	let categoria = document.getElementById('editCategoriasModal_descripcion').value
	let formData = new FormData()
	formData.append("categoria", categoria)
	formData.append("id", id)
	fetch("/admin/categoriastallas/editCategoria", {
			method: "POST",
			body: formData
		}).then(resp => resp.json())
		.then(resp => {
			if (resp.error == '00000') {
				$(`#editCategoriasModal`).modal('toggle')
				RefreshCategoriaTallas()
				Swal.fire({
					position: 'top',
					icon: 'success',
					title: 'Datos Guardados correctamente',
					showConfirmButton: true,
					timer: 1500
				})

			} else {
				Swal.fire({
					position: 'top',
					icon: 'error',
					title: 'Error al Editar la categoria',
					showConfirmButton: true,
				})
			}
		})
}

function editTallasModal_save() {
	let id = document.getElementById('editTallasModal_id').value
	let descripcion = document.getElementById('editTallasModal_descripcion').value
	let talla = document.getElementById('editTallasModal_talla').value
	let formData = new FormData()
	formData.append("id", id)
	formData.append("descripcion", descripcion)
	formData.append("talla", talla)
	fetch("/admin/categoriastallas/editTallas", {
			method: "POST",
			body: formData
		}).then(resp => resp.json())
		.then(resp => {
			if (resp.error == '00000') {
				$(`#editTallasModal`).modal('toggle')
				RefreshCategoriaTallas()
				Swal.fire({
					position: 'top',
					icon: 'success',
					title: 'Datos Guardados correctamente',
					showConfirmButton: true,
					timer: 1500
				})

			} else {
				Swal.fire({
					position: 'top',
					icon: 'error',
					title: 'Error al Editar la talla',
					showConfirmButton: true,
				})
			}
		})
}

function RefreshCategoriaTallas() {
	fetch("/admin/categoriastallas/table", {
			method: "POST"
		}).then(resp => resp.text())
		.then(resp => {
			$(".bodyContent").html(resp)
		})
}

//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
/////////////////----END CATEGORIA Y TALLAS----///////////////////////
//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
////////////////////////----GENERAL----///////////////////////////////
//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
$("#bodyContent").on("click", "#btnSaveGeneralInfo", SaveGeneralInfo)

function SaveGeneralInfo() {
	let formData = new FormData(document.getElementById("generalData"))
	fetch("/admin/general/SaveGeneralInfo", {
			method: "POST",
			body: formData
		}).then(resp => resp.json())
		.then(resp => {
			if (resp.error == '00000') {
				Swal.fire({
					position: 'top',
					icon: 'success',
					title: 'Datos Guardados correctamente',
					showConfirmButton: true,
					timer: 1500
				})

			} else {
				Swal.fire({
					position: 'top',
					icon: 'error',
					title: 'Error al Guardar',
					showConfirmButton: true,
				})
			}
		})
}

//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
////////////////////////----END GENERAL----///////////////////////////
//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
/////////////////////////----DESCUENTOS----///////////////////////////
//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////

$('#bodyContent').on("click", "#newDescuento", function (e) {
	$("#descuentos_AddDescuento").modal("toggle")
})
$('#bodyContent').on("click", ".EditDescuentoBtn", function (e) {
	let id = document.getElementById('descuento_Edit_id')
	let descripcion = document.getElementById('descuentos_Edit_descripcion')
	let descuento = document.getElementById('descuentos_Edit_descuento')
	let activo = document.getElementById('descuentos_Edit_activo')
	let show = document.getElementById('descuentos_Edit_show')
	let Btn_id = this.dataset.id
	let Btn_descripcion = this.dataset.descripcion
	let Btn_descuento = this.dataset.descuento
	let Btn_activo = this.dataset.activo
	let Btn_show = this.dataset.show
	id.value = Btn_id
	descripcion.value = Btn_descripcion
	descuento.value = Btn_descuento
	activo.checked = (Btn_activo == 1 ? true : false)
	show.checked = (Btn_show == 1 ? true : false)
	$("#descuentos_EditDescuento").modal("toggle")

})
$('#bodyContent').on("click", "#btnCrearDescuento", function (e) {
	addnewDescuento()
})
$('#bodyContent').on("click", "#btnEditarDescuento", function (e) {
	EditarDescuento()
})
$('#bodyContent').on("click", "#buscarProductoBtn", function (e) {
	$("#SearchProductModalGeneral").modal("toggle")
})

function addnewDescuento() {
	let form = document.getElementById("descuentos_form_AddDescuento")
	let formData = new FormData(form)
	fetch("/admin/descuentos/addnewDescuento", {
			method: "POST",
			body: formData
		}).then(resp => resp.json())
		.then(resp => {
			if (resp.error == '00000') {
				$("#descuentos_AddDescuento").modal("toggle")
				loadPage(null, "/admin/descuentos")
				Swal.fire({
					position: 'top',
					icon: 'success',
					title: 'Datos Guardados correctamente',
					showConfirmButton: true,
					timer: 1500
				})

			} else {
				Swal.fire({
					position: 'top',
					icon: 'error',
					title: 'Error al Guardar',
					showConfirmButton: true,
				})
			}
		})
}

function EditarDescuento() {
	let formData = new FormData(document.getElementById("descuentos_form_EditDescuento"))
	fetch("/admin/descuentos/EditarDescuento", {
			method: "POST",
			body: formData
		}).then(resp => resp.json())
		.then(resp => {
			if (resp.error == '00000') {
				$("#descuentos_EditDescuento").modal("toggle")
				loadPage(null, "/admin/descuentos")
				Swal.fire({
					position: 'top',
					icon: 'success',
					title: 'Datos editados correctamente',
					showConfirmButton: true,
					timer: 1500
				})

			} else {
				Swal.fire({
					position: 'top',
					icon: 'error',
					title: 'Error al editar',
					showConfirmButton: true,
				})
			}
		})
}

function SearchProductModalGeneral(toSearch, page) {
	let formData = new FormData()
	let initLimit = page

	formData.append("toSearch", toSearch)
	formData.append("initLimit", initLimit)
	fetch("/facturacion/search/product/ctrlq", {
			method: "POST",
			body: formData
		}).then(resp => resp.json())
		.then(resp => {
			$('#contentSearchGeneral').html('')
			let paginacion = resp.paginacion
			let items = `<li class="page-item pre_nex ${resp.previouspage <= 0? 'disabled' : ''}" data-minpage="1" data-page="${resp.previouspage <= 0 ? 1 : resp.previouspage}"><p class="page-link">Previous</p></li>`
			for (let index = 0; index < paginacion.paginas; index++) {
				let pageNow = index + 1
				items += `<li class="page-item paginationBtn ${pageNow == page? 'active' : ''}" data-page="${index+1}"><a class="page-link" href="#">${index+1}</a></li>`

			}
			items += `<li class="page-item pre_nex ${resp.nextpage > paginacion.paginas ? 'disabled' : ''}" data-maxpage="${paginacion.paginas }" data-page="${resp.nextpage >= paginacion.paginas ? paginacion.paginas : resp.nextpage}"><p class="page-link">Next</p></li>`

			resp.data.map((el, i) => {
				let url = el.image_url.split(',')
				let producto = `    <div class="col-6 ">
                                        <div class="card mb-3 generalSearch codeToAddInputSearchCard2" style="width: 100%;" data-marca="${el.marca}" data-estilo="${el.estilo}" data-codigo="${el.codigo}"  data-descripcion="${el.descripcion}"  data-descuento="${(el.descuento > 0 ?el.descuento:'N/A')}" data-precio="${el.precio_venta}">
                                        <div class="row no-gutters">
                                            <div class="col-md-4 cardImgBody">
                                            <img src="${(url[0]==""?"/public/assets/img/not-found.png":url[0])}" class="card-img" alt="...">
                                            </div>
                                            <div class="col-md-8">
                                            <div class="card-body">
                                                <h6 class="card-title">${el.descripcion}</h6>
                                                <p class="${el.precio_venta<1?"text-danger":""}">₡ ${el.precio_venta} |  Stock:${el.stock} </p>
                                                <span class="icon_codeToAddInputSearch"><span class="codeToAddInputSearch2">${el.codigo}</span></span>
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

				$('#contentSearchGeneral').append(producto)
			})
			$('#paginationModal').html('')
			$('#paginationModal').html(items)
		})
}
$('#bodyContent').on("click", "#SearchProductInputCtrlQBtnGeneral", function (e) {
	SearchProductModalGeneral("", 1)

})
$('#bodyContent').on("click", "#paginationModal .paginationBtn", function (e) {
	let valueInput = document.getElementById('SearchProductInputCtrlQGeneral').value
	SearchProductModalGeneral(valueInput, this.dataset.page)



})
$('#bodyContent').on("click", "#paginationModal .pre_nex", function (e) {
	let valueInput = document.getElementById('SearchProductInputCtrlQGeneral').value

	SearchProductModalGeneral(valueInput, this.dataset.page)

})
$('#bodyContent').on("click", ".deleteProductoDescuentoBtn", function (e) {
	let id = this.dataset.id
	let tr = document.getElementById(`tr_${id}`)
	tr.remove()

})
$('#bodyContent').on("click", "#aplicarDescuento", function (e) {
	aplicarDescuento()

})
$('#bodyContent').on("keypress", "#SearchProductInputCtrlQGeneral", function (e) {
	if (e.charCode == 13) {
		SearchProductModalGeneral(this.value, 1)

	}

})
$('#bodyContent').on("click", ".generalSearch", function (e) {
	let codigo = this.dataset.codigo
	let descripcion = this.dataset.descripcion
	let descuento = this.dataset.descuento
	let marca = this.dataset.marca
	let estilo = this.dataset.estilo
	let tbody = document.getElementById("tbodyDescuentosPorlote")
	let tr = document.createElement('tr')
	this.style.border = '2px solid green'
	tr.id = `tr_${codigo}`
	tr.innerHTML = `
			<td scope="row" style="text-align: center;">${codigo}</td>
			<td scope="row" style="text-align: left;">${descripcion}</td>
			<td scope="row" style="text-align: center;">${marca}</td>
			<td scope="row" style="text-align: center;">${estilo}</td>
			<td scope="row" style="text-align: center;">${descuento}</td>
			<td scope="row">
			<div class="btn-group" aria-label="Grupo edicion"> 
				<button type="button" class="btn btn-danger deleteProductoDescuentoBtn" data-id="${codigo}" >X</button>
            </div>
          </td>

`
	//console.log(codigo, descripcion, descuento);
	tbody.appendChild(tr)
	//console.log(codigo);



})

function aplicarDescuento() {
	let formData = new FormData()
	let tbody = document.getElementById("tbodyDescuentosPorlote")
	let select = document.getElementById("iddescuentoSelect")
	let id = select.options[select.selectedIndex].value
	let childrens = tbody.getElementsByTagName('tr')
	let codigos = ''
	if (id == 0 || id == "") {
		Swal.fire({
			position: 'top',
			icon: 'error',
			title: 'Seleccione un descuento antes de aplicar el cambio',
			showConfirmButton: true,
		})
		return
	}

	for (let i = 0; i < childrens.length; i++) {
		let item = childrens[i]
		codigos += parseInt(item.id.split('_')[1]) + (i == childrens.length - 1 ? "" : ",")
		//console.log(item.id)
	}
	if (codigos.length == 0) {
		Swal.fire({
			position: 'top',
			icon: 'error',
			title: 'Debe seleccionar almenos un producto',
			showConfirmButton: true,
		})
		return
	}
	formData.append("codigos", codigos)
	formData.append("iddescuento", id)
	fetch("/admin/descuentos/aplicarDescuentoEnLote", {
			method: "POST",
			body: formData
		}).then(resp => resp.json())
		.then(resp => {
			if (resp.error == '00000') {
				$("#descuentos_EditDescuento").modal("toggle")
				// loadPage(null, "/admin/descuentos/lote")
				Swal.fire({
					position: 'top',
					icon: 'success',
					title: 'Descuentos agregados correctamente',
					showConfirmButton: true,
					timer: 1500
				})

			} else {
				Swal.fire({
					position: 'top',
					icon: 'error',
					title: 'Error al agregar los descuentos',
					showConfirmButton: true,
				})
			}
		})
}