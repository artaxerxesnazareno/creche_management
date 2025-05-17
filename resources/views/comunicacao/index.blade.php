@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <div>
            <h1 class="h2">Comunicação</h1>
            <p class="text-muted">Gerencie a comunicação com os responsáveis</p>
        </div>
        <a href="{{ route('comunicacao.mensagens.create') }}" class="btn btn-primary">
            <i class="bi bi-plus me-1"></i> Nova Mensagem
        </a>
    </div>

    <ul class="nav nav-tabs mb-4" id="comunicacaoTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active d-flex align-items-center" id="mensagens-tab" data-bs-toggle="tab" data-bs-target="#mensagens" type="button" role="tab">
                <i class="bi bi-envelope me-2"></i> Mensagens
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link d-flex align-items-center" id="eventos-tab" data-bs-toggle="tab" data-bs-target="#eventos" type="button" role="tab">
                <i class="bi bi-calendar-event me-2"></i> Eventos
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link d-flex align-items-center" id="notificacoes-tab" data-bs-toggle="tab" data-bs-target="#notificacoes" type="button" role="tab">
                <i class="bi bi-bell me-2"></i> Notificações
            </button>
        </li>
    </ul>

    <div class="tab-content" id="comunicacaoTabContent">
        <!-- Mensagens -->
        <div class="tab-pane fade show active" id="mensagens" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Mensagens</h5>
                    <p class="card-subtitle text-muted">Gerencie as mensagens enviadas aos responsáveis</p>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control" placeholder="Buscar mensagem...">
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
                                    <th>Destinatário</th>
                                    <th>Assunto</th>
                                    <th>Data</th>
                                    <th>Status</th>
                                    <th class="text-end">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $mensagens = [
                                    ['id' => 1, 'destinatario' => 'Maria Silva', 'assunto' => 'Reunião de Pais', 'data' => '10/05/2024', 'status' => 'Lida'],
                                    ['id' => 2, 'destinatario' => 'Carlos Santos', 'assunto' => 'Festa Junina', 'data' => '08/05/2024', 'status' => 'Não lida'],
                                    ['id' => 3, 'destinatario' => 'Juliana Oliveira', 'assunto' => 'Vacinação', 'data' => '05/05/2024', 'status' => 'Lida'],
                                    ['id' => 4, 'destinatario' => 'Roberto Costa', 'assunto' => 'Atividade Especial', 'data' => '03/05/2024', 'status' => 'Lida'],
                                    ['id' => 5, 'destinatario' => 'Fernanda Pereira', 'assunto' => 'Relatório Mensal', 'data' => '01/05/2024', 'status' => 'Não lida'],
                                ];
                                @endphp

                                @foreach($mensagens as $mensagem)
                                <tr>
                                    <td>{{ $mensagem['destinatario'] }}</td>
                                    <td>{{ $mensagem['assunto'] }}</td>
                                    <td>{{ $mensagem['data'] }}</td>
                                    <td>
                                        @if($mensagem['status'] == 'Lida')
                                            <span class="badge bg-light text-dark border">{{ $mensagem['status'] }}</span>
                                        @else
                                            <span class="badge bg-primary">{{ $mensagem['status'] }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('comunicacao.mensagens.show', $mensagem['id']) }}" class="btn btn-sm btn-outline-primary">
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

        <!-- Eventos -->
        <div class="tab-pane fade" id="eventos" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Eventos</h5>
                    <p class="card-subtitle text-muted">Gerencie os eventos da creche</p>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control" placeholder="Buscar evento...">
                            </div>
                        </div>
                        <div class="col-md-4 d-flex justify-content-md-end mt-3 mt-md-0">
                            <a href="{{ route('comunicacao.eventos.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus me-1"></i> Novo Evento
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Data</th>
                                    <th>Horário</th>
                                    <th>Local</th>
                                    <th class="text-end">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $eventos = [
                                    ['id' => 1, 'titulo' => 'Reunião de Pais', 'data' => '15/05/2024', 'horario' => '18:00', 'local' => 'Sala de Reuniões'],
                                    ['id' => 2, 'titulo' => 'Vacinação', 'data' => '25/05/2024', 'horario' => '09:00', 'local' => 'Enfermaria'],
                                    ['id' => 3, 'titulo' => 'Festa Junina', 'data' => '20/06/2024', 'horario' => '14:00', 'local' => 'Pátio'],
                                    ['id' => 4, 'titulo' => 'Passeio ao Zoológico', 'data' => '10/06/2024', 'horario' => '08:00', 'local' => 'Zoológico Municipal'],
                                ];
                                @endphp

                                @foreach($eventos as $evento)
                                <tr>
                                    <td>{{ $evento['titulo'] }}</td>
                                    <td>{{ $evento['data'] }}</td>
                                    <td>{{ $evento['horario'] }}</td>
                                    <td>{{ $evento['local'] }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('comunicacao.eventos.show', $evento['id']) }}" class="btn btn-sm btn-outline-primary">
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

        <!-- Notificações -->
        <div class="tab-pane fade" id="notificacoes" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Notificações</h5>
                    <p class="card-subtitle text-muted">Gerencie as notificações do sistema</p>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control" placeholder="Buscar notificação...">
                            </div>
                        </div>
                        <div class="col-md-4 d-flex justify-content-md-end mt-3 mt-md-0">
                            <a href="{{ route('comunicacao.notificacoes.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus me-1"></i> Nova Notificação
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Data</th>
                                    <th>Tipo</th>
                                    <th class="text-end">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $notificacoes = [
                                    ['id' => 1, 'titulo' => 'Lembrete de Reunião', 'data' => '10/05/2024', 'tipo' => 'Lembrete'],
                                    ['id' => 2, 'titulo' => 'Pagamento Pendente', 'data' => '08/05/2024', 'tipo' => 'Alerta'],
                                    ['id' => 3, 'titulo' => 'Documentação Atualizada', 'data' => '05/05/2024', 'tipo' => 'Informação'],
                                    ['id' => 4, 'titulo' => 'Nova Mensagem Recebida', 'data' => '03/05/2024', 'tipo' => 'Mensagem'],
                                ];
                                @endphp

                                @foreach($notificacoes as $notificacao)
                                <tr>
                                    <td>{{ $notificacao['titulo'] }}</td>
                                    <td>{{ $notificacao['data'] }}</td>
                                    <td>
                                        @if($notificacao['tipo'] == 'Alerta')
                                            <span class="badge bg-danger">{{ $notificacao['tipo'] }}</span>
                                        @elseif($notificacao['tipo'] == 'Lembrete')
                                            <span class="badge bg-primary">{{ $notificacao['tipo'] }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $notificacao['tipo'] }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('comunicacao.notificacoes.show', $notificacao['id']) }}" class="btn btn-sm btn-outline-primary">
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
    </div>
</div>
@endsection
