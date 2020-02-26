<?php

namespace WorkSchedule;

class ShiftSchedule
{
    private $work_days_count;
    private $holiday_days_count;
    private $start_work_date;

    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;
    const SUNDAY = 0;

    private $weekends = [
        self::MONDAY => false,
        self::TUESDAY => false,
        self::WEDNESDAY => false,
        self::THURSDAY => false,
        self::FRIDAY => false,
        self::SATURDAY => false,
        self::SUNDAY => false,
    ];

    private $holidays = [


    ];

    public function __construct($work_days_count, $holiday_days_count, $start_work_date)
    {
        $this->setWorkDaysCount($work_days_count);
        $this->setHolidayDaysCount($holiday_days_count);
        $this->setStartWorkDate($start_work_date);
    }

    public function setWeekend($week_day, $flag)
    {
        if (!isset($this->weekends[$week_day])) {

        }

        $this->weekends[$week_day] = $flag;
    }

    public function setHoliday($date, $flag)
    {
        $this->holidays[$date] = $flag;
    }

    public function hasHoliday($week_day)
    {
        return isset($this->holidays[$week_day]) && $this->holidays[$week_day];
    }

    public function hasWeekend($week_day)
    {
        return isset($this->weekends[$week_day]) && $this->weekends[$week_day];
    }

    public function getCarbonDate($date)
    {
        if ($date instanceof \Carbon\Carbon) {
            return $date;
        }

        return \Carbon\Carbon::createFromFormat('Y-m-d', $date);
    }

    public function countWeekDays()
    {
        return $this->work_days_count + $this->holiday_days_count;
    }

    public function getDayNumInWeek($date)
    {
        $date = $this->getCarbonDate($date);

        $days_count = $date->diffInDays($this->start_work_date) + 1;

        $dayNum = $days_count % $this->countWeekDays();

        if ($dayNum < 1) {
            $dayNum = $this->countWeekDays();
        }

        return $dayNum;
    }

    public function isWorkDay($date)
    {
        $date = $this->getCarbonDate($date);

        if ($this->hasWeekend($date->dayOfWeek)) {
            return false;
        }

        if ($this->hasHoliday($date->format('Y-m-d'))) {
            return false;
        }




        $period = new \Carbon\CarbonPeriod();
        $period->setStartDate($this->getStartWorkDate());
        $period->setEndDate($date);

        $this->getHolidayDaysCount();

        $left_work_days = $this->getWorkDaysCount();
        $left_holidays  = 0;

        $is_workday = true;

        foreach ($period as $day) {
            if ($this->hasWeekend($day->dayOfWeek) || $this->hasHoliday($day->format('Y-m-d'))) {
                continue;
            }

            if ($left_work_days > 0) {
                $left_work_days--;

                if ($left_work_days <= 0) {
                    $left_holidays = $this->getHolidayDaysCount();
                }

                $is_workday = true;
            } elseif ($left_holidays > 0) {
                $left_holidays--;

                if ($left_holidays <= 0) {
                    $left_work_days = $this->getWorkDaysCount();
                }

                $is_workday = false;
            }
        }

        return $is_workday;

        /*$dayInWeek = $this->getDayNumInWeek($date);

        return $dayInWeek / $this->work_days_count <= 1;*/
    }

    public function isHoliday($date)
    {
        return !$this->isWorkDay($date);
    }

    public function getDaysPeriod($from, $to)
    {
        $from = $this->getCarbonDate($from);
        $to   = $this->getCarbonDate($to);

        $period = new \Carbon\CarbonPeriod();
        $period->setStartDate($from);
        $period->setEndDate($to);

        $days = [];
        foreach ($period as $date) {
            $is_work = $this->isWorkDay($date);

            $days[] = [
                'date' => $date->format('Y-m-d'),
                'is_work' => $is_work,
                'is_holiday' => !$is_work
            ];
        }

        return $days;
    }

    /**
     * @return mixed
     */
    public function getWorkDaysCount()
    {
        return $this->work_days_count;
    }

    /**
     * @param mixed $work_days_count
     */
    public function setWorkDaysCount($work_days_count)
    {
        $this->work_days_count = $work_days_count;
    }

    /**
     * @return mixed
     */
    public function getHolidayDaysCount()
    {
        return $this->holiday_days_count;
    }

    /**
     * @param mixed $holiday_days_count
     */
    public function setHolidayDaysCount($holiday_days_count)
    {
        $this->holiday_days_count = $holiday_days_count;
    }

    /**
     * @return mixed
     */
    public function getStartWorkDate()
    {
        return $this->start_work_date->format('Y-m-d');
    }

    /**
     * @param mixed $start_work_date
     */
    public function setStartWorkDate($start_work_date)
    {
        $this->start_work_date = $this->getCarbonDate($start_work_date);
    }
}