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

        table,
        th,
        td {
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
            @php
                $statusStyles = [
                    'sent' => 'background-color: #f5f5f5; color: #555;',
                    'payment_created' => 'background-color: #ffeb3b; color: #000;',
                    'payment_confirmed' => 'background-color: #4caf50; color: #fff;',
                    'reprocess_payment' => 'background-color: #581c87; color: #fff;',
                    'canceled' => 'background-color: #f44336; color: #fff;',
                    'default' => 'background-color: #9e9e9e; color: #fff;'
                ];

                $statusLabel = [
                    'sent' => 'Enviado',
                    'payment_created' => 'Pagamento Criado',
                    'payment_confirmed' => 'Pago',
                    'reprocess_payment' => 'Reprocessar Pagamento',
                    'canceled' => 'Cancelado',
                    'default' => 'Status Desconhecido',
                ];
            @endphp

            @foreach ($datas as $data)
            <tr>
                <td>{{ $data->email }}</td>
                <td>{{ $data->cpf }}</td>
                <td>{{ $data->course->title }}</td>
                <td>{{ $data->user->name }}</td>
                <td>{{ number_format($data->price, 2, ',', '.') }}</td>
                <td style="{{ $statusStyles[$data->status] ?? $statusStyles['default'] }}">
                    {{ $statusLabel[$data->status] ?? $statusLabel['default'] }}
                </td>
                <td>{{ $data->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
