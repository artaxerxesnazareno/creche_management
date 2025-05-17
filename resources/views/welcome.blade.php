@extends('layouts.app')

@section('content')
<div class="container">
    <section class="py-5 text-center">
        <div class="row py-lg-5">
            <div class="col-lg-8 col-md-10 mx-auto">
                <h1 class="fw-bold">Gestão completa para sua creche</h1>
                <p class="lead text-muted">
                    Simplifique a administração da sua instituição com nosso sistema completo de gestão.
                </p>
                <div class="mt-4">
                    <a href="{{ route('login') }}" class="btn btn-primary me-2">Começar agora</a>
                    <a href="{{ route('sobre') }}" class="btn btn-outline-secondary">Saiba mais</a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Gestão de Crianças</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Cadastro completo e acompanhamento</h6>
                            <p class="card-text">
                                Gerencie dados pessoais, informações de saúde, histórico de presença e documentos de cada criança.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Comunicação</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Contato direto com responsáveis</h6>
                            <p class="card-text">
                                Sistema de notificações, mensagens diretas e compartilhamento de documentos com os responsáveis.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Relatórios</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Dados e estatísticas</h6>
                            <p class="card-text">
                                Gere relatórios de frequência, pagamentos e outras informações importantes para sua gestão.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
