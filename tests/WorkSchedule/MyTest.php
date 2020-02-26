<?php

class MyTest extends \PHPUnit\Framework\TestCase
{
    public function testGetTest()
    {
        $shiftSchedule = new WorkSchedule\ShiftSchedule(2, 1, '2020-02-01');

        $shiftSchedule->setWeekend(WorkSchedule\ShiftSchedule::SUNDAY, true);

        $this->assertTrue($shiftSchedule->isWorkDay('2020-02-01'));
        $this->assertFalse($shiftSchedule->isWorkDay('2020-02-02'));
        $this->assertTrue($shiftSchedule->isWorkDay('2020-02-03'));
        $this->assertFalse($shiftSchedule->isWorkDay('2020-02-04'));
        $this->assertTrue($shiftSchedule->isWorkDay('2020-02-05'));
        $this->assertTrue($shiftSchedule->isWorkDay('2020-02-06'));
        $this->assertFalse($shiftSchedule->isWorkDay('2020-02-07'));
        $this->assertTrue($shiftSchedule->isWorkDay('2020-02-08'));
        $this->assertFalse($shiftSchedule->isWorkDay('2020-02-09'));
        $this->assertTrue($shiftSchedule->isWorkDay('2020-02-10'));
        $this->assertFalse($shiftSchedule->isWorkDay('2020-02-11'));

    }

    public function testHolidays()
    {
        $schedule = new WorkSchedule\ShiftSchedule(2,1, '2020-02-01');

        $schedule->setWeekend(WorkSchedule\ShiftSchedule::SUNDAY, true);

        $schedule->setHoliday('2020-02-03', true);
        $schedule->setHoliday('2020-02-11', true);

        $this->assertTrue($schedule->isWorkDay('2020-02-01'));
        $this->assertFalse($schedule->isWorkDay('2020-02-02'));
        $this->assertFalse($schedule->isWorkDay('2020-02-03'));
        $this->assertTrue($schedule->isWorkDay('2020-02-04'));
        $this->assertFalse($schedule->isWorkDay('2020-02-05'));
        $this->assertTrue($schedule->isWorkDay('2020-02-06'));
        $this->assertTrue($schedule->isWorkDay('2020-02-07'));
        $this->assertFalse($schedule->isWorkDay('2020-02-08'));
        $this->assertFalse($schedule->isWorkDay('2020-02-09'));
        $this->assertTrue($schedule->isWorkDay('2020-02-10'));
        $this->assertFalse($schedule->isWorkDay('2020-02-11'));
        $this->assertTrue($schedule->isWorkDay('2020-02-12'));
        $this->assertFalse($schedule->isWorkDay('2020-02-13'));
    }

    public function testWeekends()
    {
        $scheduleWithWeekend = new WorkSchedule\ShiftSchedule(2,1,'2020-01-31');

        $scheduleWithWeekend->setWeekend(WorkSchedule\ShiftSchedule::SUNDAY, true);
        $scheduleWithWeekend->setWeekend(WorkSchedule\ShiftSchedule::SATURDAY, true);

        $this->assertTrue($scheduleWithWeekend->isWorkDay('2020-01-31'));
        $this->assertFalse($scheduleWithWeekend->isWorkDay('2020-02-01'));
        $this->assertFalse($scheduleWithWeekend->isWorkDay('2020-02-02'));
        $this->assertTrue($scheduleWithWeekend->isWorkDay('2020-02-03'));
        $this->assertFalse($scheduleWithWeekend->isWorkDay('2020-02-04'));
        $this->assertTrue($scheduleWithWeekend->isWorkDay('2020-02-05'));
        $this->assertTrue($scheduleWithWeekend->isWorkDay('2020-02-06'));
        $this->assertFalse($scheduleWithWeekend->isWorkDay('2020-02-07'));
        $this->assertFalse($scheduleWithWeekend->isWorkDay('2020-02-08'));
        $this->assertFalse($scheduleWithWeekend->isWorkDay('2020-02-09'));
        $this->assertTrue($scheduleWithWeekend->isWorkDay('2020-02-10'));
    }
}