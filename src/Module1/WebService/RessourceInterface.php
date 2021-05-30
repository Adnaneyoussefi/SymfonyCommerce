<?php

namespace App\Module1\WebService;

interface RessourceInterface {
    
    public function getList();

    public function get(int $id);

    public function add(object $obj);

    public function update(int $id, object $obj);

    public function delete(int $id);
    
}