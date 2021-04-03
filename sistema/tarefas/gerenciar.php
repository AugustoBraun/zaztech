     <button class="btn-add-task"><span>+</span>Adicionar Tarefa</button>

     <div class="help">
         <ul>
             <li>
                 Ao clicar em <strong> +  Adicionar Tarefa</strong> será criada uma nova Tarefa e basta começar a inserir os registros.
             </li>
             <li>
                 Não é necessário nenhuma ação adicional, ao interagir ou sair de cada campo os dados são registrados automaticamente.
             </li>
         </ul>


     </div>

        <table class="table-tarefas" cellspacing="0" id="tabela_editar">

            <thead>
            <tr id="header-line">
                <th width="5%">ID:</th>
                <th width="5%">Prio.:</th>
                <th>Usuário:</th>
                <th width="20%">Nome da Tarefa:</th>
                <th width="10%">Status:</th>
                <th width="10%">Início:</th>
                <th width="10%">Fim:</th>
                <th width="30%">Descrição</th>
                <th width="5%" nowrap>Excluir:</th>
            </tr>
            </thead>

            <tbody>
            <?php

                $select_usuarios = '';
                $lista_usuarios = array();

                if(!empty($usuarios) && is_array($usuarios))
                {
                    $select_usuarios = '<select name="usuarioId" class="select-usuario-id" id="select-usuario-id-##novatarefaid##" style="width: auto;" onchange="alteraUsuario(this);">
                                                    <option value="0">---selecione---</option>';
                    foreach($usuarios as $k => $v)
                    {
                        $select_usuarios .= '<option value="'.$v['id_login'].'">'.$v['nome'].'</option>';
                        $lista_usuarios[$v['id_login']] = $v['nome'];
                    }
                    $select_usuarios .= '</select>';
                }

                if(!empty($tarefas) && is_array($tarefas))
                {


                    foreach($tarefas as $k => $v)
                    {
                        $status = '<div id="altera-status-'.$v['tarefaId'].'" class="status Pendente" data-status="'.$v['tarefaStatus'].'" onclick="alteraStatus(\''.$v['tarefaId'].'\');">Pendente</div>';
                        if($v['tarefaStatus'] == 'b')
                            $status = '<div id="altera-status-'.$v['tarefaId'].'" class="status Andamento" data-status="'.$v['tarefaStatus'].'" onclick="alteraStatus(\''.$v['tarefaId'].'\');">Em Andamento</div>';
                        if($v['tarefaStatus'] == 'c')
                            $status = '<div id="altera-status-'.$v['tarefaId'].'" class="status Finalizada" data-status="'.$v['tarefaStatus'].'" onclick="alteraStatus(\''.$v['tarefaId'].'\');">Finalizada</div>';

                        echo '<tr id="line-' . $v['tarefaId'] . '" data-tarefa="' . $v['tarefaId'] . '" class="tarefa-line" valign="top">
                                <td align="center">' . $v['tarefaId'] . '</td>
                                <td align="center"><div  id="altera-prioridade-'.$v['tarefaId'].'" class="tarefa-prioridade prio'.$v['tarefaPrioridade'].'" onclick="alteraPrioridade(\''.$v['tarefaId'].'\');">'.$v['tarefaPrioridade'].'</div></td>
                                <td class="usuario-id" data-usuario-id="'.$v['usuarioId'].'">'.str_replace('##novatarefaid##',$v['tarefaId'],$select_usuarios).'</td>
                                <td><input type="text" name="tarefaNome" placeholder="Informe o nome da Tarefa" value="' . $v['tarefaNome'] . '"></td>
                                <td align="center" class="td-status">' . $status . '</td>
                                <td><input type="text" class="data-inicio" name="tarefaInicio" value="' . $v['tarefaInicio'] . '"></td>
                                <td><input type="text" class="data-fim" name="tarefaFim" value="' . $v['tarefaFim'] . '"></td>
                                <td><textarea name="tarefaDescricao" class="field-descricao" rows="10">' . $v['tarefaDescricao'] . '</textarea></td>
                                <td align="center" class="line-btns">
                                        <a href="javascript://" class="tooltip" onClick="
                                                confirmaCallback(\'Confirma Exclusão da Tarefa ID  <font color=999999> ' . htmlentities($v['tarefaId'], ENT_QUOTES) . '</font>?\',
                                                deletaTarefa, \'' . $v['tarefaId'] . '\');">
                                                <img src="/sistema/img/ico/16_excluir.png">
                                                <span>Excluir Tarefa ID ' . $v['tarefaId'] . '</span>
                                        </a>
                                    </td>
                                </tr>';
                    }
                }

            ?>
            </tbody>
        </table>
        <script>

            $(document).ready(function()
            {
                var tarefaId;
                var tarefaNome;
                var tarefaInicio;
                var tarefaFim;
                var tarefaDescricao;

                $(".data-inicio").datepicker({
                    onSelect: function(selectedDate)
                    {
                        tarefaInicio = selectedDate;
                        gravaData(tarefaInicio,'Inicio');
                    }
                });
                $(".data-fim").datepicker({
                    onSelect: function(selectedDate)
                    {
                        tarefaFim = selectedDate;
                        gravaData(tarefaFim,'Fim');
                    }
                });

                //gera uma nova tarefa vazia, retorna o novo ID e aguarda dados para edição dinamica
                $('.btn-add-task').click(function()
                {
                    //recupera a proxima ocorrencia do banco de dados de tarefas
                    $.get('/sistema/tarefas/criaTarefa',function(data)
                    {
                        var new_id = data;
                        var new_line = $('#proto-line').prop('outerHTML');

                        new_line = replaceAll(new_line,'##novatarefaid##',new_id);
                        new_line = replaceAll(new_line,'proto-line','line-' + new_id);

                        $('#tabela_editar tbody').prepend($.parseHTML(new_line));

                        setTimeout(function()
                        {
                            $(".data-inicio-novopicker").datepicker();
                            $(".data-fim-novopicker").datepicker();
                        },500);

                    });
                });



                $('.field-descricao').click(function(e)
                {
                    var element = $(this);
                    element.addClass('abrindo');

                });



                var $win = $(window);
                var $box = $(".field-descricao");
                $win.on("click.Bst", function(event)
                {
                    if ($box.has(event.target).length == 0 &&  !$box.is(event.target))
                    {
                        $('.field-descricao.abrindo').removeClass('abrindo').addClass('fechando')
                        setTimeout(function()
                        {
                            $('.field-descricao').removeClass('fechando');
                        },1000);
                    }
                });



                $('input[name="tarefaNome"]').focus(function()
                {
                    tarefaId = $(this).parents('.tarefa-line').attr('id').split('-')[1];
                }).blur(function()
                {
                    var campo = 'Nome';
                    var sendData = {
                        tarefaId: tarefaId,
                        valor: $(this).val(),
                        campo: campo
                    }
                    if($(this).val().length > 0)
                    {
                        $.post('/sistema/tarefas/editarCampo', sendData, function(data)
                        {
                            if(data != 'OK')
                                alert('Erro ao editar o ' + campo + ' da Tarefa');
                        });
                    }
                });

                $('textarea[name="tarefaDescricao"]').focus(function()
                {
                    tarefaId = $(this).parents('.tarefa-line').attr('id').split('-')[1];
                }).blur(function()
                {
                    var campo = 'Descricao';
                    var sendData = {
                        tarefaId: tarefaId,
                        valor: $(this).val(),
                        campo: campo
                    }
                    if($(this).val().length > 0)
                    {
                        $.post('/sistema/tarefas/editarCampo', sendData, function(data)
                        {
                            if(data != 'OK')
                                alert('Erro ao editar o ' + campo + ' da Tarefa');
                        });
                    }
                });


                function gravaData(data,campo)
                {
                    var sendData = {
                        tarefaId: tarefaId,
                        valor: data,
                        campo: campo
                    }
                    $.post('/sistema/tarefas/editarCampo', sendData, function(data)
                    {
                        if(data != 'OK')
                            alert('Erro ao editar o ' + campo + ' da Tarefa');
                    });
                }


                $('input[name="tarefaInicio"]').focus(function() {
                    tarefaId = $(this).parents('.tarefa-line').attr('id').split('-')[1];
                });

                $('input[name="tarefaFim"]').focus(function() {
                    tarefaId = $(this).parents('.tarefa-line').attr('id').split('-')[1];
                });



                //seleciona os usuarios em loop para nao sobrecarregar o php com loopings de select
                $('.usuario-id').each(function(i,v)
                {
                    var id = $(this).data('usuario-id');
                    if(id > 0)
                        $(this).find('.select-usuario-id').val(id);
                });


            });


            function alteraPrioridade(id)
            {
                var element = $('#altera-prioridade-' + id);

                var prio = element.text();
                var nova_prio = '';

                var classe = element.attr('class').split(' ')[1];
                var nova_classe = '';

                switch (prio)
                {
                    case '1':
                        nova_prio = '2';
                        break;
                    case '3':
                        nova_prio = '1';
                        break;
                    default:
                        nova_prio = '3';
                }

                var sendData = {
                    prio: prio,
                    nova_prio: nova_prio,
                    tarefaId: id
                };

                $.post('/sistema/tarefas/alteraPrioridade', sendData, function (data)
                {
                    if (data == 'OK')
                    {
                        element.text(nova_prio)
                        element.removeClass('prio'+prio);
                        element.addClass('prio'+nova_prio);
                    }
                    else
                    {
                        alert('Erro ao alterar Prioridade');
                    }
                });
            }


            function alteraStatus(id)
            {
                var element = $('#altera-status-' + id);

                var status = element.attr('data-status');
                var new_status = '';

                var classe = element.attr('class').split(' ')[1];
                var nova_classe = '';

                var texto = element.text();
                var novo_texto = '';

                switch (status)
                {
                    case 'b':
                        new_status = 'c';
                        nova_classe = novo_texto = 'Finalizada';
                        break;
                    case 'c':
                        new_status = 'a';
                        nova_classe = novo_texto = 'Pendente';
                        break;
                    default:
                        new_status = 'b';
                        nova_classe = 'Andamento';
                        novo_texto = 'Em Andamento';
                }

                var tarefaId = element.parents('.tarefa-line').attr('id').split('-')[1];

                var sendData = {
                    status: status,
                    new_status: new_status,
                    tarefaId: tarefaId
                };

                $.post('/sistema/tarefas/alteraStatus', sendData, function (data)
                {
                    if (data == 'OK')
                    {
                        element.attr('data-status', new_status);
                        element.removeClass(classe);
                        element.addClass(nova_classe);
                        element.text(novo_texto);
                    }
                    else
                    {
                        alert('Erro ao alterar Status');
                    }
                });
            }



            function alteraUsuario(el)
            {
                var id = el.id.replace('select-usuario-id-','');
                var usuarioId = el.value;

                var usuarioIdAnterior = $('#' + el.id).parent('.usuario-id').attr('data-usuario-id');
                if(usuarioIdAnterior == '')
                    usuarioIdAnterior = '0';

                var usuarioNome = $('#' + el.id).find('option:selected').text();

                if(usuarioId > 0)
                {
                    var sendData = {
                        usuarioId: usuarioId,
                        usuarioNome: usuarioNome,
                        tarefaId: id
                    }

                    $.post('/sistema/tarefas/atribuirUsuario', sendData, function(data)
                    {
                        if(data != 'OK')
                        {
                            alert(data);
                            setTimeout(function()
                            {
                                $('#' + el.id).val(usuarioIdAnterior);
                            },100);

                        }
                        else
                        {
                            $('#' + el.id).parents('.usuario-id').attr('data-usuario-id',usuarioId);
                        }
                    });
                }
            }




        </script>

        <!-- html prototipo para construçao das linhas -->

        <table style="display:none;">
            <tr id="proto-line" data-tarefa="##novatarefaid##" class="tarefa-line" valign="top">
                <td align="center">##novatarefaid##</td>
                <td align="center"><div id="altera-prioridade-##novatarefaid##" class="tarefa-prioridade prio2" onclick="alteraPrioridade('##novatarefaid##');">2</div></td>
                <td class="usuario-id" data-usuario-id=""><?php echo $select_usuarios; ?></td>
                <td><input type="text" name="tarefaNome" placeholder="Informe o nome da Tarefa"></td>
                <td align="center" class="td-status">
                    <div id="altera-status-##novatarefaid##" class="status Pendente" data-status="a" onclick="alteraStatus('##novatarefaid##')">Pendente</div>
                </td>
                <td><input type="text" class="data-inicio-novopicker" name="tarefaInicio" value=""></td>
                <td><input type="text" class="data-fim-novopicker" name="tarefaFim" value=""></td>
                <td><textarea name="tarefaDescricao" class="field-descricao" rows="10"></textarea></td>
                <td align="center" class="line-btns">
                    <a href="javascript://" class="tooltip" onClick="
                                                            confirmaCallback('Confirma Exclusão da Tarefa ID <font color=999999>##novatarefaid##</font>?',
                                                            deletaTarefa,'##novatarefaid##');">
                        <img src="/sistema/img/ico/16_excluir.png">
                        <span>Excluir Tarefa ID ##novatarefaid##</span>
                    </a>
                </td>
            </tr>
        </table>


