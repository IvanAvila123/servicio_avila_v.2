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
})