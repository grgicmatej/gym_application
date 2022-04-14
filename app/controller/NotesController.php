<?php

class NotesController extends SecurityController
{
    public function checkStaffNotes()
    {
        $this->employeeCheck();
        echo json_encode(Notes::checkStaffNotes());
    }

    public function newNote()
    {
        $this->employeeCheck();
        Notes::newNote();
    }
}