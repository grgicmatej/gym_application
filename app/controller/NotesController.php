<?php

class NotesController extends SecurityController
{
    public function allStaffNotes()
    {
        echo json_encode(Notes::allStaffNotes());
    }
}