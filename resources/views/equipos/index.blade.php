<!DOCTYPE html>
<html>

<head>
    <title>Equipos - Sistema de Inventario</title>
</head>

<body>
    <nav>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('equipos.index') }}">Equipos</a>
        <a href="{{ route('tickets.index') }}">Tickets</a>
    </nav>

    <h1>Gestión de Equipos</h1>

    <a href="{{ route('equipos.create') }}">Crear Nuevo Equipo</a>

    @if (session('success'))
        <div style="color: green; background: #f0f8f0; padding: 10px; margin: 10px 0;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="color: red; background: #f8f0f0; padding: 10px; margin: 10px 0;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filtros -->
    <form method="GET" style="margin: 20px 0; padding: 15px; border: 1px solid #ccc;">
        <h3>Filtros</h3>
        <label>Código: <input type="text" name="codigo" value="{{ request('codigo') }}"></label>

        <label>Estado:
            <select name="estado_funcional">
                <option value="">Todos</option>
                <option value="operativo" {{ request('estado_funcional') == 'operativo' ? 'selected' : '' }}>Operativo
                </option>
                <option value="en_reparacion" {{ request('estado_funcional') == 'en_reparacion' ? 'selected' : '' }}>En
                    Reparación</option>
                <option value="dañado" {{ request('estado_funcional') == 'dañado' ? 'selected' : '' }}>Dañado</option>
                <option value="obsoleto" {{ request('estado_funcional') == 'obsoleto' ? 'selected' : '' }}>Obsoleto
                </option>
            </select>
        </label>

        <label>Categoría:
            <select name="categoria">
                <option value="">Todas</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id_categoria }}"
                        {{ request('categoria') == $categoria->id_categoria ? 'selected' : '' }}>
                        {{ $categoria->nombre_categoria }}
                    </option>
                @endforeach
            </select>
        </label>

        <button type="submit">Filtrar</button>
        <a href="{{ route('equipos.index') }}">Limpiar</a>
    </form>

    <!-- Tabla de equipos -->
    <table border="1" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Código</th>
                <th>Equipo</th>
                <th>Marca</th>
                <th>Serie</th>
                <th>Estado</th>
                <th>Asignado a</th>
                <th>Ubicación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($equipos as $equipo)
                <tr>
                    <td>{{ $equipo->codigo_inventario }}</td>
                    <td>{{ $equipo->modelo->nombre_modelo }}</td>
                    <td>{{ $equipo->modelo->marca->nombre_marca }}</td>
                    <td>{{ $equipo->numero_serie ?? 'N/A' }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $equipo->estado_funcional)) }}</td>
                    <td>
                        @if ($equipo->asignacionActiva)
                            {{ $equipo->asignacionActiva->usuarioAsignado->nombre_completo }}
                        @else
                            <em>Disponible</em>
                        @endif
                    </td>
                    <td>{{ $equipo->ubicacion_fisica ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('equipos.show', $equipo->id_equipo) }}">Ver</a>
                        <a href="{{ route('equipos.edit', $equipo->id_equipo) }}">Editar</a>
                        <form method="POST" action="{{ route('equipos.destroy', $equipo->id_equipo) }}"
                            style="display: inline;" onsubmit="return confirm('¿Estás seguro?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No se encontraron equipos</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginación -->
    <div style="margin: 20px 0;">
        {{ $equipos->links() }}
    </div>
</body>

</html>
