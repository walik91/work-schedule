<?php

class ShiftScheduleTest extends \PHPUnit\Framework\TestCase
{
    public function testGetTest()
    {
        $shiftSchedule = new WorkSchedule\ShiftSchedule(2, 2, '2019-12-12');

        $this->assertTrue($shiftSchedule->isWorkDay('2019-12-12'));
        $this->assertTrue($shiftSchedule->isWorkDay('2019-12-13'));
        $this->assertFalse($shiftSchedule->isWorkDay('2019-12-14'));
        $this->assertFalse($shiftSchedule->isWorkDay('2019-12-15'));

        $this->assertTrue($shiftSchedule->isWorkDay('2019-12-16'));
        $this->assertTrue($shiftSchedule->isWorkDay('2019-12-17'));
        $this->assertFalse($shiftSchedule->isWorkDay('2019-12-18'));
        $this->assertFalse($shiftSchedule->isWorkDay('2019-12-19'));

        $shiftSchedule = new WorkSchedule\ShiftSchedule(3, 2, '2019-12-12');

        $this->assertTrue($shiftSchedule->isWorkDay('2020-03-01'));
        $this->assertTrue($shiftSchedule->isWorkDay('2020-03-02'));
        $this->assertTrue($shiftSchedule->isWorkDay('2020-03-03'));
        $this->assertTrue($shiftSchedule->isHoliday('2020-03-04'));
        $this->assertTrue($shiftSchedule->isHoliday('2020-03-05'));
        $this->assertTrue($shiftSchedule->isWorkDay('2020-03-06'));

        $this->assertTrue($shiftSchedule->isWorkDay('2020-08-08'));
        $this->assertTrue($shiftSchedule->isWorkDay('2020-08-09'));
        $this->assertTrue($shiftSchedule->isWorkDay('2020-08-10'));
        $this->assertTrue($shiftSchedule->isHoliday('2020-08-11'));
        $this->assertTrue($shiftSchedule->isHoliday('2020-08-12'));
        $this->assertTrue($shiftSchedule->isWorkDay('2020-08-13'));

        $shiftSchedule = new WorkSchedule\ShiftSchedule(3, 3, '2019-12-12');

        $this->assertTrue($shiftSchedule->isWorkDay('2020-04-04'));
        $this->assertTrue($shiftSchedule->isWorkDay('2020-04-05'));
        $this->assertTrue($shiftSchedule->isWorkDay('2020-04-06'));
        $this->assertTrue($shiftSchedule->isHoliday('2020-04-07'));
        $this->assertTrue($shiftSchedule->isHoliday('2020-04-08'));
        $this->assertTrue($shiftSchedule->isHoliday('2020-04-09'));
        $this->assertTrue($shiftSchedule->isWorkDay('2020-04-10'));
    }

    public function testGetDaysPeriod()
    {
        $shiftSchedule = new WorkSchedule\ShiftSchedule(3, 3, '2019-12-12');
        $days = $shiftSchedule->getDaysPeriod('2019-12-12', '2019-12-18');

        $this->assertContains([
            'date' => '2019-12-12',
            'is_work' => true,
            'is_holiday' => false
        ], $days);

        $this->assertContains([
            'date' => '2019-12-14',
            'is_work' => true,
            'is_holiday' => false
        ], $days);

        $this->assertContains([
            'date' => '2019-12-15',
            'is_work' => false,
            'is_holiday' => true
        ], $days);
    }
}