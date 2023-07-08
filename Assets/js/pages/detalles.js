const formulario_detalle = document.querySelector('#formulario_detalle');
const btnServicio = document.querySelector('#btnServicio');
const title = document.querySelector('#title');

const modalRegistroServicio = document.querySelector("#modalRegistroServicio");
const myModal = new bootstrap.Modal(modalRegistroServicio);

const editarModalServicio = document.querySelector("#editarModal");
const myModal2 = new bootstrap.Modal(editarModalServicio);

document.addEventListener('DOMContentLoaded', function (){
     
    btnServicio.addEventListener('click',function(){
        title.textContent= "Nuevo Servicio"
        formulario_detalle.id_cliente.value = '';
        formulario_detalle.removeAttribute('readonly');
        formulario_detalle.reset();
        myModal.show();
    })

    formulario_detalle.addEventListener('submit', function(){
        if (formulario_detalle.equipo.value === '' || formulario_detalle.problema.value === '' || formulario_detalle.refacciones.value === '' || formulario_detalle.fecha.value === '' || formulario_detalle.observacion.value === '' || formulario_detalle.costo.value === '' || formulario_detalle.estatus.value === '' ) {
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
    })
})