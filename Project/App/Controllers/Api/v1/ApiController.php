<?php

namespace App\Controllers\Api\v1;

use App\Controllers\User\UserController;

class ApiController extends UserController
{
    public function show(array $args): string
    {
        $user = $this->user::getById($args['id']);
        if ($user) {
            return $this->response->sendApi(null, $user);
        }

        return $this->response->sendError(400, $args['id']);
    }

    public function showAll(): string
    {
        $users = $this->user->getAll();
        if ($users) {
            return $this->response->sendApi($users);
        }

        return $this->response->dbIsEmpty();
    }

    public function store(): string
    {
        $post_vars = json_decode(file_get_contents('php://input'), true);
        $post_vars['id'] = time();

        $this->apiValidator->validate($post_vars) ?
            $status = $this->user->insert($post_vars) :

            $status = false;
        if ($status) {
            $this->response->statusCode(201);

            return $this->response->sendApi($post_vars['id']);
        }

        return $this->response->sendNotValid($post_vars['id'], $this->apiValidator->getErrors());
    }

    public function delete(array $args): string
    {
        $status = $this->user->delete((int)$args['id']);
        if ($status) {
            return $this->response->sendApi((int)$args['id']);
        }

        return $this->response->sendError(400, $args['id']);
    }

    public function update(array $args = []): string
    {
        $put_vars = json_decode(file_get_contents('php://input'), true);
        $put_vars['id'] = $args['id'];
        if ($this->user::getById($args['id'])) {
            $this->apiValidator->validate($put_vars) ?
                $status = $this->user->update($put_vars) :
                $status = false;
            if ($status) {
                return $this->response->sendApi($put_vars['id']);
            }

            return $this->response->sendNotValid($put_vars['id'], $this->apiValidator->getErrors());
        } else {
            return $this->response->sendError(400, $args['id']);
        }
    }
}
