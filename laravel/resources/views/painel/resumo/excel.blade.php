<table>
    <thead>
    <tr>
        <th>Nome</th>
        <th>Projeto</th>
        <th>Status</th>
        <th>Horas</th>
        <th>Despesas</th>
        <th>Dia</th>
        <th>Mês</th>
        <th>Ano</th>
        <th>Valor da Hora</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($horas as $hora)
        <tr>
            <td>{{ $hora->nome }}</td>
            <td>{{ $hora->projeto }}</td>
            <td>{{ $hora->status }}</td>
            <td>{{ $hora->hora }}</td>
            <td>{{ $hora->despesa }}</td>
            <td>{{ $hora->dia }}</td>
            <td>{{ $hora->mes }}</td>
            <td>{{ $hora->ano }}</td>
            <td></td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>