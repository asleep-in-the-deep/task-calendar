<?php

namespace Views;

class DaysGrid {
	public function __construct($month = '', $year = '') {
		//TODO: validation of $month and $year
		if ($month != '') {
			$this->dateMonth = $month;
		} else {
			$this->dateMonth = date('m');
		}

		if ($year != '') {
			$this->dateYear = $year;
		} else {
			$this->dateYear = date('Y');
		}

		$firstMonthDay = '01-'.$this->dateMonth.'-'.$this->dateYear;

		$this->currentFirstWeekDay = date('N', strtotime($firstMonthDay));

		$this->totalDaysOfMonth = cal_days_in_month(CAL_GREGORIAN, $this->dateMonth, $this->dateYear);

		if ($this->currentFirstWeekDay == 1) {
			$numberOfWeeks = $this->totalDaysOfMonth / 7;
		} else {
			$numberOfWeeks = ($this->totalDaysOfMonth + $this->currentFirstWeekDay) / 7;
		}

		if ($numberOfWeeks > 5 && $numberOfWeeks < 5.2) {
			$this->dayBoxes = round($numberOfWeeks) * 7;
		} else {
			$this->dayBoxes = ceil($numberOfWeeks) * 7;
		}
		
	}

	public function render() {
		require("views/calendar.php");
	}

	public function makeGrid() {
		$dayCount = 1;
		for ($i=1; $i <= $this->dayBoxes; $i++) {
			if ($i >= $this->currentFirstWeekDay && $dayCount <= $this->totalDaysOfMonth) {
				$currentDate = $this->dateYear.'-'.$this->dateMonth.'-'.$dayCount;
				$currentDay = date('j', strtotime($currentDate));
				$disabled = ($i % 7 == 0 || ($i % 7 - 6) == 0 || isHoliday($currentDate));
				require 'views/day.php';
				$dayCount++;
			} else {
				require 'views/day_disabled.php';
			}
		}
	}
}
