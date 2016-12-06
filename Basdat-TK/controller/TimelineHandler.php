<?php

  class TimelineHandler
  {
      public static function getAllTimeline($db)
      {
          $query = 'SELECT Extract(year from tanggal) as "year", Extract(month from tanggal) as "month", Extract(day from tanggal) as "day", namaEvent as "title" FROM SISIDANG.TIMELINE';
          $timelineList = pg_query($db, $query);
          return $timelineList;
      }

  }
