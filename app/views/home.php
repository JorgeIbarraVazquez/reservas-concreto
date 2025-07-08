<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Reservas de Concreto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- FullCalendar CSS -->
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />

  <style>
    body {
      background-color: #f4f6f9;
    }

    #calendar {
      max-width: 900px;
      margin: 40px auto;
    }
  </style>
</head>

<body>
  <div class="container text-center mt-4">
    <h1>📅 Reserva tu Entrega de Concreto</h1>
    <div class="row mt-4">
      <div class="col-md-8">
        <div id="calendar"></div>
      </div>
      <div class="col-md-4">
        <h5>📋 Reservas del día</h5>
        <ul id="listaReservas" class="list-group"></ul>
      </div>
    </div>
  </div>

  <!-- Modal de Reserva -->
  <div class="modal fade" id="reservaModal" tabindex="-1" aria-labelledby="reservaLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form class="modal-content" id="reservaForm">
        <div class="modal-header">
          <h5 class="modal-title" id="reservaLabel">Confirmar Reserva</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="fechaSeleccionada">
          <input type="hidden" id="horaSeleccionada">

          <input type="text" class="form-control mb-2" placeholder="Nombre" id="nombre" required>
          <input type="email" class="form-control mb-2" placeholder="Correo electrónico" id="correo" required>
          <input type="tel" class="form-control mb-2" placeholder="Teléfono" id="telefono" required>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Reservar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
  <!-- JS -->
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
  <script src="public/js/calendar.js"></script>
  <script src="public/js/reservation.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>