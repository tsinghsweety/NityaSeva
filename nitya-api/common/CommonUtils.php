<?php
class CommonUtils {
  public function getMonthDiff($start_date, $current_date){
      $begin = new DateTime( $start_date );
      $end = new DateTime( $current_date );
      $end = $end->modify( '+1 month' );

      $interval = DateInterval::createFromDateString('1 month');

      $period = new DatePeriod($begin, $interval, $end);
      $counter = 0;
      foreach($period as $dt) {
          $counter++;
      }

      return $counter;
  }
}
?>
