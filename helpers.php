<?php
function obtenerPublicaciones($csvPath)
{
    $publicaciones = [];

    if (!file_exists($csvPath)) return $publicaciones;

    $file = fopen($csvPath, 'r');

    while (($data = fgetcsv($file)) !== false) {
        if (count($data) >= 5) {
            $publicaciones[] = [
                'fecha'       => $data[0],
                'usuario'     => $data[1],
                'titulo'      => $data[2],
                'descripcion' => $data[3],
                'imagen'      => $data[4],
                'likes'       => isset($data[5]) ? (int)$data[5] : rand(1, 30),
                'comentarios' => isset($data[6]) ? (int)$data[6] : 0,
            ];
        }
    }

    fclose($file);

    usort($publicaciones, function ($a, $b) {
        return strtotime($b['fecha']) - strtotime($a['fecha']);
    });

    return $publicaciones;
};

function obtenerPublicacionesUsuario($csvPath, $usuario)
{
    $todas = obtenerPublicaciones($csvPath);
    return array_filter($todas, fn($perfil) => $perfil['usuario'] === $usuario);
};
