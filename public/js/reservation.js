function loadSchedule(date) {
  fetch(`api/schedule.php?date=${date}`)
    .then((res) => res.json())
    .then((slots) => {
      // Construye lista de horarios dentro del modal
      let opciones = "";
      for (const [hora, disponible] of Object.entries(slots)) {
        if (disponible) {
          opciones += `<option value="${hora}">${hora}</option>`;
        }
      }

      if (!opciones) {
        opciones = `<option disabled>No hay horarios disponibles</option>`;
      }

      // Llena el campo select en el formulario del modal
      const selectHTML = `
        <label for="horaSeleccionada" class="form-label">🕒 Elige un horario</label>
        <select class="form-select mb-2" id="horaSeleccionada" required>
          ${opciones}
        </select>
      `;
      document.querySelector(".modal-body").innerHTML = `
        <input type="hidden" id="fechaSeleccionada" value="${date}">
        ${selectHTML}
        <input type="text" class="form-control mb-2" placeholder="Nombre" id="nombre" required>
        <input type="email" class="form-control mb-2" placeholder="Correo" id="correo" required>
        <input type="tel" class="form-control mb-2" placeholder="Teléfono" id="telefono" required>
      `;

      document.getElementById(
        "reservaLabel"
      ).textContent = `Reserva para ${date}`;
      const modal = new bootstrap.Modal(
        document.getElementById("reservaModal")
      );
      modal.show();
    });
}

function showForm(date, time) {
  document.getElementById("fechaSeleccionada").value = date;
  document.getElementById("horaSeleccionada").value = time;
  document.getElementById(
    "reservaLabel"
  ).textContent = `Reserva para ${date} a las ${time}`;

  const modal = new bootstrap.Modal(document.getElementById("reservaModal"));
  modal.show();
}

document.getElementById("reservaForm").addEventListener("submit", function (e) {
  e.preventDefault();

  // Validación visual
  const nombre = document.getElementById("nombre");
  const correo = document.getElementById("correo");
  const telefono = document.getElementById("telefono");
  const hora = document.getElementById("horaSeleccionada");

  let valid = true;
  [nombre, correo, telefono, hora].forEach((input) => {
    if (!input.value.trim()) {
      input.classList.add("is-invalid");
      valid = false;
    } else {
      input.classList.remove("is-invalid");
    }
  });

  if (!valid) return;

  // Spinner en botón
  const btn = e.submitter;
  btn.disabled = true;
  btn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Reservando...`;

  const data = {
    date: document.getElementById("fechaSeleccionada").value,
    time: hora.value,
    name: nombre.value,
    email: correo.value,
    phone: telefono.value,
  };

  fetch("api/reservation.php", {
    method: "POST",
    body: JSON.stringify(data),
  })
    .then((res) => res.json())
    .then((response) => {
      if (response.status === "error") {
        Swal.fire("⚠️ Error", response.message, "warning");
        btn.disabled = false;
        btn.textContent = "Reservar"; // 👈 asegúrate de restaurarlo también aquí
        return;
      } else {
        bootstrap.Modal.getInstance(
          document.getElementById("reservaModal")
        ).hide();
        e.target.reset();
        btn.disabled = false;
        btn.textContent = "Reservar";

        // Mostrar resumen en SweetAlert
        Swal.fire({
          title: "✅ ¡Reserva confirmada!",
          html: `
            <strong>📅 Fecha:</strong> ${data.date}<br>
            <strong>🕒 Hora:</strong> ${data.time}<br>
            <strong>👤 Nombre:</strong> ${data.name}<br>
            <strong>✉️ Correo:</strong> ${data.email}<br>
            <strong>📞 Teléfono:</strong> ${data.phone}
          `,
          icon: "success",
          confirmButtonText: "Entendido",
          backdrop: true,
        });

        // Actualizar calendario dinámicamente
        recargarCalendario();
        cargarReservasDelDia(data.date); // Cargar reservas del día actualizado
      }
    });
});
