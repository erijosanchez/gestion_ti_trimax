<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\Equipo;
use App\Models\ModeloEquipo;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Equipo::with(['modelo.marca', 'modelo.categoria', 'proveedor', 'asignacionActiva.usuarioAsignado']);
        
        // Filtros
        if ($request->filled('codigo')) {
            $query->where('codigo_inventario', 'like', '%' . $request->codigo . '%');
        }
        
        if ($request->filled('estado_funcional')) {
            $query->where('estado_funcional', $request->estado_funcional);
        }
        
        if ($request->filled('categoria')) {
            $query->whereHas('modelo.categoria', function($q) use ($request) {
                $q->where('id_categoria', $request->categoria);
            });
        }
        
        $equipos = $query->paginate(20);
        
        // Para filtros
        $categorias = \App\Models\CategoriaEquipo::where('estado', 'activo')->get();
        
        return view('equipos.index', compact('equipos', 'categorias'));
    }

    public function show($id)
    {
        $equipo = Equipo::with([
            'modelo.marca', 
            'modelo.categoria', 
            'proveedor',
            'asignaciones.usuarioAsignado',
            'tickets.estado',
            'movimientos'
        ])->findOrFail($id);
        
        return view('equipos.show', compact('equipo'));
    }

    public function create()
    {
        $modelos = ModeloEquipo::with(['marca', 'categoria'])->where('estado', 'activo')->get();
        $proveedores = Proveedor::where('estado', 'activo')->get();
        
        return view('equipos.create', compact('modelos', 'proveedores'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_modelo' => 'required|exists:modelos_equipos,id_modelo',
            'id_proveedor' => 'nullable|exists:proveedores,id_proveedor',
            'codigo_inventario' => 'required|unique:equipos,codigo_inventario',
            'numero_serie' => 'nullable|unique:equipos,numero_serie',
            'numero_factura' => 'nullable|string|max:50',
            'fecha_compra' => 'nullable|date',
            'fecha_garantia_inicio' => 'nullable|date',
            'fecha_garantia_fin' => 'nullable|date',
            'costo_adquisicion' => 'nullable|numeric|min:0',
            'vida_util_anos' => 'nullable|integer|min:1',
            'observaciones' => 'nullable|string',
            'estado_fisico' => 'required|in:excelente,bueno,regular,malo,dañado',
            'estado_funcional' => 'required|in:operativo,en_reparacion,dañado,obsoleto',
            'ubicacion_fisica' => 'nullable|string|max:200'
        ]);

        Equipo::create($validated);

        return redirect()->route('equipos.index')->with('success', 'Equipo creado exitosamente');
    }

    public function edit($id)
    {
        $equipo = Equipo::findOrFail($id);
        $modelos = ModeloEquipo::with(['marca', 'categoria'])->where('estado', 'activo')->get();
        $proveedores = Proveedor::where('estado', 'activo')->get();
        
        return view('equipos.edit', compact('equipo', 'modelos', 'proveedores'));
    }

    public function update(Request $request, $id)
    {
        $equipo = Equipo::findOrFail($id);
        
        $validated = $request->validate([
            'id_modelo' => 'required|exists:modelos_equipos,id_modelo',
            'id_proveedor' => 'nullable|exists:proveedores,id_proveedor',
            'codigo_inventario' => 'required|unique:equipos,codigo_inventario,' . $id . ',id_equipo',
            'numero_serie' => 'nullable|unique:equipos,numero_serie,' . $id . ',id_equipo',
            'numero_factura' => 'nullable|string|max:50',
            'fecha_compra' => 'nullable|date',
            'fecha_garantia_inicio' => 'nullable|date',
            'fecha_garantia_fin' => 'nullable|date',
            'costo_adquisicion' => 'nullable|numeric|min:0',
            'vida_util_anos' => 'nullable|integer|min:1',
            'observaciones' => 'nullable|string',
            'estado_fisico' => 'required|in:excelente,bueno,regular,malo,dañado',
            'estado_funcional' => 'required|in:operativo,en_reparacion,dañado,obsoleto',
            'ubicacion_fisica' => 'nullable|string|max:200'
        ]);

        $equipo->update($validated);

        return redirect()->route('equipos.show', $equipo->id_equipo)->with('success', 'Equipo actualizado exitosamente');
    }

    public function destroy($id)
    {
        $equipo = Equipo::findOrFail($id);
        
        // Verificar si tiene asignaciones activas
        if ($equipo->asignacionActiva) {
            return redirect()->back()->with('error', 'No se puede eliminar un equipo que tiene asignaciones activas');
        }
        
        $equipo->delete();
        
        return redirect()->route('equipos.index')->with('success', 'Equipo eliminado exitosamente');
    }
}
