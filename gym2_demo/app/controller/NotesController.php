<?php

class NotesController extends SecurityController
{
    public function checkStaffNotes()
    {
        
        echo json_encode(Notes::checkStaffNotes());
    }

    public function checkNote()
    {
        
        echo json_encode(Notes::checkNote());
    }

    public function newNote()
    {
        
        Notes::newNote();
    }

    public function deleteNote()
    {
        
        Notes::deleteNote();
    }

    public function editNote($id)
    {
        
        Notes::editNote($id);
    }
}