<table class="bordered">
    <tr class="font-12">
        <th style="width: 50px">ID</th>
        <th style="width: 150px">Departamento</th>
    </tr>
    @foreach ($lista as $dato)
        <tr>
            <td style="width: 50px">{{ $dato->id }}</td>
            <td style="width: 150px">{{ $dato->nombre }}</td>
        </tr>
    @endforeach
</table>
