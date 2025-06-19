<!DOCTYPE html>
<html>

<head>
    <title>Dashboard - Sistema de Inventario</title>
</head>

<body>
    <h1>Dashboard del Sistema</h1>

    <nav>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('equipos.index') }}">Equipos</a>
        <a href="{{ route('tickets.index') }}">Tickets</a>
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit">Cerrar Sesión</button>
        </form>
    </nav>

    <h2>Estadísticas Generales</h2>
    <div>
        <div>
            <h3>Equipos</h3>
            <p>Total: {{ $totalEquipos }}</p>
            <p>Operativos: {{ $equiposOperativos }}</p>
            <p>Asignados: {{ $equiposAsignados }}</p>
            <p>Disponibles: {{ $equiposDisponibles }}</p>
        </div>

        <div>
            <h3>Tickets</h3>
            <p>Total: {{ $totalTickets }}</p>
            <p>Abiertos: {{ $ticketsAbiertos }}</p>
            <p>Críticos: {{ $ticketsCriticos }}</p>
        </div>

        <div>
            <h3>Usuarios</h3>
            <p>Activos: {{ $totalUsuarios }}</p>
        </div>
    </div>

    <h2>Tickets Recientes</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Número</th>
                <th>Título</th>
                <th>Solicitante</th>
                <th>Estado</th>
                <th>Prioridad</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ticketsRecientes as $ticket)
                <tr>
                    <td><a href="{{ route('tickets.show', $ticket->id_ticket) }}">{{ $ticket->numero_ticket }}</a></td>
                    <td>{{ $ticket->titulo }}</td>
                    <td>{{ $ticket->solicitante->nombre_completo }}</td>
                    <td>{{ $ticket->estado->nombre_estado }}</td>
                    <td>{{ ucfirst($ticket->prioridad) }}</td>
                    <td>{{ $ticket->fecha_creacion->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay tickets recientes</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h2>Equipos con Garantía Próxima a Vencer</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Código</th>
                <th>Equipo</th>
                <th>Marca</th>
                <th>Serie</th>
                <th>Vence Garantía</th>
            </tr>
        </thead>
        <tbody>
            @forelse($equiposGarantia as $equipo)
                <tr>
                    <td><a href="{{ route('equipos.show', $equipo->id_equipo) }}">{{ $equipo->codigo_inventario }}</a>
                    </td>
                    <td>{{ $equipo->modelo->nombre_modelo }}</td>
                    <td>{{ $equipo->modelo->marca->nombre_marca }}</td>
                    <td>{{ $equipo->numero_serie }}</td>
                    <td>{{ $equipo->fecha_garantia_fin->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay equipos con garantía próxima a vencer</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
