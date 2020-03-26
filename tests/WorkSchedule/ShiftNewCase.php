<?php


class ShiftNewCase extends \PHPUnit\Framework\TestCase
{
    public function testGeTPeriod()
    {
        $shiftSchedule = new WorkSchedule\ShiftSchedule(2, 2, '2019-12-12');

        $this->assertFalse($shiftSchedule->isWorkDay('2019-12-6'));
        $this->assertFalse($shiftSchedule->isWorkDay('2019-12-7'));
        $this->assertTrue($shiftSchedule->isWorkDay('2019-12-8'));
        $this->assertTrue($shiftSchedule->isWorkDay('2019-12-9'));
        $this->assertFalse($shiftSchedule->isWorkDay('2019-12-10'));
        $this->assertFalse($shiftSchedule->isWorkDay('2019-12-11'));

        $this->assertTrue($shiftSchedule->isWorkDay('2019-12-12'));
        $this->assertTrue($shiftSchedule->isWorkDay('2019-12-13'));
        $this->assertFalse($shiftSchedule->isWorkDay('2019-12-14'));
        $this->assertFalse($shiftSchedule->isWorkDay('2019-12-15'));

        $this->assertTrue($shiftSchedule->isWorkDay('2019-12-16'));
        $this->assertTrue($shiftSchedule->isWorkDay('2019-12-17'));
        $this->assertFalse($shiftSchedule->isWorkDay('2019-12-18'));
        $this->assertFalse($shiftSchedule->isWorkDay('2019-12-19'));



        $shiftSchedule = new WorkSchedule\ShiftSchedule(3, 3, '2020-03-25');

        $this->assertFalse($shiftSchedule->isWorkDay('2020-03-17'));
        $this->assertFalse($shiftSchedule->isWorkDay('2020-03-18'));
        $this->assertTrue($shiftSchedule->isWorkDay('2020-03-19'));
        $this->assertTrue($shiftSchedule->isWorkDay('2020-03-20'));
        $this->assertTrue($shiftSchedule->isWorkDay('2020-03-21'));
        $this->assertFalse($shiftSchedule->isWorkDay('2020-03-22'));

        $this->assertFalse($shiftSchedule->isWorkDay('2020-03-23'));
        $this->assertFalse($shiftSchedule->isWorkDay('2020-03-24'));
        $this->assertTrue($shiftSchedule->isWorkDay('2020-03-25'));
        $this->assertTrue($shiftSchedule->isWorkDay('2020-03-26'));


    }


    public function testHolidays()
    {
        $shiftSchedule = new WorkSchedule\ShiftSchedule(3, 3, '2020-03-25');

        $shiftSchedule->setWeekend(WorkSchedule\ShiftSchedule::SUNDAY, true);


        $shiftSchedule->setHoliday('2020-03-24', true);



        $this->assertTrue($shiftSchedule->isWorkDay('2020-03-17'));
        $this->assertTrue($shiftSchedule->isWorkDay('2020-03-18'));
        $this->assertTrue($shiftSchedule->isWorkDay('2020-03-19'));
        $this->assertFalse($shiftSchedule->isWorkDay('2020-03-20'));
        $this->assertFalse($shiftSchedule->isWorkDay('2020-03-21'));
        $this->assertFalse($shiftSchedule->isWorkDay('2020-03-22'));

        $this->assertFalse($shiftSchedule->isWorkDay('2020-03-23'));
        $this->assertFalse($shiftSchedule->isWorkDay('2020-03-24'));
        $this->assertTrue($shiftSchedule->isWorkDay('2020-03-25'));
        $this->assertTrue($shiftSchedule->isWorkDay('2020-03-26'));
    }
}
