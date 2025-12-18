<?php 
require_once 'Classes.php';

interface usuario_interface {
    public function inserir_usuario($nome_usuario, $sobrenome_usuario, $cpf_usuario, $email_usuario, $senha_usuario, $telefone_whatsapp);
    public function consulta_cpf($cpf_usuario);
    public function chama_usuario_perfil($id_usuario);
    public function conta_manifestacao_usuario($id_usuario);
    public function atualizar_usuario($id_usuario, $nome_usuario, $sobrenome_usuario, $email_usuario, $telefone_whatsapp);
    public function chama_usuario_anonimo();
}

interface tipo_manifestacoes {
    public function chama_tipo_manifestacoes();
}

interface interface_manifestacoes {
    public function inserir_manifestacao($motivo_manifestacao, $id_entidade_manifestacao, $id_tipo_manifestacao, $conteudo_manifestacao, $observacoes_manifestacao, $local_manifestacao, $arquivo_manifestacao, $id_usuario_manifestacao, $status_manifestacao, $data_manifestacao, $protocolo_manifestacao);
    public function chama_minhas_manifestacoes($id_usuario_manifestacao);
    public function chama_manifestacao($id_manifestacao);
}

interface interface_entidades {
    public function chama_email_entidade($id_entidade);
    public function chama_entidades();
    public function chama_entidade($id_entidade); 
}

interface interface_codigo_recuperacao {
    public function registra_codigo_recuperacao($codigo_codigo_recuperacao, $email_codigo_recuperacao, $data_codigo_recuperacao, $status_codigo_recuperacao, $cod_validador_codigo_recuperacao);
    public function consulta_codigo($email_codigo_recuperacao, $status_codigo_recuperacao, $data_codigo_recuperacao, $cod_validador_codigo_recuperacao);
    public function atualiza_status($status_codigo_recuperacao, $id_codigo_recuperacao);
}

?>