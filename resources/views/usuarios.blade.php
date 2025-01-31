<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Usuários - Polícia Militar</title> 

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #ffffff, #e0f7fa); /* Fundo branco e azul */
            font-family: Arial, sans-serif;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #0047ab;
            color: white;
            border-bottom: 3px solid #003580;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
        }
        .header img {
            height: 60px;
        }
        .container {
            margin-top: 20px;
        }
        .table {
            background-color: white;
            border-radius: 5px;
            overflow: hidden;
        }
        .modal-header {
            background-color: #0047ab;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Cabeçalho -->
    <div class="header">
        <h1>CRUD de Usuários - Polícia Militar</h1>
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/bc/Logo_PMPR_2.svg/800px-Logo_PMPR_2.svg.png" alt="Símbolo da Polícia Militar">
    </div>

    <!-- Conteúdo principal -->
    <div class="container">
        <h2 class="mb-4">Gerenciar Usuários</h2>
        <form id="usuarioForm" class="mb-4">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required minlength="3" maxlength="50">
            </div>
            <div class="mb-3">
                <label for="idade" class="form-label">Idade</label>
                <input type="number" class="form-control" id="idade" name="idade" required min="18" max="120">
            </div>
            <div class="mb-3">
                <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
            </div>
            <div class="mb-3">
                <label for="profissao" class="form-label">Profissão</label>
                <select class="form-select" id="profissao" name="profissao" required>
                    <option value="Desenvolvedor">Desenvolvedor</option>
                    <option value="Designer">Designer</option>
                    <option value="Gerente">Gerente</option>
                    <option value="Analista">Analista</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>

        <h2>Lista de Usuários</h2>
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nome</th>
                    <th>Idade</th>
                    <th>Data de Nascimento</th>
                    <th>Profissão</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="usuariosTable">
                <!-- Os usuários serão adicionados dinamicamente aqui -->
            </tbody>
        </table>
    </div>

    <!-- Modal para visualização de usuário -->
    <div class="modal fade" id="visualizarModal" tabindex="-1" aria-labelledby="visualizarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="visualizarModalLabel">Detalhes do Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Campos de input para visualização -->
                    <div class="mb-3">
                        <label for="modal_nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="modal_nome" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="modal_idade" class="form-label">Idade</label>
                        <input type="number" class="form-control" id="modal_idade" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="modal_data_nascimento" class="form-label">Data de Nascimento</label>
                        <input type="date" class="form-control" id="modal_data_nascimento" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="modal_profissao" class="form-label">Profissão</label>
                        <input type="text" class="form-control" id="modal_profissao" disabled>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar usuário -->
    <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarModalLabel">Editar Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Campos de input para edição -->
                    <div class="mb-3">
                        <label for="modal_edit_nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="modal_edit_nome">
                    </div>
                    <div class="mb-3">
                        <label for="modal_edit_idade" class="form-label">Idade</label>
                        <input type="number" class="form-control" id="modal_edit_idade">
                    </div>
                    <div class="mb-3">
                        <label for="modal_edit_data_nascimento" class="form-label">Data de Nascimento</label>
                        <input type="date" class="form-control" id="modal_edit_data_nascimento">
                    </div>
                    <div class="mb-3">
                        <label for="modal_edit_profissao" class="form-label">Profissão</label>
                        <input type="text" class="form-control" id="modal_edit_profissao">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="salvarEdicaoBtn">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmação de exclusão -->
    <div class="modal fade" id="confirmarExclusaoModal" tabindex="-1" aria-labelledby="confirmarExclusaoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmarExclusaoModalLabel">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza de que deseja excluir este usuário?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmarExclusaoBtn">Excluir</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Referência ao formulário e à tabela
        const usuarioForm = document.getElementById('usuarioForm');
        const usuariosTable = document.getElementById('usuariosTable');
        let usuarioEditando = null;

        // Função para carregar os usuários do localStorage
        function carregarUsuarios() {
            const usuarios = JSON.parse(localStorage.getItem('usuarios')) || [];
            usuarios.forEach(usuario => {
                adicionarUsuarioNaTabela(usuario);
            });
        }

        // Função para salvar usuários no localStorage
        function salvarUsuarios() {
            const usuarios = [];
            usuariosTable.querySelectorAll('tr').forEach(linha => {
                const nome = linha.cells[0].textContent;
                const idade = linha.cells[1].textContent;
                const dataNascimento = linha.cells[2].textContent;
                const profissao = linha.cells[3].textContent;
                usuarios.push({ nome, idade, dataNascimento, profissao });
            });
            localStorage.setItem('usuarios', JSON.stringify(usuarios));
        }

        // Função para adicionar um usuário na tabela
        function adicionarUsuarioNaTabela(usuario) {
            const novaLinha = document.createElement('tr');
            novaLinha.innerHTML = ` 
                <td>${usuario.nome}</td>
                <td>${usuario.idade}</td>
                <td>${usuario.dataNascimento}</td>
                <td>${usuario.profissao}</td>
                <td>
                    <button class="btn btn-info btn-sm" onclick="visualizarUsuario('${usuario.nome}', ${usuario.idade}, '${usuario.dataNascimento}', '${usuario.profissao}')">Visualizar</button>
                    <button class="btn btn-success btn-sm" onclick="editarUsuario('${usuario.nome}', ${usuario.idade}, '${usuario.dataNascimento}', '${usuario.profissao}')">Editar</button>
                    <button class="btn btn-danger btn-sm" onclick="pedirConfirmacaoExclusao('${usuario.nome}')">Deletar</button>
                </td>
            `;
            usuariosTable.appendChild(novaLinha);
        }

        // Função para adicionar ou editar usuário na tabela
        usuarioForm.addEventListener('submit', function (event) {
            event.preventDefault();

            if (!usuarioForm.checkValidity()) {
                event.stopPropagation();
                usuarioForm.classList.add('was-validated');
                return;
            }

            const nome = document.getElementById('nome').value;
            const idade = document.getElementById('idade').value;
            const dataNascimento = document.getElementById('data_nascimento').value;
            const profissao = document.getElementById('profissao').value;

            if (usuarioEditando === null) {
                adicionarUsuarioNaTabela({ nome, idade, dataNascimento, profissao });
                toastr.success('Usuário adicionado com sucesso!');
            } else {
                const linha = usuariosTable.rows[usuarioEditando];
                linha.cells[0].textContent = nome;
                linha.cells[1].textContent = idade;
                linha.cells[2].textContent = dataNascimento;
                linha.cells[3].textContent = profissao;
                usuarioEditando = null;
                toastr.success('Usuário atualizado com sucesso!');
            }

            salvarUsuarios();
            usuarioForm.reset();
            usuarioForm.classList.remove('was-validated');
        });

        // Função para visualizar os dados de um usuário
        function visualizarUsuario(nome, idade, dataNascimento, profissao) {
            document.getElementById('modal_nome').value = nome;
            document.getElementById('modal_idade').value = idade;
            document.getElementById('modal_data_nascimento').value = dataNascimento;
            document.getElementById('modal_profissao').value = profissao;

            // Mostrar o modal apenas para visualização (sem permitir edição)
            const modal = new bootstrap.Modal(document.getElementById('visualizarModal'));
            modal.show();
        }

        // Função para editar os dados de um usuário
        function editarUsuario(nome, idade, dataNascimento, profissao) {
            // Preencher os campos de input no modal com os dados do usuário
            document.getElementById('modal_edit_nome').value = nome;
            document.getElementById('modal_edit_idade').value = idade;
            document.getElementById('modal_edit_data_nascimento').value = dataNascimento;
            document.getElementById('modal_edit_profissao').value = profissao;

            // Ativar o botão de salvar no modal
            document.getElementById('salvarEdicaoBtn').onclick = function() {
                salvarEdicaoUsuario(nome);
            };

            // Mostrar o modal de edição
            const modal = new bootstrap.Modal(document.getElementById('editarModal'));
            modal.show();
        }

        // Função para salvar a edição no modal
        function salvarEdicaoUsuario(nomeAntigo) {
            const nome = document.getElementById('modal_edit_nome').value;
            const idade = document.getElementById('modal_edit_idade').value;
            const dataNascimento = document.getElementById('modal_edit_data_nascimento').value;
            const profissao = document.getElementById('modal_edit_profissao').value;

            const linha = Array.from(usuariosTable.rows).find(row => row.cells[0].textContent === nomeAntigo);
            if (linha) {
                linha.cells[0].textContent = nome;
                linha.cells[1].textContent = idade;
                linha.cells[2].textContent = dataNascimento;
                linha.cells[3].textContent = profissao;
                salvarUsuarios();
                toastr.success('Usuário editado com sucesso!');
            }

            const modal = bootstrap.Modal.getInstance(document.getElementById('editarModal'));
            modal.hide();
        }

        // Função para pedir confirmação de exclusão
        function pedirConfirmacaoExclusao(nome) {
            const modal = new bootstrap.Modal(document.getElementById('confirmarExclusaoModal'));
            document.getElementById('confirmarExclusaoBtn').onclick = function() {
                deletarUsuario(nome);
                modal.hide();
            };
            modal.show();
        }

        // Função para deletar um usuário
        function deletarUsuario(nome) {
            const linha = Array.from(usuariosTable.rows).find(row => row.cells[0].textContent === nome);
            if (linha) {
                usuariosTable.removeChild(linha);
                salvarUsuarios();
                toastr.warning('Usuário removido com sucesso!');
            }
        }

        // Carregar os usuários ao iniciar a página
        window.onload = carregarUsuarios;
    </script>
</body>
</html>
