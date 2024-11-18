<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exportação de inscrições</title>
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
    <h1>Lista de inscrições</h1>
    <table>
        <thead>
            <tr>
                <th>Email</th>
                <th>CPF</th>
                <th>Pedido realizado por</th>
                <th>Aluno</th>
                <th>Preço</th>
                <th>Status</th>
                <th>Criado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
                <tr>
                    <td>{{ $data->email }}</td>
                    <td>{{ $data->cpf }}</td>
                    <td>{{ $data->course->title }}</td>
                    <td>{{ $data->user->name }}</td>
                    <td>{{ $data->price }}</td>
                    <td>{{ $data->status == 'payment_confirmed' ? 'PAGO' : 'EM ABERTO' }}</td>
                    <td>{{ $data->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
