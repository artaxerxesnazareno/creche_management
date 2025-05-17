@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <div>
            <h1 class="h2">Matrículas</h1>
            <p class="text-muted">Gerencie as matrículas da creche</p>
        </div>
        <a href="{{ route('matriculas.create') }}" class="btn btn-primary">
            <i class="bi bi-plus me-1"></i> Nova Matrícula
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Lista de Matrículas</h5>
            <p class="card-subtitle text-muted">Visualize e gerencie todas as matrículas</p>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" placeholder="Buscar matrícula...">
                    </div>
                </div>
                <div class="col-md-4 d-flex justify-content-md-end mt-3 mt-md-0">
                    <button class="btn btn-outline-secondary">Filtrar</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Criança</th>
                            <th>Turma</th>
                            <th>Data de Início</th>
                            <th>Status</th>
                            <th>Mensalidade</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $matriculas = [
                            ['id' => 1, 'crianca' => 'Ana Silva', 'turma' => 'Maternal II', 'dataInicio' => '01/02/2024', 'status' => 'Ativa', 'mensalidade' => 'R$ 850,00'],
                            ['id' => 2, 'crianca' => 'João Santos', 'turma' => 'Jardim I', 'dataInicio' => '01/02/2024', 'status' => 'Ativa', 'mensalidade' => 'R$ 900,00'],
                            ['id' => 3, 'crianca' => 'Pedro Oliveira', 'turma' => 'Maternal I', 'dataInicio' => '15/03/2024', 'status' => 'Ativa', 'mensalidade' => 'R$ 800,00'],
                            ['id' => 4, 'crianca' => 'Mariana Costa', 'turma' => 'Jardim II', 'dataInicio' => '01/02/2024', 'status' => 'Ativa', 'mensalidade' => 'R$ 950,00'],
                            ['id' => 5, 'crianca' => 'Lucas Pereira', 'turma' => 'Maternal II', 'dataInicio' => '01/04/2024', 'status' => 'Pendente', 'mensalidade' => 'R$ 850,00'],
                            ['id' => 6, 'crianca' => 'Beatriz Souza', 'turma' => 'Jardim I', 'dataInicio' => '01/02/2024', 'status' => 'Ativa', 'mensalidade' => 'R$ 900,00'],
                            ['id' => 7, 'crianca' => 'Gabriel Lima', 'turma' => 'Maternal I', 'dataInicio' => '01/03/2024', 'status' => 'Ativa', 'mensalidade' => 'R$ 800,00'],
                            ['id' => 8, 'crianca' => 'Sofia Martins', 'turma' => 'Jardim II', 'dataInicio' => '01/02/2024', 'status' => 'Inativa', 'mensalidade' => 'R$ 950,00'],
                        ];
                        @endphp

                        @foreach($matriculas as $matricula)
                        <tr>
                            <td>{{ $matricula['crianca'] }}</td>
                            <td>{{ $matricula['turma'] }}</td>
                            <td>{{ $matricula['dataInicio'] }}</td>
                            <td>
                                @if($matricula['status'] == 'Ativa')
                                    <span class="badge bg-success">{{ $matricula['status'] }}</span>
                                @elseif($matricula['status'] == 'Pendente')
                                    <span class="badge bg-warning text-dark">{{ $matricula['status'] }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $matricula['status'] }}</span>
                                @endif
                            </td>
                            <td>{{ $matricula['mensalidade'] }}</td>
                            <td class="text-end">
                                <a href="{{ route('matriculas.show', $matricula['id']) }}" class="btn btn-sm btn-outline-primary">
                                    Ver detalhes
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
