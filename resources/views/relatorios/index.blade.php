@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="pt-3 pb-2 mb-3">
        <h1 class="h2">Relatórios</h1>
        <p class="text-muted">Gere e visualize relatórios do sistema</p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-subtitle text-muted">Relatórios de Frequência</h6>
                            <h2 class="mt-2 mb-0">12</h2>
                            <p class="text-muted small mb-0">Relatórios gerados este mês</p>
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
                            <h6 class="card-subtitle text-muted">Relatórios de Crianças</h6>
                            <h2 class="mt-2 mb-0">8</h2>
                            <p class="text-muted small mb-0">Relatórios gerados este mês</p>
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
                            <h6 class="card-subtitle text-muted">Relatórios Financeiros</h6>
                            <h2 class="mt-2 mb-0">5</h2>
                            <p class="text-muted small mb-0">Relatórios gerados este mês</p>
                        </div>
                        <div class="bg-light rounded p-2">
                            <i class="bi bi-file-text text-muted"></i>
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
                            <h6 class="card-subtitle text-muted">Total de Downloads</h6>
                            <h2 class="mt-2 mb-0">32</h2>
                            <p class="text-muted small mb-0">Downloads realizados este mês</p>
                        </div>
                        <div class="bg-light rounded p-2">
                            <i class="bi bi-download text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs mb-4" id="relatoriosTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="frequencia-tab" data-bs-toggle="tab" data-bs-target="#frequencia" type="button" role="tab">
                Frequência
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="financeiro-tab" data-bs-toggle="tab" data-bs-target="#financeiro" type="button" role="tab">
                Financeiro
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pedagogico-tab" data-bs-toggle="tab" data-bs-target="#pedagogico" type="button" role="tab">
                Pedagógico
            </button>
        </li>
    </ul>

    <div class="tab-content" id="relatoriosTabContent">
        <!-- Frequência -->
        <div class="tab-pane fade show active" id="frequencia" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Relatório de Frequência</h5>
                    <p class="card-subtitle text-muted">Gere relatórios de frequência por período</p>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <label for="turma" class="form-label">Turma</label>
                            <select class="form-select" id="turma" name="turma">
                                <option selected value="todas">Todas as turmas</option>
                                <option value="berçario">Berçário</option>
                                <option value="maternal-i">Maternal I</option>
                                <option value="maternal-ii">Maternal II</option>
                                <option value="jardim-i">Jardim I</option>
                                <option value="jardim-ii">Jardim II</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="data_inicial" class="form-label">Data Inicial</label>
                            <input type="date" class="form-control" id="data_inicial" name="data_inicial">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="data_final" class="form-label">Data Final</label>
                            <input type="date" class="form-control" id="data_final" name="data_final">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mb-4">
                        <button class="btn btn-outline-secondary">Limpar</button>
                        <button class="btn btn-primary">Gerar Relatório</button>
                    </div>

                    <div class="border rounded p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">Visualização do Relatório</h5>
                            <button class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-download me-1"></i> Exportar
                            </button>
                        </div>
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                            <i class="bi bi-bar-chart-line fs-1 text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financeiro -->
        <div class="tab-pane fade" id="financeiro" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Relatório Financeiro</h5>
                    <p class="card-subtitle text-muted">Gere relatórios financeiros por período</p>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <label for="tipo_relatorio" class="form-label">Tipo de Relatório</label>
                            <select class="form-select" id="tipo_relatorio" name="tipo_relatorio">
                                <option selected disabled value="">Selecione o tipo</option>
                                <option value="mensalidades">Mensalidades</option>
                                <option value="pagamentos">Pagamentos</option>
                                <option value="inadimplencia">Inadimplência</option>
                                <option value="receitas">Receitas</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="data_inicial_fin" class="form-label">Data Inicial</label>
                            <input type="date" class="form-control" id="data_inicial_fin" name="data_inicial_fin">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="data_final_fin" class="form-label">Data Final</label>
                            <input type="date" class="form-control" id="data_final_fin" name="data_final_fin">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mb-4">
                        <button class="btn btn-outline-secondary">Limpar</button>
                        <button class="btn btn-primary">Gerar Relatório</button>
                    </div>

                    <div class="border rounded p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">Visualização do Relatório</h5>
                            <button class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-download me-1"></i> Exportar
                            </button>
                        </div>
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                            <i class="bi bi-pie-chart-fill fs-1 text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pedagógico -->
        <div class="tab-pane fade" id="pedagogico" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Relatório Pedagógico</h5>
                    <p class="card-subtitle text-muted">Gere relatórios pedagógicos por turma ou criança</p>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <label for="tipo_relatorio_ped" class="form-label">Tipo de Relatório</label>
                            <select class="form-select" id="tipo_relatorio_ped" name="tipo_relatorio_ped">
                                <option selected disabled value="">Selecione o tipo</option>
                                <option value="individual">Individual</option>
                                <option value="turma">Por Turma</option>
                                <option value="desenvolvimento">Desenvolvimento</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="turma_crianca" class="form-label">Turma/Criança</label>
                            <select class="form-select" id="turma_crianca" name="turma_crianca">
                                <option selected disabled value="">Selecione</option>
                                <option value="todas">Todas as turmas</option>
                                <option value="berçario">Berçário</option>
                                <option value="maternal-i">Maternal I</option>
                                <option value="maternal-ii">Maternal II</option>
                                <option value="jardim-i">Jardim I</option>
                                <option value="jardim-ii">Jardim II</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="periodo_ped" class="form-label">Período</label>
                            <select class="form-select" id="periodo_ped" name="periodo_ped">
                                <option selected disabled value="">Selecione o período</option>
                                <option value="mensal">Mensal</option>
                                <option value="bimestral">Bimestral</option>
                                <option value="semestral">Semestral</option>
                                <option value="anual">Anual</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mb-4">
                        <button class="btn btn-outline-secondary">Limpar</button>
                        <button class="btn btn-primary">Gerar Relatório</button>
                    </div>

                    <div class="border rounded p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">Visualização do Relatório</h5>
                            <button class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-download me-1"></i> Exportar
                            </button>
                        </div>
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                            <i class="bi bi-graph-up fs-1 text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
