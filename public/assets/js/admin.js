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
			text: (descripcion.length > 0?"Debes Ingresar una talla":(talla.length > 0 ?"Debes ingresar una descripcion":"Debes ingresar una descripcion y talla")),
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