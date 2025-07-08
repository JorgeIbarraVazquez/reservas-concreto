let calendar; // variable global

document.addEventListener("DOMContentLoaded", function () {
  fetch("api/calendar.php")
    .then((res) => res.json())
    .then((data) => {
      const events = Object.entries(data).map(([date, available]) => ({
        title: available ? "Disponible" : "Ocupado",
        start: date,
        color: available ? "#28a745" : "#dc3545",
        editable: false,
      }));

      const calendarEl = document.getElementById("calendar");
      calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
        locale: "es",
        initialDate: "2025-09-01",
        headerToolbar: {
          left: "prev,next today",
          center: "title",
          right: "",
        },
        events: events,
        eventClick: function (info) {
          const fecha = info.event.startStr;
          if (info.event.title === "Disponible") {
            loadSchedule(fecha);
          }
          cargarReservasDelDia(fecha); // ← nueva función
        },
      });

      calendar.render();
    });
});

//Recargar eventos en el calendario
function recargarCalendario() {
  fetch("api/calendar.php")
    .then((res) => res.json())
    .then((data) => {
      const nuevosEventos = Object.entries(data).map(([fecha, disponible]) => ({
        title: disponible ? "Disponible" : "Ocupado",
        start: fecha,
        color: disponible ? "#28a745" : "#dc3545",
      }));

      calendar.removeAllEvents(); // Elimina eventos actuales
      calendar.addEventSource(nuevosEventos); // Agrega los actualizados
    });
}

function cargarReservasDelDia(fecha) {
  fetch(`api/reservasPorFecha.php?date=${fecha}`)
    .then(res => res.json())
    .then(reservas => {
      // Guarda datos temporalmente con índices confiables
      window.reservasDiaSeleccionado = reservas;

      const lista = document.getElementById("listaReservas");
      lista.innerHTML = reservas.length > 0
        ? reservas.map((r, i) =>
            `<li class="list-group-item list-group-item-action" onclick="verDetalleReserva(${i})">
              <strong>${r.time}</strong> - ${r.name}
            </li>`).join('')
        : '<li class="list-group-item">No hay reservas para este día</li>';
    });
}

function verDetalleReserva(index) {
  const reserva = window.reservasDiaSeleccionado[index];
  Swal.fire({
    title: "📄 Detalle de Reserva",
    html: `
      <strong>📅 Fecha:</strong> ${reserva.date}<br>
      <strong>🕒 Hora:</strong> ${reserva.time}<br>
      <strong>👤 Nombre:</strong> ${reserva.name}<br>
      <strong>✉️ Correo:</strong> ${reserva.email}<br>
      <strong>📞 Teléfono:</strong> ${reserva.phone}
    `,
    icon: "info"
  });
}
