<?php

namespace Source\Models;

use Source\Core\Model;

class Pages extends Model
{
    /** @var array $safe no update or create */
    protected static $safe = ["id", "created_at", "updated_at"];

    /** @var string $entity database table */
    protected static $entity = "pages";

    /** @var array $required table fileds */
    protected static $required = ["name", "description", "url", "image"];


    public function bootstrap(
        string $name,
        string $description,
        string $url,
        string $image = null
    ): ?User {
        $this->name = $name;
        $this->description = $description;
        $this->url = $url;
        $this->image = $image;
        return $this;
    }


    public function all(int $limit = 30, int $offset = 0, string $columns = "*"): ?array
    {
        $all = $this->read("SELECT {$columns} FROM " . self::$entity . " LIMIT :limit OFFSET :offset",
            "limit={$limit}&offset={$offset}");

        if ($this->fail() || !$all->rowCount()) {
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function save(): ?Pages
    {
        if (!$this->required()) {
            $this->message->warning("Nome, sobrenome, email e senha são obrigatórios");
            return null;
        }

        /** Page Update */
        if (!empty($this->id)) {
            $userId = $this->id;

            if ($this->find("email = :e AND id != :i", "e={$this->email}&i={$userId}")) {
                $this->message->warning("O e-mail informado já está cadastrado");
                return null;
            }

            $this->update(self::$entity, $this->safe(), "id = :id", "id={$userId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return null;
            }
        }

        /** Page Create */
        if (empty($this->id)) {
            if ($this->findByUrl($this->url)) {
                $this->message->warning("O Url informado já está cadastrado");
                return null;
            }

            $userId = $this->create(self::$entity, $this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return null;
            }
        }

        $this->data = ($this->findById($userId))->data();
        return $this;
    }

    public function destroy(): ?Pages
    {
        if (!empty($this->id)) {
            $this->delete(self::$entity, "id = :id", "id={$this->id}");
        }

        if ($this->fail()) {
            $this->message = "Não foi possível remover a página";
            return null;
        }

        $this->message = "página removida com sucesso";
        $this->data = null;
        return $this;
    }
}