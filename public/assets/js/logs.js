$(document).ready(function () {

	// Utilizar el contenedor #bodyContent para delegar el evento al botón
	$("#bodyContent").on('click', '#btnSearchLogs', function () {
			console.log('click');
			let startDate = $('#startDate');
			let endDate = $('#endDate');
			let accion = $('#accion');
			let modulo = $('#modulo');
			let usuario = $('#usuario');

			// Verificar la existencia de los elementos antes de acceder a ellos
			if (!startDate.length || !endDate.length || !accion.length || !modulo.length || !usuario.length) {
					console.error('Alguno de los elementos no existe en el DOM.');
					return;
			}

			let formData = new FormData();

			// Validar que usuario sea un número
			if (usuario.val() !== '') {
					if (isNaN(usuario.val())) {
							usuario.val('');
							swal.fire({
									position: 'top',
									title: `El campo usuario debe ser un número`,
									icon: 'error',
									confirmButtonText: 'OK',
									timer: 2500,
									timerProgressBar: true
							});
							return false;
					}
			}

			formData.append('startDate', startDate.val());
			formData.append('endDate', endDate.val());
			formData.append('accion', accion.val());
			formData.append('modulo', modulo.val());
			formData.append('usuario', usuario.val());

			const url = '/historial/getLogs';
			const settings = {
					method: 'POST',
					body: formData
			};

			fetch(url, settings)
					.then(response => response.text())
					.then(data => { // data is full table html content
							console.log(data);
							let container = $('.loadTable');
							container.html('');
							if (container.length) {
									container.html(data);
							}
					})
					.catch(error => {
							console.error('Error:', error);
					});

			// Aquí puedes continuar con el código para enviar los datos
	});
});
