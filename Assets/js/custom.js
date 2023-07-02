function alertaPerzonalizada(type, mensaje) {

  Swal.fire({
    position: 'top-end',
    icon: type,
    title: mensaje,
    showConfirmButton: false,
    timer: 1500
  })

}

function eliminarRegistro(title, text, accion, url, table) {
  Swal.fire({
    title: title,
    text: text,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: accion
  }).then((result) => {
    if (result.isConfirmed) {
      const http = new XMLHttpRequest();

      http.open("GET", url, true);

      http.send();

      http.onreadystatechange = function () {
        console.log('Estado del request:', this.readyState);
        console.log('Código de estado:', this.status);
        console.log('Respuesta:', this.responseText);
        if (this.readyState == 4 && this.status == 200) {
          try {
            const res = JSON.parse(this.responseText);
            console.log('Respuesta parseada:', res);
            alertaPerzonalizada(res.tipo, res.mensaje);
            if (res.tipo == 'success') {
              if (table != null) {
                console.log('Recargando tabla...');
                table.ajax.reload();
              } else {
                console.log('Recargando página...');
                setTimeout(() => {
                  window.location.reload();
                }, 1500);
              }
            }
          } catch (error) {
            console.error('Error al analizar respuesta JSON:', error);
            console.log('Respuesta:', this.responseText);
          }

      };
    }
    }
  });
}