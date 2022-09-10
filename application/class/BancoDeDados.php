<?php
    class BancoDeDados{
        private $host = 'localhost';
        private $db_name = 'db_biblioteca';
        private $db_usuario = 'root';
        private $db_senha = '';
        protected $conexao;


        public function __construct() {
            try {
                $strConn = "mysql:host={$this->host};dbname={$this->db_name};";
                
                $this->conexao = new PDO($strConn, $this->db_usuario,$this->db_senha, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            } catch (PDOException $erro) {
                throw new Exception($erro->getMessage());
            }
         }

         public function pegarRegistro($sql, $parametros = []){
            try{
                $stmt = $this->conexao->prepare($sql);
                $stmt->execute($parametros);
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $erro) {
                throw new Exception($erro->getMessage());
            }
         }

         public function inserirRegistro($sql, $parametros = []){
            try{
                $stmt = $this->conexao->prepare($sql);
                $stmt->execute($parametros);
                return TRUE;
            } catch (PDOException $erro) {
                throw new Exception($erro->getMessage());
            }
         }

         public function atualizarRegistro($sql, $parametros = []){
            try{
                $stmt = $this->conexao->prepare($sql);
                $stmt->execute($parametros);
                return TRUE;
            } catch (PDOException $erro) {
                throw new Exception($erro->getMessage());
            }
         }

         public function pegarRegistros($sql, $parametros = []){
            try{
                $stmt = $this->conexao->prepare($sql);
                $stmt->execute($parametros);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $erro) {
                throw new Exception($erro->getMessage());
            }
         }

         public function excluirRegistro($sql, $parametros = []){
            try{
                $stmt = $this->conexao->prepare($sql);
                $stmt->execute($parametros);
                return TRUE;
            } catch (PDOException $erro) {
                throw new Exception($erro->getMessage());
            }
         }
    }
?>