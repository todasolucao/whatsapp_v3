<?php
	require_once("../includes/padrao.inc.php");


    if($_GET['tipo'] == '1'){
        $query = mysqli_query($conexao, "SELECT * FROM tbatendimento") or die("Erro" . mysqli_error($conexao));
        
        $registros = array();
        while($row = mysqli_fetch_assoc($query)){
            $registros[] = $row;
        }
        $arquivo = 'atendimentos.json';
        $json = json_encode($registros);
        $file = fopen(__DIR__ . '/json/' . $arquivo,'w');
        fwrite($file, $json);
        fclose($file);
        
    }elseif($_GET['tipo'] == '2'){
        $query = mysqli_query($conexao, "SELECT ta.id, ta.numero, ta.nome, CASE WHEN  tc.nome IS NULL then ta.nome when tc.nome = '' then ta.nome else tc.nome END  AS nomeContato, ta.canal, ta.id_atend, ta.nome_atend, td.departamento,  ta.nome_empresa  
						,(SELECT nome FROM tbusuario WHERE id = ta.id_atend) AS operador
						,(SELECT MAX(hr_msg) FROM tbmsgatendimento WHERE id = ta.id and numero = ta.numero) AS ordem
						, tbe.cor, tbe.descricao as etiqueta
						FROM tbatendimento ta 
							LEFT JOIN tbdepartamentos td ON(td.id = ta.setor)
							left JOIN tbcontatos tc ON ta.numero = tc.numero
							LEFT JOIN tbetiquetas tbe on tbe.id = tc.idetiqueta
						WHERE ta.situacao = 'A'
					    ORDER BY ordem DESC;") or die("Erro" . mysqli_error($conexao));
        
        $registros = array();
        while($row = mysqli_fetch_assoc($query)){
            $registros[] = $row;
        }
        
        $arquivo = 'mensagensAtendendo.json';
        $json = json_encode($registros);
        $file = fopen(__DIR__ . '/json/' . $arquivo,'w');
        fwrite($file, $json);
        fclose($file);
        
    }elseif($_GET['tipo'] == '3'){
    
        	$query = mysqli_query(
        		$conexao
        		, "SELECT ta.id, ta.numero, ta.nome, CASE WHEN  tc.nome IS NULL then ta.nome when tc.nome = '' then ta.nome else tc.nome END  AS nomeContato, ta.canal, ta.id_atend, ta.nome_atend, td.departamento,  ta.nome_empresa  
						,(SELECT nome FROM tbusuario WHERE id = ta.id_atend) AS operador
						,(SELECT MAX(hr_msg) FROM tbmsgatendimento WHERE id = ta.id and numero = ta.numero) AS ordem
						, tbe.cor, tbe.descricao as etiqueta
						FROM tbatendimento ta 
							LEFT JOIN tbdepartamentos td ON(td.id = ta.setor)
							left JOIN tbcontatos tc ON ta.numero = tc.numero
							LEFT JOIN tbetiquetas tbe on tbe.id = tc.idetiqueta
						WHERE ta.situacao = 'T'
					    ORDER BY ordem DESC;"
        	);
            
                
            $registros = array();
            while($row = mysqli_fetch_assoc($query)){
                $registros[] = $row;
            }
            
            $arquivo = 'atendimentosTriagem.json';
            $json = json_encode($registros);
            $file = fopen(__DIR__ . '/json/' . $arquivo,'w');
            fwrite($file, $json);
            fclose($file);
            
    
    }elseif($_GET['tipo'] == '4'){
        
        	$query = mysqli_query($conexao, "SELECT ta.id, ta.numero, ta.nome, CASE WHEN  tc.nome IS NULL then ta.nome when tc.nome = '' then ta.nome else tc.nome END  AS nomeContato, ta.canal, ta.id_atend, ta.nome_atend, td.departamento,  ta.nome_empresa  
						,(SELECT nome FROM tbusuario WHERE id = ta.id_atend) AS operador
						,(SELECT MAX(hr_msg) FROM tbmsgatendimento WHERE id = ta.id and numero = ta.numero) AS ordem
						, tbe.cor, tbe.descricao as etiqueta
						FROM tbatendimento ta 
							LEFT JOIN tbdepartamentos td ON(td.id = ta.setor)
							left JOIN tbcontatos tc ON ta.numero = tc.numero
							LEFT JOIN tbetiquetas tbe on tbe.id = tc.idetiqueta
						WHERE ta.situacao = 'E'
					    ORDER BY ordem DESC;");
                
            $registros = array();
            while($row = mysqli_fetch_assoc($query)){
                $registros[] = $row;
            }
            $arquivo = 'atendimentosArquivadas.json';
            $json = json_encode($registros);
            $file = fopen(__DIR__ . '/json/' . $arquivo,'w');
            fwrite($file, $json);
            fclose($file);
    }elseif($_GET['tipo'] == '5'){
        
        	$query = mysqli_query($conexao, "SELECT ta.id, ta.numero, ta.nome, CASE WHEN  tc.nome IS NULL then ta.nome when tc.nome = '' then ta.nome else tc.nome END  AS nomeContato, ta.canal, ta.id_atend, ta.nome_atend, td.departamento,  ta.nome_empresa  
						,(SELECT nome FROM tbusuario WHERE id = ta.id_atend) AS operador
						,(SELECT MAX(hr_msg) FROM tbmsgatendimento WHERE id = ta.id and numero = ta.numero) AS ordem
						, tbe.cor, tbe.descricao as etiqueta
						FROM tbatendimento ta 
							LEFT JOIN tbdepartamentos td ON(td.id = ta.setor)
							left JOIN tbcontatos tc ON ta.numero = tc.numero
							LEFT JOIN tbetiquetas tbe on tbe.id = tc.idetiqueta
						WHERE ta.situacao = 'P'
					    ORDER BY ordem DESC;");
                
            $registros = array();
            while($row = mysqli_fetch_assoc($query)){
                $registros[] = $row;
            }
            $arquivo = 'atendimentosPendentes.json';
            $json = json_encode($registros);
            $file = fopen(__DIR__ . '/json/' . $arquivo,'w');
            fwrite($file, $json);
            fclose($file);
            
    }elseif($_GET['tipo'] == '6'){
        $query = mysqli_query($conexao, "SELECT numero, foto_perfil, nome FROM tbcontatos ORDER BY nome DESC LIMIT 500") or die("Erro" . mysqli_error($conexao));
        
        $registros = array();
        while($row = mysqli_fetch_assoc($query)){
            $registros[] = $row;
        }
        
        $arquivo = 'contatos.json';
        $json = json_encode($registros);
        $file = fopen(__DIR__ . '/json/' . $arquivo,'w');
        fwrite($file, $json);
        fclose($file);
        
    }