<?php
declare(strict_types=1);

namespace Database;

/**
 * Classe para gerenciamento de conexão com o banco de dados.
 *
 * Fornece métodos para estabelecer e retornar uma conexão PDO com o banco de dados MySQL.
 *
 * @author Arthur Vieira <aprendizadoarthur@gmail.com>
 */
class Database
{
    /**
     * Instância estática da conexão PDO.
     *
     * @var \PDO|null
     */
    private static $PDO = null;

    /**
     * String DSN para conexão com o banco de dados.
     *
     * @var string
     */
    private string $dsn;

    /**
     * Nome de usuário para conexão com o banco de dados.
     *
     * @var string
     */
    private string $user;

    /**
     * Senha para conexão com o banco de dados.
     *
     * @var string
     */
    private string $pass;

    /**
     * Construtor da classe Database.
     *
     * Inicializa as credenciais de conexão com o banco de dados.
     *
     * @param string $host Host do banco de dados.
     * @param string $dbname Nome do banco de dados.
     * @param string $user Nome de usuário para conexão.
     * @param string $pass Senha para conexão.
     * @author Arthur Vieira <aprendizadoarthur@gmail.com>
     */
    public function __construct(string $host, string $dbname, string $user, string $pass)
    {
        $this->dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
        $this->user = $user;
        $this->pass = $pass;
    }

    /**
     * Obtém a conexão PDO com o banco de dados.
     *
     * Cria uma nova conexão PDO se não existir e a retorna.
     *
     * @return \PDO|null A instância da conexão PDO ou null em caso de erro.
     * @author Arthur Vieira <aprendizadoarthur@gmail.com>
     */
    public function getConnection()
    {
        try {
            self::$PDO = new \PDO($this->dsn, $this->user, $this->pass);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }

        return self::$PDO;
    }
}