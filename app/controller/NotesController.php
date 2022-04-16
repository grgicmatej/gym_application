<?php

class NotesController extends SecurityController
{
    public function checkStaffNotes()
    {
        $this->employeeCheck();
        echo json_encode(Notes::checkStaffNotes());
    }

    public function checkNote()
    {
        $this->employeeCheck();
        echo json_encode(Notes::checkNote());
    }

    public function newNote()
    {
        $this->employeeCheck();
        Notes::newNote();
    }

    public function deleteNote()
    {
        $this->employeeCheck();
        Notes::deleteNote();
    }

    public function editNote($id)
    {
        $this->employeeCheck();
        Notes::editNote($id);
    }
}