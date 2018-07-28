<?
class pgCalcul
{
	private $cur_pg;
	private $x_per_pg;
	private $y_per_pg;
	private $total_rows;

	function __construct($cur_pg, $x_per_pg, $y_per_pg, $total_rows)
	{
		$this->cur_pg = $cur_pg;
		$this->x_per_pg = $x_per_pg;
		$this->y_per_pg = $y_per_pg;
		$this->total_rows = $total_rows;

		if($this->cur_pg < 1)
		{
			$this->cur_pg = 1;
		}
		if($this->cur_pg > $this->get_pg_max() && 1 <= $this->get_pg_max())
		{
			$this->cur_pg = $this->get_pg_max();
		}
	}

	function get_pg_start()
	{
		$cur_end = ceil($this->cur_pg / $this->x_per_pg) * $this->x_per_pg;
		$cur_start = $cur_end - $this->x_per_pg + 1;
		return $cur_start;
	}

	function get_pg_end()
	{
		$cur_end = ceil($this->cur_pg / $this->x_per_pg) * $this->x_per_pg;
		$max_pg = $this->get_pg_max();

		if($cur_end > $max_pg)
		{
			return $max_pg;
		}
		else
		{
			return $cur_end;
		}
	}

	function get_pg_max()
	{
		$max_pg = ceil($this->total_rows / $this->y_per_pg);
		return $max_pg;
	}

	function get_list_start()
	{
		$list_start = ($this->cur_pg - 1) * $this->y_per_pg;
		return $list_start;
	}

	function get_list_end()
	{
		$list_start = ($this->cur_pg - 1) * $this->y_per_pg;
		$list_end = $list_start + $this->y_per_pg - 1;
		return $list_end;
	}

	function get_list_max()
	{
		return $this->total_rows;
	}
}

$inst = new pgCalcul(1, 10, 40, 5555);

echo $inst->get_pg_start()."\n";
echo $inst->get_pg_end()."\n";
echo $inst->get_pg_max()."\n";
echo $inst->get_list_start()."\n";
echo $inst->get_list_end()."\n";
echo $inst->get_list_max()."\n";







//달력 클래스
class calendar_class
{
	private $year;
	private $month;
	private $first_day;
	private $last_date;
	private $week_rows;
	private $prev_month = array();
	private $next_month = array();

	function __construct($y=null, $m=null)
	{
		$this->year = $y == null ? date('Y') : $y;
		$this->month = $m == null ? sprintf("%01d", date('m')) : sprintf("%01d", $m);
		$this->first_day = date('w', strtotime($this->year.'-'.$this->month.'-01'));
		$this->last_date = date('t', strtotime($this->year.'-'.$this->month));
		$this->week_rows = ceil(($this->first_day + $this->last_date) / 7);
		$this->prev_month['year'] = $this->month == 1 ? $this->year - 1 : $this->year;
		$this->prev_month['month'] = $this->month - 1 == 0 ? 12 : $this->month - 1;
		$this->next_month['year'] = $this->month == 12 ? $this->year + 1 : $this->year;
		$this->next_month['month'] = $this->month == 12 ? 1 : $this->month + 1;
	}

	function get_calendar_arr()
	{
		$calendar_arr = array();
		$date_num = 1-$this->first_day;
		for($i=0; $i < $this->week_rows; $i++)
		{
			for($j=0; $j < 7; $j++)
			{
				$each_year = $this->year;
				$each_month = $this->month;
				$each_date = $date_num;
				$each_this_date = $date_num;
				if($date_num < 1)
				{
					$each_year = $this->prev_month['yeqr'];
					$each_month = $this->prev_month['month'];
					$each_date = $date_num + date('t', $each_year.'-'.$each_month);
					$each_this_date = null;
				}
				
				if($date_num > $this->last_date)
				{
					$each_year = $this->next_month['year'];
					$each_month = $this->next_month['month'];
					$each_date = $date_num - $this->last_date;
					$each_this_date = null;
				}

				$calendar_arr[$i][$j] = array(
					'year'=>$each_year, 
					'month'=>$each_month, 
					'date'=>$each_date, 
					'this_date'=>$each_this_date, 
					'ymd'=>$each_year.'-'.sprintf("%02d", $each_month).'-'.sprintf("%02d", $each_date)
				);

				$date_num++;
			}
		}
		return $calendar_arr;
	}

	function get_year()
	{
		return $this->year;
	}

	function get_month()
	{
		return $this->month;
	}

	function get_week_rows()
	{
		return $this->week_rows;
	}

	function get_prev_month()
	{
		return $this->prev_month;
	}

	function get_next_month()
	{
		return $this->next_month;
	}
}


?>