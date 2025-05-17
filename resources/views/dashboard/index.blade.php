@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <p class="text-muted">Bem-vindo ao Sistema de Gestão de Creche</p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-subtitle text-muted">Total de Crianças</h6>
                            <h2 class="mt-2 mb-0">45</h2>
                            <p class="text-muted small mb-0">+2 desde o último mês</p>
                        </div>
                        <div class="bg-light rounded p-2">
                            <i class="bi bi-people text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-subtitle text-muted">Presença Hoje</h6>
                            <h2 class="mt-2 mb-0">38</h2>
                            <p class="text-muted small mb-0">84% de presença</p>
                        </div>
                        <div class="bg-light rounded p-2">
                            <i class="bi bi-calendar-date text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-subtitle text-muted">Mensagens Não Lidas</h6>
                            <h2 class="mt-2 mb-0">12</h2>
                            <p class="text-muted small mb-0">+3 nas últimas 24h</p>
                        </div>
                        <div class="bg-light rounded p-2">
                            <i class="bi bi-bell text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-subtitle text-muted">Taxa de Ocupação</h6>
                            <h2 class="mt-2 mb-0">90%</h2>
                            <p class="text-muted small mb-0">+5% desde o último mês</p>
                        </div>
                        <div class="bg-light rounded p-2">
                            <i class="bi bi-graph-up text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs mb-4" id="dashboardTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                Visão Geral
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="analytics-tab" data-bs-toggle="tab" data-bs-target="#analytics" type="button" role="tab">
                Análises
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="reports-tab" data-bs-toggle="tab" data-bs-target="#reports" type="button" role="tab">
                Relatórios
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications" type="button" role="tab">
                Notificações
            </button>
        </li>
    </ul>

    <div class="tab-content" id="dashboardTabContent">
        <div class="tab-pane fade show active" id="overview" role="tabpanel">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Frequência Semanal</h5>
                        </div>
                        <div class="card-body">
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="bi bi-bar-chart-line fs-1 text-muted"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Próximos Eventos</h5>
                            <p class="card-subtitle text-muted">Eventos agendados para os próximos dias</p>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item px-0">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-calendar me-3 text-muted"></i>
                                        <div>
                                            <h6 class="mb-0">Reunião de Pais</h6>
                                            <small class="text-muted">15/05/2024 - 18:00</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item px-0">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-calendar me-3 text-muted"></i>
                                        <div>
                                            <h6 class="mb-0">Festa Junina</h6>
                                            <small class="text-muted">20/06/2024 - 14:00</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item px-0">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-calendar me-3 text-muted"></i>
                                        <div>
                                            <h6 class="mb-0">Vacinação</h6>
                                            <small class="text-muted">25/05/2024 - 09:00</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="analytics" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Análises</h5>
                    <p class="card-subtitle text-muted">Visualize dados analíticos da sua creche</p>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center" style="height: 300px;">
                        <p class="text-muted">Dados analíticos serão exibidos aqui</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="reports" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Relatórios</h5>
                    <p class="card-subtitle text-muted">Acesse e gere relatórios personalizados</p>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center" style="height: 300px;">
                        <p class="text-muted">Relatórios serão exibidos aqui</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="notifications" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Notificações</h5>
                    <p class="card-subtitle text-muted">Visualize suas notificações recentes</p>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center" style="height: 300px;">
                        <p class="text-muted">Notificações serão exibidas aqui</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
