<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exportação de Cursos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #e1e1e1;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Lista de Cursos</h1>
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Descrição</th>
                <th>Inicio das incrições</th>
                <th>Encerramento</th>
                <th>Preço</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
                <tr>
                    <td>{{ $data->title }}</td>
                    <td>{{ $data->description }}</td>
                    <td>{{ $data->date_ini }}</td>
                    <td>{{ $data->date_end }}</td>
                    <td>{{ $data->price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
