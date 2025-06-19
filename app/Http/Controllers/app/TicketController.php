<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\HistorialTicket;
use App\Models\EstadoTicket;
use App\Models\Usuarios;
use App\Models\CategoriaTicket;
use App\Models\Equipo;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with(['solicitante', 'tecnico', 'categoria', 'estado', 'equipo']);
        
        // Filtros
        if ($request->filled('estado')) {
            $query->where('id_estado_ticket', $request->estado);
        }
        
        if ($request->filled('prioridad')) {
            $query->where('prioridad', $request->prioridad);
        }
        
        if ($request->filled('categoria')) {
            $query->where('id_categoria_ticket', $request->categoria);
        }
        
        if ($request->filled('tecnico')) {
            $query->where('id_tecnico_asignado', $request->tecnico);
        }
        
        $tickets = $query->orderBy('fecha_creacion', 'desc')->paginate(20);
        
        // Para filtros
        $estados = EstadoTicket::all();
        $categorias = CategoriaTicket::where('estado', 'activo')->get();
        $tecnicos = Usuarios::whereHas('rol', function($q) {
            $q->where('nombre_rol', 'tecnico');
        })->where('estado', 'activo')->get();
        
        return view('tickets.index', compact('tickets', 'estados', 'categorias', 'tecnicos'));
    }

    public function show($id)
    {
        $ticket = Ticket::with([
            'solicitante', 
            'tecnico', 
            'categoria', 
            'estado', 
            'equipo.modelo.marca',
            'historial.usuario'
        ])->findOrFail($id);
        
        return view('tickets.show', compact('ticket'));
    }

    public function create()
    {
        $categorias = CategoriaTicket::where('estado', 'activo')->get();
        $equipos = Equipo::with(['modelo.marca'])->where('estado_funcional', 'operativo')->get();
        
        return view('tickets.create', compact('categorias', 'equipos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_categoria_ticket' => 'required|exists:categorias_tickets,id_categoria_ticket',
            'id_equipo' => 'nullable|exists:equipos,id_equipo',
            'titulo' => 'required|string|max:200',
            'descripcion' => 'required|string',
            'prioridad' => 'required|in:baja,media,alta,critica'
        ]);

        // Generar número de ticket
        $ultimoTicket = Ticket::orderBy('id_ticket', 'desc')->first();
        $numeroTicket = 'TK-' . date('Y') . '-' . str_pad(($ultimoTicket ? $ultimoTicket->id_ticket + 1 : 1), 6, '0', STR_PAD_LEFT);
        
        // Estado inicial
        $estadoInicial = EstadoTicket::where('es_estado_inicial', true)->first();
        
        $validated['numero_ticket'] = $numeroTicket;
        $validated['id_usuario_solicitante'] = auth()->id();
        $validated['id_estado_ticket'] = $estadoInicial->id_estado_ticket;

        $ticket = Ticket::create($validated);
        
        // Crear historial inicial
        HistorialTicket::create([
            'id_ticket' => $ticket->id_ticket,
            'id_usuario' => auth()->id(),
            'id_estado_nuevo' => $estadoInicial->id_estado_ticket,
            'accion' => 'creado',
            'comentario' => 'Ticket creado por el usuario',
            'es_publico' => true
        ]);

        return redirect()->route('tickets.show', $ticket->id_ticket)->with('success', 'Ticket creado exitosamente');
    }

    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $categorias = CategoriaTicket::where('estado', 'activo')->get();
        $estados = EstadoTicket::all();
        $tecnicos = Usuarios::whereHas('rol', function($q) {
            $q->whereIn('nombre_rol', ['tecnico', 'administrador']);
        })->where('estado', 'activo')->get();
        $equipos = Equipo::with(['modelo.marca'])->get();
        
        return view('tickets.edit', compact('ticket', 'categorias', 'estados', 'tecnicos', 'equipos'));
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $estadoAnterior = $ticket->id_estado_ticket;
        
        $validated = $request->validate([
            'id_categoria_ticket' => 'required|exists:categorias_tickets,id_categoria_ticket',
            'id_estado_ticket' => 'required|exists:estados_tickets,id_estado_ticket',
            'id_equipo' => 'nullable|exists:equipos,id_equipo',
            'id_tecnico_asignado' => 'nullable|exists:usuarios,id_usuario',
            'titulo' => 'required|string|max:200',
            'descripcion' => 'required|string',
            'prioridad' => 'required|in:baja,media,alta,critica',
            'solucion' => 'nullable|string',
            'observaciones_internas' => 'nullable|string'
        ]);

        $ticket->update($validated);
        
        // Si cambió el estado, crear historial
        if ($estadoAnterior != $validated['id_estado_ticket']) {
            HistorialTicket::create([
                'id_ticket' => $ticket->id_ticket,
                'id_usuario' => auth()->id(),
                'id_estado_anterior' => $estadoAnterior,
                'id_estado_nuevo' => $validated['id_estado_ticket'],
                'accion' => 'estado_cambio',
                'comentario' => 'Estado cambiado por ' . auth()->user()->nombre_completo,
                'es_publico' => true
            ]);
        }

        return redirect()->route('tickets.show', $ticket->id_ticket)->with('success', 'Ticket actualizado exitosamente');
    }
    
    public function addComment(Request $request, $id)
    {
        $request->validate([
            'comentario' => 'required|string',
            'tiempo_invertido' => 'nullable|integer|min:0',
            'es_publico' => 'boolean'
        ]);
        
        $ticket = Ticket::findOrFail($id);
        
        HistorialTicket::create([
            'id_ticket' => $ticket->id_ticket,
            'id_usuario' => auth()->id(),
            'id_estado_nuevo' => $ticket->id_estado_ticket,
            'accion' => 'comentario',
            'comentario' => $request->comentario,
            'tiempo_invertido_minutos' => $request->tiempo_invertido ?? 0,
            'es_publico' => $request->boolean('es_publico', true)
        ]);
        
        return redirect()->back()->with('success', 'Comentario agregado exitosamente');
    }
}
