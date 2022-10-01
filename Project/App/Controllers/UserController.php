<?php
namespace App\Controllers;

class UserController extends BaseController
{
    public function addForm(): void
    {
        $this->view->renderHtml('User/Add.php');
    }

    public function add(): void
    {
        $_POST['id'] = time();
        $status = $this->user->add($_POST);
        $msg = $status ? 'User ' . $status['id'] . ' was added' : 'There was an error adding a user';
        $this->viewAll(['status' => $msg, 'userData' => $status]);
    }

    public function delete(string $id): void
    {
        $status =  $this->user->delete($id);
        $msg = $status ? 'User ' . $id . ' was deleted' : 'There was an error deleting a user';
        $this->viewAll(['status' => $msg, 'userData' => $status]);

    }

    public function editForm(string $id): void
    {
        $this->view->renderHtml('User/Edit.php', $this->getUserInfo($id));
    }

    public function edit(): void
    {
        $status= $this->user->edit($_POST);
        $msg = $status ? 'User ' . $status['id'] . ' was updated' : 'There was an error updating a user';
        $this->viewAll(['status' => $msg, 'userData' => $status]);
    }

    public function getUserInfo(string $id): array
    {
        return $this->user->getUserInfo($id);
    }

    public function viewAll(array $args = []): void
    {
        $users = $this->user->getAll();
        $this->view->renderHtml('User/ViewAll.php', ['users' => $users, 'args' => $args]);
    }

}