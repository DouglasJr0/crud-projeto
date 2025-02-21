<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>CRUD de Usuários - Polícia Militar</title> 

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Toastr CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <!-- Bootstrap Datepicker CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  
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
      background-color: rgb(23, 40, 63);
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
    .modal-editar .modal-header {
      background-color: #198754;
    }
    .modal-exclusao .modal-header {
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
    /* Centraliza o conteúdo do DataTable */
    #tabelaUsuarios th, #tabelaUsuarios td {
      text-align: center;
    }
    /* Estiliza o cabeçalho do DataTable com a mesma cor do cabeçalho principal */
    #tabelaUsuarios thead th {
      background-color: rgb(23, 40, 63);
      color: white;
    }
    /* Move o campo de pesquisa um pouco para cima */
    #tabelaUsuarios_filter {
      margin-top: -40px;
    }

    #tabelaUsuarios_length{
      margin-bottom: 20 px; 
    }

    .btn btn-info btn-sm ms-1 visualizar{

      color:white;
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
    <!-- Formulário para cadastro (novalidate para desabilitar validação nativa) -->
    <form id="usuarioForm" class="mb-4" method="POST" novalidate>
      <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu Nome" minlength="3" maxlength="50">
      </div>
      <div class="mb-3">
        <label for="idade" class="form-label">Idade</label>
        <input type="number" class="form-control" id="idade" name="idade" placeholder="Digite sua Idade" min="18" max="120">
      </div>
      <div class="mb-3">
        <label for="data_nascimento" class="form-label">Data de Nascimento</label>
        <input type="text" class="form-control" id="data_nascimento" name="data_nascimento" placeholder="dd/mm/yyyy" minlength="3" maxlength="50">
      </div>
      <div class="mb-3">
        <label for="profissao" class="form-label">Profissão</label>
        <select class="form-select" id="profissao" name="profissao">
          <option value="">Selecione...</option>
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
        <!-- As linhas serão adicionadas via DataTables -->
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
            <input type="text" class="form-control" id="modal_data_nascimento" disabled>
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

  <!-- Modal para editar usuário (novalidate para desabilitar validação nativa) -->
  <div id="editarModal" class="modal fade modal-editar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Editar Usuário</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <form id="editarUsuarioForm" novalidate>
            <!-- Campo oculto para armazenar o ID do usuário -->
            <input type="hidden" id="edit_user_id" name="id">
            <div class="mb-3">
              <label for="modal_edit_nome" class="form-label">Nome</label>
              <input type="text" id="modal_edit_name" name="nome" class="form-control">
            </div>
            <div class="mb-3">
              <label for="modal_edit_idade" class="form-label">Idade</label>
              <input type="number" id="modal_edit_idade" name="idade" class="form-control" min="18" max="120">
            </div>     
            <div class="mb-3">
              <label for="modal_edit_data_nascimento" class="form-label">Data de Nascimento</label>
              <input type="text" id="modal_edit_data_nascimento" name="data_nascimento" class="form-control">
            </div>
            <div class="mb-3">
              <label for="modal_edit_profissao" class="form-label">Profissão</label>
              <select class="form-select" id="modal_edit_profissao" name="profissao">
                <option value="">Selecione...</option>
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

  <!-- Scripts -->
  <!-- jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <!-- Moment.js para formatação de datas -->
  <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
  <!-- Toastr -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <!-- Bootstrap Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <!-- jQuery Validate -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
  <!-- Bootstrap Datepicker JS e Locale -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>
  
  <script>
    $(document).ready(function () {
      // Inicializa o datepicker nos campos de data com o formato dd/mm/yyyy
      $('#data_nascimento, #modal_edit_data_nascimento').datepicker({
        format: 'dd/mm/yyyy',
        language: 'pt-BR',
        autoclose: true
      });
      
      // Inicializa o DataTable e guarda a instância em "tabela"
      var tabela = $('#tabelaUsuarios').DataTable({
        "paging": true,
        "lengthMenu": [5, 10, 25, 50],
        "pageLength": 5,
        "searching": true,
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
        },
        "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
               '<"row"<"col-sm-12"tr>>' +
               '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        "initComplete": function() {
          $('#tabelaUsuarios_filter input').attr('placeholder', 'Digite para buscar...').addClass('form-control');
        }
      });
      
      // Função para carregar os usuários via AJAX e atualizar o DataTable
      function carregarUsuarios() {
        $.ajax({
          type: "GET",
          url: "/telaUsuario",
          dataType: "json",
          success: function (usuarios) {
            tabela.clear(); // Limpa os registros existentes
            $.each(usuarios, function (index, usuario) {
              adicionarLinhaTabela(usuario);
            });
            tabela.draw();
          },
          error: function () {
            toastr.error("Erro ao carregar os usuários.");
          }
        });
      }
      
      // Adiciona uma linha usando a API do DataTables com formatação de data
      function adicionarLinhaTabela(usuario) {
        var formattedDate = moment(usuario.data_nascimento, "YYYY-MM-DD").format("DD/MM/YYYY");
        var rowNode = tabela.row.add([
          usuario.nome,
          usuario.idade,
          formattedDate,
          usuario.profissao,
          `<button class='btn btn-info btn-sm ms-1 visualizar ' style="color:white" data-id='${usuario.id}'><i class='fas fa-eye'></i></button>
           <button class='btn btn-success btn-sm ms-1 editar' data-id='${usuario.id}'><i class='fas fa-edit'></i></button>
           <button class='btn btn-danger btn-sm ms-1 deletar' data-id='${usuario.id}'><i class='fas fa-trash'></i></button>`
        ]).draw().node();
        $(rowNode).attr('data-id', usuario.id);
      }
      
      // Salvar usuário (formulário principal)
      $('#usuarioForm').submit(function (e) {
        e.preventDefault();
        if ($('#nome').val().trim() === '') {
          toastr.error("Erro: O campo Nome é obrigatório.");
          $('#nome').focus();
          return;
        }
        if ($('#idade').val().trim() === '') {
          toastr.error("Erro: O campo Idade é obrigatório.");
          $('#idade').focus();
          return;
        }
        if ($('#data_nascimento').val().trim() === '') {
          toastr.error("Erro: O campo Data de Nascimento é obrigatório.");
          $('#data_nascimento').focus();
          return;
        }
        if ($('#profissao').val().trim() === '') {
          toastr.error("Erro: O campo Profissão é obrigatório.");
          $('#profissao').focus();
          return;
        }

        var nome = $('#nome').val();
        var idade = $('#idade').val();
        var dataNascimento = $('#data_nascimento').val();
        var profissao = $('#profissao').val();

        if (idade.length > 3) {
          toastr.error("Erro: A idade não pode ter mais de três dígitos.");
          return;
        }

        // Converter a data para o formato YYYY-MM-DD
        var dataNascimentoFormatada = moment(dataNascimento, "DD/MM/YYYY").format("YYYY-MM-DD");

        let formData = { 
          nome: nome, 
          idade: idade, 
          data_nascimento: dataNascimentoFormatada, 
          profissao: profissao 
        };

        $.ajax({
          type: "POST",
          url: "/cadastrarUsuario",
          data: formData,
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          dataType: "json",
          success: function (usuario) {
            adicionarLinhaTabela(usuario);
            $('#usuarioForm').trigger("reset");
            toastr.success("Usuário cadastrado com sucesso!");
          },
          error: function () {
            toastr.error("Erro ao salvar o usuário.");
          }
        });
      });
      
      // Visualizar usuário
      $(document).on('click', '.visualizar', function () {
        let id = $(this).data('id');
        $.ajax({
          url: '/visualizarUsuarios/' + id,
          type: 'GET',
          success: function (response) {
            $('#modal_nome').val(response.nome);
            $('#modal_idade').val(response.idade);
            $('#modal_data_nascimento').val(moment(response.data_nascimento, "YYYY-MM-DD").format("DD/MM/YYYY"));
            $('#modal_profissao').val(response.profissao);
            $('#visualizarModal').modal('show');
          },
          error: function () {
            toastr.error('Erro ao carregar os detalhes.');
          }
        });
      });
      
      // Editar usuário: carrega os dados e armazena o ID no campo oculto
      $(document).on('click', '.editar', function () {
        let id = $(this).data('id');
        $.ajax({
          url: '/visualizarUsuarios/' + id,
          type: 'GET',
          success: function (response) {
            $('#edit_user_id').val(id);
            $('#modal_edit_name').val(response.nome);
            $('#modal_edit_idade').val(response.idade);
            $('#modal_edit_data_nascimento').val(moment(response.data_nascimento, "YYYY-MM-DD").format("DD/MM/YYYY"));
            $('#modal_edit_profissao').val(response.profissao);
            $('#editarModal').modal('show');
          },
          error: function () {
            toastr.error('Erro ao carregar os dados para edição.');
          }
        });
      });
      
      // Salvar edição do usuário no modal
      $('#salvar-edicao').click(function () {
        let id = $('#edit_user_id').val();
        if ($('#modal_edit_name').val().trim() === '') {
          toastr.error("Erro: O campo Nome é obrigatório.");
          $('#modal_edit_name').focus();
          return;
        }
        if ($('#modal_edit_idade').val().trim() === '') {
          toastr.error("Erro: O campo Idade é obrigatório.");
          $('#modal_edit_idade').focus();
          return;
        }
        if ($('#modal_edit_data_nascimento').val().trim() === '') {
          toastr.error("Erro: O campo Data de Nascimento é obrigatório.");
          $('#modal_edit_data_nascimento').focus();
          return;
        }
        if ($('#modal_edit_profissao').val().trim() === '') {
          toastr.error("Erro: O campo Profissão é obrigatório.");
          $('#modal_edit_profissao').focus();
          return;
        }
      
        let nome = $('#modal_edit_name').val();
        let idade = $('#modal_edit_idade').val();
        let dataNascimento = $('#modal_edit_data_nascimento').val();
        let profissao = $('#modal_edit_profissao').val();

        if (idade.length > 3) {
          toastr.error("Erro: A idade não pode ter mais de três dígitos.");
          return;
        }

        $.ajax({
          url: '/atualizarUsuario/' + id,
          method: 'PUT',
          data: {
            nome: nome,
            idade: idade,
            data_nascimento: moment(dataNascimento, 'DD/MM/YYYY').format('YYYY-MM-DD'),
            profissao: profissao
          },
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          success: function () {
            $('#editarModal').modal('hide');
            toastr.success('Registro atualizado com sucesso!');
            carregarUsuarios();
          },
          error: function (xhr) {
            console.log(xhr.responseText);
            toastr.error('Erro ao atualizar registro.');
          }
        });
      });
      
      // Deletar usuário
      $(document).on('click', '.deletar', function () {
        let id = $(this).data('id');
        $('#confirmarExclusaoModal').modal('show');
        $('#confirmarExclusaoBtn').data('id', id);
      });
      
      $('#confirmarExclusaoBtn').click(function () {
        let id = $(this).data('id');
        $.ajax({
          url: '/deletarUsuario/' + id,
          type: 'DELETE',
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          success: function () {
            $('#confirmarExclusaoModal').modal('hide');
            tabela.row($('tr[data-id="' + id + '"]')).remove().draw();
            toastr.success('Registro excluído com sucesso!');
          },
          error: function () {
            toastr.error('Erro ao excluir registro.');
          }
        });
      });
      
      // Carrega os usuários ao iniciar
      carregarUsuarios();
    });
  </script>
</body>
</html>
