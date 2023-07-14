const frmDetalle = document.querySelector('#formulario_detalle');
const btnServicio = document.querySelector('#btnServicio');

const modalRegistroServicio = document.querySelector("#modalRegistroServicio");
const myModalRegistroServicio = new bootstrap.Modal(modalRegistroServicio);

const editarModalServicio = document.querySelector("#editarModal");
const myModal2editarModalServicio = new bootstrap.Modal(editarModalServicio);

document.addEventListener('DOMContentLoaded', function (){
     
    btnServicio.addEventListener('click',function(){
        title.textContent= "Nuevo Servicio"
        frmDetalle.id_cliente.value = '';
        frmDetalle.removeAttribute('readonly');
        frmDetalle.reset();
        myModalRegistroServicio.show();
    })

    

    frmDetalle.addEventListener('submit', function(event) {
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
