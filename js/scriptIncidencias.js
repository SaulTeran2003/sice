(function () {
    'use strict'
  
    var forms = document.querySelectorAll('.needs-validation')
  
    Array.prototype.slice.call(forms)
      .forEach(function (form) {
        form.addEventListener('submit', function (event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }

          form.classList.add('was-validated')
        }, false)
      })
  })

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'es',
      headerToolbar: {
        left: 'prev, next, today',
        center: 'title',
        right: 'dayGridMonth, timeGridWeek, listWeek'
      },
  
      events: function (fetchInfo, successCallback, failureCallback) {
        var rfc = document.getElementById('rfc').value;
        var numcontrol = document.getElementById('numcontrol').value;
        var fecha = document.getElementById('fecha').value;
    
        fetch('eventosIncidencias.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                rfc: rfc,
                numcontrol: numcontrol,
                fecha: fecha,
            }),
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                // Filtrar eventos basados en RFC
                var eventosFiltrados = data.filter(function (evento) {
                  return evento.rfc === rfc || evento.numcontrol === numcontrol;
                });
    
                // Transformar y devolver eventos
                var eventosTransformados = eventosFiltrados.map(function (evento) {
                    return {
                        title: evento.incidencias,
                        start: evento.fecha,
                        end: evento.endd
                    };
                });
    
                successCallback(eventosTransformados);
            })
            .catch(function (error) {
                console.error("Error al cargar los eventos:", error);
                failureCallback(error);
            });
    },
    
      
          eventColor: 'transparent', // establecer el color de fondo predeterminado
      
          eventContent: function(info) {
          var color;
            switch (info.event.title) {
              case 'Inasistencia':
                color = '#FE0000';
                break;
              case 'Retardo Mayor':
                color = '#ffcc01';
                break;
              case 'Retardo Menor':
                color = '#e96c00';
                break;
              case 'Suspensión':
                color = '#ff9934';
                break;
              case 'Act. Comp.':
                color = '#810000';
                break;
              case 'Comisión':
                color = '#008156';
                break;
              case 'Enfermedad':
                color = '#980065';
                break;
              case 'Cuidados Familiares':
                color = '#71b02d';
                break;
              case 'Justificantes':
                color = '#a62af2';
                break;
              case 'Pago de Tiempo':
                color = '#32009a';
                break;
              case 'Permiso Económico':
                color = '#ff32ff';
                break;
              case 'Rep. pase de salida':
                color = '#2847C8';
                break;
              case 'Pase de salida':
                color = '#244070';
                break;
              case 'Vacaciones':
                color = '#688ecf';
                break;
              case 'Premio':
                color = '#848484';
                break;
            }
            var content = document.createElement('div');
            content.style.backgroundColor = color;
            content.textContent = info.event.title;
            return { domNodes: [content] };
          }
        });
          // Agrega un evento de clic al botón "Consultar"
        document.getElementById('consultarBtn').addEventListener('click', function () {
          event.preventDefault(); // Evita la recarga de la página
          calendar.refetchEvents();
        });

          // Agrega un evento de clic al botón "Consultar Tabla"
  //         document.getElementById('consultarTablaBtn').addEventListener('click', function () {
  //           // Guarda los valores de los campos en sessionStorage para recuperarlos después de la recarga de la página
  //           sessionStorage.setItem('rfc', document.getElementById('rfc').value);
  //           sessionStorage.setItem('numcontrol', document.getElementById('numcontrol').value);
  //           sessionStorage.setItem('fecha', document.getElementById('fecha').value);
  // });
  
  
  //       // Recupera los valores de los campos después de cargar la página
  //       var rfcInput = document.getElementById('rfc');
  //       var numcontrolInput = document.getElementById('numcontrol');
  //       var fechaInput = document.getElementById('fecha');
  
  //       rfcInput.value = sessionStorage.getItem('rfc') || '';
  //       numcontrolInput.value = sessionStorage.getItem('numcontrol') || '';
  //       fechaInput.value = sessionStorage.getItem('fecha') || '';

    calendar.render();
  });

  document.addEventListener('DOMContentLoaded', function () {
    // Agrega un evento de clic al botón "Consultar Tabla"
    document.getElementById('consultarTablaBtn').addEventListener('click', function () {
        // Guarda los valores de los campos en cookies con una duración de 1 minuto
        setCookie('rfc', document.getElementById('rfc').value, 1);
        setCookie('numcontrol', document.getElementById('numcontrol').value, 1);
        setCookie('fecha', document.getElementById('fecha').value, 1);
    });
  
    // Recupera los valores de los campos después de cargar la página
    var rfcInput = document.getElementById('rfc');
    var numcontrolInput = document.getElementById('numcontrol');
    var fechaInput = document.getElementById('fecha');
  
    rfcInput.value = getCookie('rfc') || '';
    numcontrolInput.value = getCookie('numcontrol') || '';
    fechaInput.value = getCookie('fecha') || '';
  });
  
  // Función para establecer una cookie con una duración en minutos
  function setCookie(name, value, minutes) {
    var expires = new Date();
    expires.setTime(expires.getTime() + minutes * 3 * 1000);
    document.cookie = name + '=' + value + ';expires=' + expires.toUTCString();
  }
  
  // Función para obtener el valor de una cookie
  function getCookie(name) {
    var cookies = document.cookie.split(';');
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].trim();
        if (cookie.startsWith(name + '=')) {
            return cookie.substring(name.length + 1);
        }
    }
    return '';
  }


  
