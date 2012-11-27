{table_open}<table border="1" cellpadding="0" cellspacing="0">{/table_open}
{heading_row_start}<tr>{/heading_row_start}
{heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/
heading_previous_cell}
{heading_title_cell}<td colspan="{colspan}" style="text-align:center; font-weight:bold">{heading}</td>{/
heading_title_cell}
{heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/
heading_next_cell}
{heading_row_end}</tr>{/heading_row_end}
{week_row_start}<tr>{/week_row_start}
{week_day_cell}<td>{week_day}</td>{/week_day_cell}
{week_row_end}</tr>{/week_row_end}
89
{cal_row_start}<tr>{/cal_row_start}
{cal_cell_start}<td>{/cal_cell_start}
{cal_cell_content}{day}<BR />{content}{/cal_cell_content}
{cal_cell_content_today}<div class="highlight"><a href="{content}">{day}</
a></div>{/cal_cell_content_today}
{cal_cell_no_content}{day}{/cal_cell_no_content}
{cal_cell_no_content_today}<div class="highlight">{day}</div>{/
cal_cell_no_content_today}
{cal_cell_blank}&nbsp;{/cal_cell_blank}
{cal_cell_end}</td>{/cal_cell_end}
{cal_row_end}</tr>{/cal_row_end}
{table_close}</table>{/table_close}