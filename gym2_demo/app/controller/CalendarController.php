<?php

class CalendarController extends SecurityController
{
    public function checkCalendar()
    {
        
        echo json_encode(Calendar::checkCalendar());
    }

    public function checkCalendarToday()
    {
        
        echo json_encode(Calendar::checkCalendarToday());
    }

    public function checkCalendarDetails()
    {
        
        echo json_encode(Calendar::checkCalendarDetails());
    }

    public function confirmEvent()
    {
        
        Calendar::confirmEvent();
    }

    public function removeEvent()
    {
        
        Calendar::removeEvent();
    }

    public function newEvent()
    {
        
        Calendar::newEvent();
    }

    public function updateEvent($eventId)
    {
        
        Calendar::updateEvent($eventId);
    }
}