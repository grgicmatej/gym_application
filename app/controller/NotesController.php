<?php

class NotesController extends SecurityController
{
    public function checkStaffNotes()
    {
        echo json_encode(Notes::checkStaffNotes());
    }
}