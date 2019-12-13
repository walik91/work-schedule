<?php

namespace WorkSchedule;

class ShiftSchedule
{
    private $work_days_count;
    private $holiday_days_count;
    private $start_work_date;

    public function __construct($work_days_count, $holiday_days_count, $start_work_date)
    {
        $this->setWorkDaysCount($work_days_count);
        $this->setHolidayDaysCount($holiday_days_count);
        $this->setStartWorkDate($start_work_date);
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

        $dayInWeek = $this->getDayNumInWeek($date);

        return $dayInWeek / $this->work_days_count <= 1;
    }

    public function isHoliday($date)
    {
        return !$this->isWorkDay($date);
    }

    public function getDaysPeriod($from, $to)
    {
        $from = $this->getCarbonDate($from);
        $to = $this->getCarbonDate($to);

        $period = new \Carbon\CarbonPeriod();
        $period->setStartDate($from);
        $period->setEndDate($to);

        $days = [];
        foreach($period as $date) {
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