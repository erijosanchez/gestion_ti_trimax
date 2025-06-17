<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;

use App\Models\Equipo;
use App\Models\Ticket;
use App\Models\AsignacionEquipo;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        //Estadistica
        $totalEquipos = Equipo::count();
        $equiposOperativos = Equipo::where('estado_funcional', 'operativo')->count();
        $equiposAsignados = AsignacionEquipo::where('estado', 'activa')->count();
        $equiposDisponibles = $totalEquipos - $equiposAsignados;

        $totalTickets = Ticket::count();
        $ticketsAbiertos = Ticket::whereHas('estado', function($q) {
            $q->where('es_estado_final', false);
        })->count();
        $ticketsCriticos = Ticket::where('prioridad', 'critica')->count();

        $ticketsRecientes = Ticket::with(['solicitante', 'estado', 'categoria'])
            ->orderBy('fecha_creacion', 'desc')
            ->limit(5)
            ->get();
        
        $equiposGarantia = Equipo::with(['modelo.marca'])
            ->where('fecha_garantia_fin', '<=', now()->addDays(30))
            ->where('fecha_garantia_fin', '>=', now())
            ->limit(5)
            ->get();
        
        $totalUsuarios = User::where('estado', 'activo')->count();

        return view('dashboard', compact(
            'totalEquipos', 'equiposOperativos', 'equiposAsignados', 'equiposDisponibles',
            'totalTickets', 'ticketsAbiertos', 'ticketsCriticos', 'totalUsuarios',
            'ticketsRecientes', 'equiposGarantia'
        ));
    }
}
