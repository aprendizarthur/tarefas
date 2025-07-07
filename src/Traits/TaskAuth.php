<?php
declare(strict_types=1);

namespace Traits;

/**
 * Trait para autenticação e sanitização de dados de tarefas.
 *
 * Fornece métodos para validar o comprimento de título e descrição, e sanitizar IDs.
 *
 * @author Arthur Vieira <aprendizadoarthur@gmail.com>
 */
trait TaskAuth
{
    /**
     * Valida o comprimento do título da tarefa.
     *
     * Verifica se o título tem entre 1 e 20 caracteres.
     *
     * @param string $title Título da tarefa a ser validado.
     * @return bool True se o título for válido, false caso contrário.
     * @author Arthur Vieira <aprendizadoarthur@gmail.com>
     */
    public function AuthTitleLength(string $title) : bool
    {
        $bool = mb_strlen($title) > 0 && mb_strlen($title) <= 20 ? true : false;
        return $bool;
    }

    /**
     * Valida o comprimento da descrição da tarefa.
     *
     * Verifica se a descrição tem entre 1 e 500 caracteres.
     *
     * @param string $description Descrição da tarefa a ser validada.
     * @return bool True se a descrição for válida, false caso contrário.
     * @author Arthur Vieira <aprendizadoarthur@gmail.com>
     */
    public function AuthDescriptionLength(string $description) : bool
    {
        $bool = mb_strlen($description) > 0 && mb_strlen($description) <= 500 ? true : false;
        return $bool;
    }

    /**
     * Sanitiza o ID da tarefa obtido via GET.
     *
     * Valida e converte o ID para um inteiro, removendo caracteres inválidos.
     *
     * @param string $id ID da tarefa a ser sanitizado.
     * @return int ID sanitizado como inteiro, ou 0 se inválido.
     * @author Arthur Vieira <aprendizadoarthur@gmail.com>
     */
    public function SanitizeTaskIDFromGET(string $id) : int
    {
        $SanitizedTaskIDFromGet = filter_var($id, FILTER_VALIDATE_INT);
        if (!$SanitizedTaskIDFromGet) {
            return 0;
        }
        $id = str_replace('#', '', $id);
        return (int)$id;
    }
}