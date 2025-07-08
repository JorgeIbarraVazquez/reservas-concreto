<?php
class ReservationModel
{
	private static $path = __DIR__ . '/../../data/reservas.json';

	public static function getAll()
	{
		if (!file_exists(self::$path)) file_put_contents(self::$path, json_encode([]));
		return json_decode(file_get_contents(self::$path), true) ?? [];
	}

	public static function save($data)
	{
		$reservas = self::getAll();
		$existe = array_filter($reservas, function ($r) use ($data) {
			return $r['date'] === $data['date'] && (
				strtolower($r['email']) === strtolower($data['email'])
			);
		});

		if (!empty($existe)) {
			return ['status' => 'error', 'message' => 'Ya tienes una reserva con el correo proporcionado ese día'];
		}

		$reservas[] = $data;
		$guardado = file_put_contents(self::$path, json_encode($reservas));
		if ($guardado === false) {
			error_log("❌ Error al guardar la reserva en " . self::$path);
			return ['status' => 'error', 'message' => 'No se pudo guardar la reserva'];
		}

		return ['status' => 'ok', 'message' => 'Reserva guardada exitosamente'];
	}


	public static function getByDate($date)
	{
		return array_values(array_filter(self::getAll(), fn($r) => $r['date'] === $date));
	}
}
