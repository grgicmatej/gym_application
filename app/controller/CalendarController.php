<?php

class CalendarController extends SecurityController
{
    public function checkCalendar()
    {
        $this->employeeCheck();
        echo json_encode(Calendar::checkCalendar());
    }

    public function checkCalendarToday()
    {
        $this->employeeCheck();
        echo json_encode(Calendar::checkCalendarToday());
    }

    public function checkCalendarDetails()
    {
        $this->employeeCheck();
        echo json_encode(Calendar::checkCalendarDetails());
    }

    public function confirmEvent()
    {
        $this->employeeCheck();
        Calendar::confirmEvent();
    }

    public function removeEvent()
    {
        $this->employeeCheck();
        Calendar::removeEvent();
    }

    public function newEvent()
    {
        $this->employeeCheck();
        Calendar::newEvent();
    }

    public function updateEvent($eventId)
    {
        $this->employeeCheck();
        Calendar::updateEvent($eventId);
    }
}