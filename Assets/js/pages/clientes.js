const frm = document.querySelector('#formulario');
const btnNuevo = document.querySelector('#btnNuevo');
const title = document.querySelector('#title');

const modalRegistro = document.querySelector("#modalRegistro");
const myModal = new bootstrap.Modal(modalRegistro);

const modalEditar = document.querySelector("#editarModal");
const myModal2 = new bootstrap.Modal(modalEditar);


document.addEventListener('DOMContentLoaded', function () {

  let tblClientes;

  btnNuevo.addEventListener('click', function () {
    title.textContent = 'Nuevo Cliente';
    frm.id_cliente.value = '';
    frm.removeAttribute('readonly');
    frm.reset();
    myModal.show();
  })



  frm.addEventListener('submit', function() {
    

    if (frm.nombre.value === '' || frm.apellido.value === '' || frm.telefono.value === '' || frm.domicilio.value === '' || frm.estatus.value === '') {
        alertaPerzonalizada('warning', 'Todos los campos son requeridos');
    } else {
        const data = new FormData(frm);
        const url = 'guardar.php';

        fetch(url, {
                method: 'POST',
                body: data
            })
            .then(response => response.json())
            .then(res => {
                alertaPerzonalizada(res.tipo, res.mensaje);
                if (res.tipo == 'success') {
                    frm.reset();
                    myModal.hide();
                    //location.reload(); // Recargar la página completa
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
});




  function editar(id) {
    const url = 'editar.php?id=' + id;

    fetch(url, {
        method: 'GET'
    })
        .then(response => response.json())
        .then(data => {
            console.log(data); // Verificar los datos en la consola

            // Actualizar los valores en el modal de edición
            document.querySelector('#id_cliente_editar').value = data.id;
            document.querySelector('#editarModal input[name="nombre"]').value = data.nombre;
            document.querySelector('#editarModal input[name="apellido"]').value = data.apellido;
            document.querySelector('#editarModal input[name="telefono"]').value = data.telefono;
            document.querySelector('#editarModal input[name="domicilio"]').value = data.domicilio;
            document.querySelector('#editarModal select[name="estatus"] option[value="' + data.estatus + '"]').selected = true;
            $('#editarModal').modal('show'); // Mostrar el modal utilizando jQuery
        })
        .catch(error => {
            console.error(error); // Manejar cualquier error de la solicitud
        });
}


// Obtener referencia al formulario de edición
const formularioEditar = document.getElementById('formularioEditar');

formularioEditar.addEventListener('submit', function(event) {
  event.preventDefault(); // Evitar el envío del formulario por defecto

  const formData = new FormData(formularioEditar);

  // Enviar la solicitud de actualización al servidor
  fetch('editar.php', {
      method: 'POST',
      body: formData
  })
  .then(response => response.json())
  .then(data => {
      console.log(data); // Verificar la respuesta del servidor

      // Aquí puedes agregar lógica adicional para manejar la respuesta del servidor
      // Por ejemplo, mostrar un mensaje de éxito o actualizar la página después de la actualización

      // Cerrar el modal de edición
      $('#editarModal').modal('hide');

      // Recargar la página
      location.reload();
  })
  .catch(error => {
      console.error(error); // Manejar cualquier error de la solicitud
  });
});






// Asociar el evento de clic a los botones de edición
const btnEditar = document.querySelectorAll('.btnEditar');
btnEditar.forEach((btn) => {
    btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-id');
        editar(id);
    });
});


// Obtener referencia a todos los botones de eliminación
const btnEliminar = document.querySelectorAll('.btnEliminar');

// Iterar sobre cada botón de eliminación
btnEliminar.forEach(btn => {
  btn.addEventListener('click', function(e) {
    const clienteId = this.dataset.id;
    e.preventDefault(); // Evitar el comportamiento predeterminado del botón

    // Enviar la petición de eliminación utilizando AJAX
    const url = 'eliminar.php'; // URL del archivo PHP que maneja la eliminación
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





