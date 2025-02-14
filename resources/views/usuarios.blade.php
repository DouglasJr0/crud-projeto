<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CRUD de Usuários - Polícia Militar</title> 

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        body {
            background-color: rgb(245, 245, 245);
            font-family: Arial, sans-serif;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color:rgb(23, 40, 63);
            color: white;
            border-bottom: rgb(23, 40, 63);
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
            border-radius: 20px;
            overflow: hidden;
        }
        .modal-header {
            background-color: #0DCAF0;
        }
        .modal-editar .modal-header{
            background-color: #198754;
        }
        .modal-exclusao .modal-header{
            background-color: #DC3545;
        }
        .table-custom {
            background-color: rgb(23, 40, 63);
            color: white;
        }
        .table-custom th {
            background-color: rgb(23, 40, 63);
            color: white;
        }
        .table-custom td {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>CRUD de Usuários - Polícia Militar</h1>
        <img src="https://seeklogo.com/images/B/brasao-ddtq-policia-militar-parana-logo-F880BA714A-seeklogo.com.png">
    </div>
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
            <button id="btn-salvar" type="submit" class="btn btn-primary w-20">Salvar</button> 
        </form>
        <h2>Lista de Usuários</h2>
        <table id="tabelaUsuarios" class="table table-bordered">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Idade</th>
            <th>Data de Nascimento</th>
            <th>Profissão</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody id="usuariosTable">
        <!-- As linhas de usuários serão adicionadas aqui via JavaScript -->
    </tbody>
</table>
</div>
    <!-- Modal para visualização de usuário -->
    <div class="modal fade modal-visualizar" id="visualizarModal" tabindex="-1" aria-labelledby="visualizarModalLabel" aria-hidden="true">
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
<div id="editarModal" class="modal fade modal-editar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form id="editarUsuarioForm">
                    <div class="mb-3">
                        <label for="modal_edit_nome" class="form-label">Nome</label>
                        <input type="text" id="modal_edit_name" name="nome" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="modal_edit_idade" class="form-label">Idade</label>
                        <input type="number" id="modal_edit_idade" name="idade" class="form-control" required min="18" max="120" maxlength="3">
                    </div>     
                    <div class="mb-3">
                        <label for="modal_edit_profissao" class="form-label">Data de Nascimento</label>
                        <input type="date" id="modal_edit_data_nascimento" name="data_nascimento" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="modal_edit_profissao" class="form-label">Profissao</label>
                        <select class="form-select" id="modal_edit_profissao" name="profissao" required>
                            <option value="Desenvolvedor">Desenvolvedor</option>
                            <option value="Designer">Designer</option>
                            <option value="Gerente">Gerente</option>
                            <option value="Analista">Analista</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="salvar-edicao">Salvar</button>
            </div>
        </div>
    </div>
</div>

    <!-- Modal de confirmação de exclusão -->
    <div class="modal fade modal-exclusao" id="confirmarExclusaoModal" tabindex="-1" aria-labelledby="confirmarExclusaoModalLabel" aria-hidden="true">
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
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script>
// Ajuste no JavaScript para exibir os dados corretamente
$(document).ready(function () {
    $('#tabelaUsuarios').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/telaUsuario",
            "type": "GET"
        },
        "columns": [
            { "data": "nome" },
            { "data": "idade" },
            { "data": "data_nascimento" },
            { "data": "profissao" },
            {
                "data": "id",
                "render": function (data) {
                    return `
                        <button class='btn btn-info btn-sm visualizar' data-id='${data}'><i class='fas fa-eye'></i></button>
                        <button class='btn btn-success btn-sm editar' data-id='${data}'><i class='fas fa-edit'></i></button>
                        <button class='btn btn-danger btn-sm deletar' data-id='${data}'><i class='fas fa-trash'></i></button>
                    `;
                }
            }
        ],
        "language": {
            "sProcessing": "Processando...",
            "sLengthMenu": "Exibir _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Exibindo de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Exibindo 0 até 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros no total)",
            "sSearch": "Buscar pelo nome:",
            "oPaginate": {
                "sFirst": "Primeiro",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        }
    });

    // Atualizar tabela após cadastro bem-sucedido
    $('#btn-salvar').click(function (e) {
        e.preventDefault();
        let formData = {
            nome: $('#nome').val(),
            idade: $('#idade').val(),
            data_nascimento: $('#data_nascimento').val(),
            profissao: $('#profissao').val()
        };

        $.ajax({
            type: "POST",
            url: "/cadastrarUsuario",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                toastr.success("Usuário cadastrado com sucesso!");
                $('#tabelaUsuarios').DataTable().ajax.reload();
                $('#usuarioForm').trigger("reset");
            },
            error: function () {
                toastr.error("Erro ao salvar o usuário.");
            }
        });
    });

    // Evento para visualizar detalhes
    $(document).on('click', '.visualizar', function () {
        let id = $(this).data('id');

        $.ajax({
            url: '/visualizarUsuarios/' + id,
            type: 'GET',
            success: function (response) {
                $('#modal_nome').val(response.nome);
                $('#modal_idade').val(response.idade);
                $('#modal_data_nascimento').val(response.data_nascimento);
                $('#modal_profissao').val(response.profissao);
                $('#visualizarModal').modal('show');
            },
            error: function () {
                toastr.error('Erro ao carregar os detalhes.');
            }
        });
    });

    // Evento para editar usuário
    $(document).on('click', '.editar', function () {
        let id = $(this).data('id');

        $.ajax({
            url: '/visualizarUsuarios/' + id,
            type: 'GET',
            success: function (response) {
                $('#modal_edit_name').val(response.nome);
                $('#modal_edit_idade').val(response.idade);
                $('#modal_edit_data_nascimento').val(response.data_nascimento);
                $('#modal_edit_profissao').val(response.profissao);
                $('#editarModal').data('id', id);
                $('#editarModal').modal('show');
            },
            error: function () {
                toastr.error('Erro ao carregar os dados para edição.');
            }
        });
    });

    // Salvar edição
    $('#salvar-edicao').click(function () {
        let id = $('#editarModal').data('id');

        $.ajax({
            url: '/atualizarUsuario/' + id,
            type: 'PUT',
            data: {
                nome: $('#modal_edit_name').val(),
                idade: $('#modal_edit_idade').val(),
                data_nascimento: $('#modal_edit_data_nascimento').val(),
                profissao: $('#modal_edit_profissao').val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                $('#editarModal').modal('hide');
                tabela.ajax.reload();
                toastr.success('Registro atualizado com sucesso!');
            },
            error: function () {
                toastr.error('Erro ao atualizar registro.');
            }
        });
    });

    // Evento para deletar usuário
    $(document).on('click', '.deletar', function () {
        let id = $(this).data('id');
        $('#confirmarExclusaoModal').modal('show');
        $('#confirmarExclusaoBtn').data('id', id);
    });

    // Confirmar exclusão
    $('#confirmarExclusaoBtn').click(function () {
        let id = $(this).data('id');

        $.ajax({
            url: '/deletarUsuario/' + id,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                $('#confirmarExclusaoModal').modal('hide');
                tabela.ajax.reload();
                toastr.success('Registro excluído com sucesso!');
            },
            error: function () {
                toastr.error('Erro ao excluir registro.');
            }
        });
    });
});

</script>
</body>
</html>
