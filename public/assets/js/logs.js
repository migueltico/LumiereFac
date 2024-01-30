$(document).ready(function () {
	// Utilizar el contenedor #bodyContent para delegar el evento al botón
	$("#bodyContent").on("click", "#btnSearchLogs", function () {
		console.log("click");
		let startDate = $("#startDate");
		let endDate = $("#endDate");
		let accion = $("#accion");
		let modulo = $("#modulo");
		let usuario = $("#usuario");
		let currentPage = $("#currentPage");
		let perPage = $("#perPage");

		// Verificar la existencia de los elementos antes de acceder a ellos
		if (
			!startDate.length ||
			!endDate.length ||
			!accion.length ||
			!modulo.length ||
			!usuario.length
		) {
			console.error("Alguno de los elementos no existe en el DOM.");
			return;
		}

		let formData = new FormData();

		// Validar que usuario sea un número
		if (usuario.val() !== "") {
			if (isNaN(usuario.val())) {
				usuario.val("");
				swal.fire({
					position: "top",
					title: `El campo usuario debe ser un número`,
					icon: "error",
					confirmButtonText: "OK",
					timer: 2500,
					timerProgressBar: true,
				});
				return false;
			}
		}

		formData.append("startDate", startDate.val());
		formData.append("endDate", endDate.val());
		formData.append("accion", accion.val());
		formData.append("modulo", modulo.val());
		formData.append("usuario", usuario.val());
		formData.append("currentPage", 1);
		formData.append("perPage", perPage.val());

		const url = "/historial/getLogs";
		const settings = {
			method: "POST",
			body: formData,
		};

		fetch(url, settings)
			.then((response) => response.text())
			.then((data) => {
				// data is full table html content
				console.log(data);
				let container = $(".loadTable");
				container.html("");
				if (container.length) {
					container.html(data);
					document.getElementById("currentPage").value = 1;
				}
			})
			.catch((error) => {
				console.error("Error:", error);
			});

		// Aquí puedes continuar con el código para enviar los datos
	});

	$("#bodyContent").on("click", "#btnMoreRows", function () {
		console.log("click");
		let startDate = $("#startDate");
		let endDate = $("#endDate");
		let accion = $("#accion");
		let modulo = $("#modulo");
		let usuario = $("#usuario");
		let currentPage = $("#currentPage");
		let perPage = $("#perPage");
		// Verificar la existencia de los elementos antes de acceder a ellos
		if (
			!startDate.length ||
			!endDate.length ||
			!accion.length ||
			!modulo.length ||
			!usuario.length
		) {
			console.error("Alguno de los elementos no existe en el DOM.");
			return;
		}

		let formData = new FormData();

		// Validar que usuario sea un número
		if (usuario.val() !== "") {
			if (isNaN(usuario.val())) {
				usuario.val("");
				swal.fire({
					position: "top",
					title: `El campo usuario debe ser un número`,
					icon: "error",
					confirmButtonText: "OK",
					timer: 2500,
					timerProgressBar: true,
				});
				return false;
			}
		}

		formData.append("startDate", startDate.val());
		formData.append("endDate", endDate.val());
		formData.append("accion", accion.val());
		formData.append("modulo", modulo.val());
		formData.append("usuario", usuario.val());
		formData.append("currentPage", Number(currentPage.val()) + 1);
		formData.append("perPage", perPage.val());

		const url = "/historial/getLogsRows";
		const settings = {
			method: "POST",
			body: formData,
		};

		fetch(url, settings)
			.then((response) => response.text())
			.then((data) => {
				// data is full table html content
				console.log(data);
				let container = $("#logsTable");
				if (container.length) {
					container.append(data);
					document.getElementById("currentPage").value =
						Number(currentPage.val()) + 1;
						let newScrolltoDown = $("#bodyMain").scrollTop() + 20;
						$("body,html,#bodyMain").animate(
							{
									scrollTop: newScrolltoDown,
							},
							800, // Duración de la animación en milisegundos
							"swing" // Tipo de animación ("linear", "swing")
					);
				}
			})
			.catch((error) => {
				console.error("Error:", error);
			});

		// Aquí puedes continuar con el código para enviar los datos
	});

	$("#bodyContent").on("click", "#btnGoTop", function () {
		console.log("click");
		//scroll to top smoothly
		$("body,html,#bodyMain").animate(
			{
					scrollTop: 0,
			},
			800, // Duración de la animación en milisegundos
			"swing" // Tipo de animación ("linear", "swing")
	);

	});
});
