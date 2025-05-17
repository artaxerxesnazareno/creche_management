@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="pt-3 pb-2 mb-3">
        <h1 class="h2">Cadastrar Criança</h1>
        <p class="text-muted">Preencha os dados para cadastrar uma nova criança</p>
    </div>

    <form action="{{ route('criancas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <ul class="nav nav-tabs mb-4" id="cadastroTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="dados-pessoais-tab" data-bs-toggle="tab" data-bs-target="#dados-pessoais" type="button" role="tab">
                    Dados Pessoais
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="saude-tab" data-bs-toggle="tab" data-bs-target="#saude" type="button" role="tab">
                    Saúde
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="responsaveis-tab" data-bs-toggle="tab" data-bs-target="#responsaveis" type="button" role="tab">
                    Responsáveis
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="documentos-tab" data-bs-toggle="tab" data-bs-target="#documentos" type="button" role="tab">
                    Documentos
                </button>
            </li>
        </ul>

        <div class="tab-content" id="cadastroTabContent">
            <!-- Dados Pessoais -->
            <div class="tab-pane fade show active" id="dados-pessoais" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Dados Pessoais</h5>
                        <p class="card-subtitle text-muted">Informações básicas da criança</p>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nome" class="form-label">Nome Completo</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome completo da criança" required>
                            </div>
                            <div class="col-md-6">
                                <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gênero</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="genero" id="feminino" value="feminino" checked>
                                    <label class="form-check-label" for="feminino">Feminino</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="genero" id="masculino" value="masculino">
                                    <label class="form-check-label" for="masculino">Masculino</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="genero" id="outro" value="outro">
                                    <label class="form-check-label" for="outro">Outro</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="turma" class="form-label">Turma</label>
                                <select class="form-select" id="turma" name="turma">
                                    <option selected disabled value="">Selecione a turma</option>
                                    <option value="berçario">Berçário</option>
                                    <option value="maternal-i">Maternal I</option>
                                    <option value="maternal-ii">Maternal II</option>
                                    <option value="jardim-i">Jardim I</option>
                                    <option value="jardim-ii">Jardim II</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="periodo" class="form-label">Período</label>
                                <select class="form-select" id="periodo" name="periodo">
                                    <option selected disabled value="">Selecione o período</option>
                                    <option value="integral">Integral</option>
                                    <option value="matutino">Matutino</option>
                                    <option value="vespertino">Vespertino</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="observacoes" class="form-label">Observações</label>
                            <textarea class="form-control" id="observacoes" name="observacoes" rows="4" placeholder="Observações adicionais sobre a criança"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Saúde -->
            <div class="tab-pane fade" id="saude" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informações de Saúde</h5>
                        <p class="card-subtitle text-muted">Dados médicos e de saúde da criança</p>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="alergias" class="form-label">Alergias</label>
                            <textarea class="form-control" id="alergias" name="alergias" rows="3" placeholder="Liste todas as alergias conhecidas"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="medicacoes" class="form-label">Medicações</label>
                            <textarea class="form-control" id="medicacoes" name="medicacoes" rows="3" placeholder="Liste medicações de uso contínuo"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="restricoes_alimentares" class="form-label">Restrições Alimentares</label>
                            <textarea class="form-control" id="restricoes_alimentares" name="restricoes_alimentares" rows="3" placeholder="Liste todas as restrições alimentares"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="necessidades_especiais" class="form-label">Necessidades Especiais</label>
                            <textarea class="form-control" id="necessidades_especiais" name="necessidades_especiais" rows="3" placeholder="Descreva necessidades especiais, se houver"></textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tipo_sanguineo" class="form-label">Tipo Sanguíneo</label>
                                <select class="form-select" id="tipo_sanguineo" name="tipo_sanguineo">
                                    <option selected disabled value="">Selecione o tipo</option>
                                    <option value="a+">A+</option>
                                    <option value="a-">A-</option>
                                    <option value="b+">B+</option>
                                    <option value="b-">B-</option>
                                    <option value="ab+">AB+</option>
                                    <option value="ab-">AB-</option>
                                    <option value="o+">O+</option>
                                    <option value="o-">O-</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="convenio_medico" class="form-label">Convênio Médico</label>
                                <input type="text" class="form-control" id="convenio_medico" name="convenio_medico" placeholder="Nome do convênio">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Responsáveis -->
            <div class="tab-pane fade" id="responsaveis" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Responsáveis</h5>
                        <p class="card-subtitle text-muted">Informações dos responsáveis pela criança</p>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h5 class="mb-3">Responsável Principal</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nome_responsavel_1" class="form-label">Nome Completo</label>
                                    <input type="text" class="form-control" id="nome_responsavel_1" name="nome_responsavel_1" placeholder="Nome do responsável" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="parentesco_1" class="form-label">Parentesco</label>
                                    <select class="form-select" id="parentesco_1" name="parentesco_1">
                                        <option selected disabled value="">Selecione o parentesco</option>
                                        <option value="mae">Mãe</option>
                                        <option value="pai">Pai</option>
                                        <option value="avo">Avó/Avô</option>
                                        <option value="tio">Tio/Tia</option>
                                        <option value="outro">Outro</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="cpf_1" class="form-label">CPF</label>
                                    <input type="text" class="form-control" id="cpf_1" name="cpf_1" placeholder="000.000.000-00" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="rg_1" class="form-label">RG</label>
                                    <input type="text" class="form-control" id="rg_1" name="rg_1" placeholder="00.000.000-0">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="telefone_1" class="form-label">Telefone</label>
                                    <input type="text" class="form-control" id="telefone_1" name="telefone_1" placeholder="(00) 00000-0000" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email_1" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email_1" name="email_1" placeholder="email@exemplo.com">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-3">Responsável Secundário</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nome_responsavel_2" class="form-label">Nome Completo</label>
                                    <input type="text" class="form-control" id="nome_responsavel_2" name="nome_responsavel_2" placeholder="Nome do responsável">
                                </div>
                                <div class="col-md-6">
                                    <label for="parentesco_2" class="form-label">Parentesco</label>
                                    <select class="form-select" id="parentesco_2" name="parentesco_2">
                                        <option selected disabled value="">Selecione o parentesco</option>
                                        <option value="mae">Mãe</option>
                                        <option value="pai">Pai</option>
                                        <option value="avo">Avó/Avô</option>
                                        <option value="tio">Tio/Tia</option>
                                        <option value="outro">Outro</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="cpf_2" class="form-label">CPF</label>
                                    <input type="text" class="form-control" id="cpf_2" name="cpf_2" placeholder="000.000.000-00">
                                </div>
                                <div class="col-md-6">
                                    <label for="rg_2" class="form-label">RG</label>
                                    <input type="text" class="form-control" id="rg_2" name="rg_2" placeholder="00.000.000-0">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="telefone_2" class="form-label">Telefone</label>
                                    <input type="text" class="form-control" id="telefone_2" name="telefone_2" placeholder="(00) 00000-0000">
                                </div>
                                <div class="col-md-6">
                                    <label for="email_2" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email_2" name="email_2" placeholder="email@exemplo.com">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="autorizados" class="form-label">Pessoas Autorizadas a Buscar</label>
                            <textarea class="form-control" id="autorizados" name="autorizados" rows="3" placeholder="Nome completo e parentesco das pessoas autorizadas a buscar a criança"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documentos -->
            <div class="tab-pane fade" id="documentos" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Documentos</h5>
                        <p class="card-subtitle text-muted">Documentos e arquivos da criança</p>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto da Criança</label>
                            <input class="form-control" type="file" id="foto" name="foto" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label for="certidao" class="form-label">Certidão de Nascimento</label>
                            <input class="form-control" type="file" id="certidao" name="certidao" accept=".pdf,.jpg,.jpeg,.png">
                        </div>

                        <div class="mb-3">
                            <label for="carteira_vacinacao" class="form-label">Carteira de Vacinação</label>
                            <input class="form-control" type="file" id="carteira_vacinacao" name="carteira_vacinacao" accept=".pdf,.jpg,.jpeg,.png">
                        </div>

                        <div class="mb-3">
                            <label for="laudo_medico" class="form-label">Laudo Médico (se aplicável)</label>
                            <input class="form-control" type="file" id="laudo_medico" name="laudo_medico" accept=".pdf,.jpg,.jpeg,.png">
                        </div>

                        <div class="mb-3">
                            <label for="outros_documentos" class="form-label">Outros Documentos</label>
                            <input class="form-control" type="file" id="outros_documentos" name="outros_documentos[]" multiple accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-end gap-2">
            <a href="{{ route('criancas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
    </form>
</div>
@endsection
