const frmDetalle = document.querySelector('#formulario_detalle');
const btnServicio = document.querySelector('#btnServicio');
const title = document.querySelector('#title');

const modalRegistroServicio = document.querySelector("#modalRegistroServicio");
const myModal = new bootstrap.Modal(modalRegistroServicio);

const editarModalServicio = document.querySelector("#editarModal");
const myModal2 = new bootstrap.Modal(editarModalServicio);

document.addEventListener('DOMContentLoaded', function (){
     
    btnServicio.addEventListener('click',function(){
        title.textContent= "Nuevo Servicio"
        frmDetalle.id_cliente.value = '';
        frmDetalle.removeAttribute('readonly');
        frmDetalle.reset();
        myModal.show();
    })

    

    frmDetalle.addEventListener('submit', function() {
    

        if (frmDetalle.equipo.value === '' || frmDetalle.problema.value === '' || frmDetalle.refacciones.value === '' || frmDetalle.fecha.value === '' || frmDetalle.observacion.value === ''|| frmDetalle.costo.value === '' || frmDetalle.estatus_detalle.value === '') {
            alertaPerzonalizada('warning', 'Todos los campos son requeridos');
        } else {
            const data = new FormData(frm);
            const url = 'guardar_detalle.php';
    
            fetch(url, {
                    method: 'POST',
                    body: data
                })
                .then(response => response.json())
                .then(res => {
                    alertaPerzonalizada(res.tipo, res.mensaje);
                    if (res.tipo == 'success') {
                        frmDetalle.reset();
                        myModal.hide();
                        //location.reload(); // Recargar la página completa
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    });
})