<?php
namespace Cumts\MainBundle\Service;

class DateFormatter
{

    public function createRangeFromDates(array $dates)
    {
        // Create an array of start times, containing date ranges
        $times = array();
        //First, sort by time
        foreach ($dates as $date) {
            $time = $date->format('g:i a');
            if (!isset($times[$time])) {
                $times[$time] = array($date);
            }
            else {
                $times[$time][] = $date;
            }
        }
        //Next, create date ranges
        $time_ranges = array();
        foreach ($times as $time => $dates) {
            sort($dates);
            $start = null;
            $end = null;
            $ranges = array();
            foreach ($dates as $date) {               
                if ($end === NULL) {
                    $start = $date;
                    $end = $date;
                }
                elseif ($date != $end) {
                    $tomorrow = clone $end;
                    $tomorrow->modify('+1 day');
                    if ($date == $tomorrow) {
                        $end = $date;
                    }
                    else {
                        $ranges[] = array('start' => clone $start, 'end' => clone $end);
                        $start = $date;
                        $end = $date;
                    }
                }
            }
            $ranges[] = array('start' => $start, 'end' => $end);
            $time_ranges[$time] = $ranges;
        }

        //Finally, produce strings
        $time_strs = array();
        foreach ($time_ranges as $time => $ranges) {
            $range_strs = array();
            foreach ($ranges as $range) {
                if ($range['start'] == $range['end']) {
                    $range_str = $range['start']->format('l j');
                }
                else {
                    $range_str = $this->dateRange($range['start'], $range['end']);
                }
                $range_strs[] = $range_str;
            }
            $time_strs[] = implode(', ', $range_strs).' at '.$time;
        }
        return implode('; ', $time_strs);
    }
    
    public function dateRange(\DateTime $start, \DateTime $end)
    {
        if ($start->format('Y') == $end->format('Y')) {
            if ($start->format('n') == $end->format('n')) {
                if ($start->format('j') == $end->format('j')) {
                    return $start->format('l j F Y');
                }
                else {
                    return $start->format('l j').' to '.$end->format('l j F Y');
                }
            }
            else {
                return $start->format('l j F').' to '.$end->format('l j F Y');
            }
        }
        else {
            return $start->format('l j F Y').' to '.$end->format('l j F Y');
        }
    }

}
