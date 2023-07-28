const frmDetalle = document.querySelector('#formulario_detalle');

// Obtener referencia al botón de servicio
const btnServicio = document.querySelector('#btnServicio');

// Obtener referencia al modal de registro de servicio y crear su instancia
const modalRegistroServicio = document.querySelector("#modalRegistroServicio");
const myModalRegistroServicio = new bootstrap.Modal(modalRegistroServicio);

// Obtener referencia al modal de edición de servicio y crear su instancia
const editarModalServicio = document.querySelector("#editarModalServicio");
const myModal2editarModalServicio = new bootstrap.Modal(editarModalServicio);

document.addEventListener('DOMContentLoaded', function () {

    btnServicio.addEventListener('click', function () {
        title.textContent = "Nuevo Servicio"
        frmDetalle.id_cliente.value = '';
        frmDetalle.removeAttribute('readonly');
        frmDetalle.reset();
        myModalRegistroServicio.show();
    })

    const btnEditarServicio = document.querySelectorAll('.btnEditarServicio');
    btnEditarServicio.forEach((btn) => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            editarServicio(id); // Asegúrate de que el nombre de la función sea correcto ('editarServicio')
        });
    });


    frmDetalle.addEventListener('submit', function (event) {
        event.preventDefault(); // Evitar que el formulario se envíe de forma predeterminada
        console.log('Formulario enviado');

        if (frmDetalle.equipo.value === '' || frmDetalle.problema.value === '' || frmDetalle.refacciones.value === '' || frmDetalle.fecha.value === '' || frmDetalle.observacion.value === '' || frmDetalle.costo.value === '' || frmDetalle.estatus_detalle.value === '') {
            alertaPersonalizada('warning', 'Todos los campos son requeridos');
        } else {
            const data = new FormData(frmDetalle);
            const url = 'guardar_detalle.php';

            fetch(url, {
                method: 'POST',
                body: data
            })
                .then(res => res.json())
                .then(res => {
                    console.log(res);
                    // Procesar la respuesta JSON
                    const tipo = res.tipo;
                    const mensaje = res.mensaje;

                    // Mostrar la alerta personalizada
                    alertaPersonalizada(tipo, mensaje);

                    if (tipo == 'success') {
                        frmDetalle.reset();
                        myModalRegistroServicio.hide();
                        //location.reload(); // Recargar la página completa
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    });

    function alertaPersonalizada(tipo, mensaje) {
        // Crea un elemento de alerta
        const alert = document.createElement('div');
        alert.className = `alert alert-${tipo}`;
        alert.textContent = mensaje;

        // Agrega el elemento de alerta al documento
        const container = document.querySelector('.alert-container');
        container.appendChild(alert);

        // Elimina el elemento de alerta después de 3 segundos
        setTimeout(() => {
            alert.remove();
        }, 3000);
    }

});

function editarServicio(id) {
    const url = 'editarservicio.php?id=' + id;

    fetch(url, {
        method: 'GET'
    })
        .then(response => response.json())
        .then(data => {
            console.log(data); // Verificar los datos en la consola

            // Actualizar los valores en el modal de edición
            document.querySelector('#id_cliente_editar_servicio').value = data.id;
            document.querySelector('#editarModalServicio input[name="equipo"]').value = data.equipo;
            document.querySelector('#editarModalServicio input[name="problema"]').value = data.problema;
            document.querySelector('#editarModalServicio input[name="refacciones"]').value = data.refacciones;
            document.querySelector('#editarModalServicio input[name="fecha"]').value = data.fecha;
            document.querySelector('#editarModalServicio input[name="observacion"]').value = data.observacion;
            document.querySelector('#editarModalServicio input[name="costo"]').value = data.costo;
            document.querySelector('#editarModalServicio select[name="estatus_detalle"]').value = data.estatus_detalle;

            $('#editarModalServicio').modal('show'); // Mostrar el modal utilizando jQuery
        })
        .catch(error => {
            console.error(error); // Manejar cualquier error de la solicitud
        });
}




// Obtener referencia al formulario de edición
const formularioEditarServicio = document.getElementById('formularioEditarServicio');

formularioEditarServicio.addEventListener('submit', function (event) {
    event.preventDefault(); // Evitar el envío del formulario por defecto

    const formData = new FormData(formularioEditarServicio);

    // Enviar la solicitud de actualización al servidor
    fetch('editarservicio.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            console.log(data); // Verificar la respuesta del servidor

            // Aquí puedes agregar lógica adicional para manejar la respuesta del servidor
            // Por ejemplo, mostrar un mensaje de éxito o actualizar la página después de la actualización

            // Cerrar el modal de edición
            $('#editarModalServicio').modal('hide');

            // Recargar la página
            location.reload();
        })
        .catch(error => {
            console.error(error); // Manejar cualquier error de la solicitud
        });



        // Obtener referencia a todos los botones de eliminación
const btnEliminarServicio = document.querySelectorAll('.btnEliminarServicio');

// Iterar sobre cada botón de eliminación
btnEliminarServicio.forEach(btn => {
  btn.addEventListener('click', function(e) {
    const clienteId = this.dataset.id;
    e.preventDefault(); // Evitar el comportamiento predeterminado del botón

    // Enviar la petición de eliminación utilizando AJAX
    const url = 'eliminarservicio.php'; // URL del archivo PHP que maneja la eliminación
    const data = new FormData();
    data.append('id', clienteId);

    fetch(url, {
      method: 'POST',
      body: data
    })
    .then(response => response.json())
    .then(res => {
      alertaPerzonalizada(res.tipo, res.mensaje);
      if (res.tipo == 'success') {
        // Eliminar el cliente de la interfaz sin recargar la página
        this.closest('tr').remove();
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
  });
});

});



