<?php

namespace App\Http\Controllers;

use App\Models\Crianca;
use App\Models\Responsavel;
use App\Models\Matricula;
use App\Models\Presenca;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        // Total de crianças
        $totalCriancas = Crianca::count();

        // Total de responsáveis
        $totalResponsaveis = Responsavel::count();

        // Total de matrículas
        $totalMatriculas = Matricula::count();

        // Presenças do dia
        $presencaHoje = Presenca::whereDate('data', Carbon::today())->count();

        // Crianças recentes (últimas 5)
        $criancasRecentes = Crianca::with('turma')
            ->latest()
            ->take(5)
            ->get();

        // Atividades recentes (últimas 5)
        $atividades = Presenca::with(['crianca.turma'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($presenca) {
                $criancaNome = $presenca->crianca ? $presenca->crianca->nome : 'Criança não encontrada';
                $turmaNome = $presenca->crianca && $presenca->crianca->turma ? $presenca->crianca->turma->nome : 'N/A';

                return [
                    'descricao' => "Presença registrada para {$criancaNome} na turma {$turmaNome}",
                    'data_formatada' => Carbon::parse($presenca->data)->format('d/m/Y H:i')
                ];
            });

        return view('dashboard', compact(
            'totalCriancas',
            'totalResponsaveis',
            'totalMatriculas',
            'presencaHoje',
            'criancasRecentes',
            'atividades'
        ));
    }
}
