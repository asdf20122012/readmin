<?php

class Paginator
{
    /**
     * Выводит пагинатор
     *
     * @param int       $total
     * @param int       $current
     * @param string    $url
     * @param int       $limit
     * @return string
     */
    public static function parsePaginator( $total, $current, $url, $limit = 10 )
    {
        $total      = abs( (int)$total );
        $current    = abs( (int)$current );
        $limit      = abs( (int)$limit );

        $total = ceil($total / $limit);

        if ($total <= 1)
        {
            return '';
        }

        if ($current > $total)
        {
            $current = $total;
        }

        $start = 1;

        if ($current == 1)
        {
            $start  = 1;
        }
        elseif($current)
        {
            // 1 2 3 4 '5 6 7 8 9 10
            if ($current - ceil($limit / 2) <= 1)
            {
                $start = 1;
            }
            elseif ($current + ceil($limit / 2) > $total)
            {
                if ( ($total - $limit) > 1) {
                    $start = $total - $limit;
                } else {
                    $start = 1;
                }
            }
            else
            {
                $start = $current - ceil($limit / 2);
            }
        }

        $end    = (($start + $limit) < $total) ? ($start + $limit) : $total;

        $pages = array();
        for($i = $start; $i <= $end; $i++)
        {
            $pages[] = array(
                'url'       => str_replace(':id:', $i, $url),
                'active'    => (($i == $current) ? '+': NULL),
                'number'    => $i,
            );
        }

        $prevURL = $nextURL = '';

        if ($current > 1)
        {
            $prevURL = str_replace(':id:', ($current - 1), $url);
        }

        if($current < $total)
        {
            $nextURL = str_replace(':id:', ($current+1), $url);
        }

        $data = array(
            'pages'     => $pages,
            'total'     => $total,
            'totalURL'  => str_replace(':id:', $total, $url),
            'prevURL'   => $prevURL,
            'nextURL'   => $nextURL,
        );

        return View::factory('paginator', $data);
    }

    /**
     * Extended output list with a manual indicating the number of items per page
     *
     * @param int $total    Total items
     * @param int $current  Current page
     * @param int $url      Template url
     * @param int $limit    Limit pages
     * @return string
     */
    public static function parseExtended( $total, $current, $url, $limit = 10 )
    {
        $total      = abs( (int)$total );
        $current    = abs( (int)$current );
        $limit      = abs( (int)$limit );

        $total = ceil($total / $limit);

        if ($total <= 1)
        {
            return '';
        }

        if ($current > $total)
        {
            $current = $total;
        }

        $start = 1;

        if ($current == 1)
        {
            $start  = 1;
        }
        elseif($current)
        {
            // 1 2 3 4 '5 6 7 8 9 10
            if ($current - ceil($limit / 2) <= 1)
            {
                $start = 1;
            }
            elseif ($current + ceil($limit / 2) > $total)
            {
                if ( ($total - $limit) > 1) {
                    $start = $total - $limit;
                } else {
                    $start = 1;
                }
            }
            else
            {
                $start = $current - ceil($limit / 2);
            }
        }

        $end    = (($start + $limit) < $total) ? ($start + $limit) : $total;

        $pages = array();
        for($i = $start; $i <= $end; $i++)
        {
            $l      = $i * Config::get('re_limit');
            $url1    = str_replace(':page:',    $i, $url);
            $url1    = str_replace(':start:',   $l - Config::get('re_limit'), $url1);
            $url1    = str_replace(':end:',     $l, $url1);

            $pages[$i] = array(
                'url'       => $url1,
                'active'    => (($i == $current) ? '+': NULL),
                'number'    => $i,
            );
        }

        $prevURL = $nextURL = '';

        if ( isset( $pages[ $current - 1 ] ) )
        {
            $prevURL = $pages[ $current - 1 ]['url'];
        }

        if( isset( $pages[ $current + 1 ] ) )
        {
            $nextURL = $pages[ $current + 1 ]['url'];
        }

        $data = array(
            'pages'     => $pages,
            'total'     => $total,
            'totalURL'  => str_replace(':id:', $total, $url),
            'prevURL'   => $prevURL,
            'nextURL'   => $nextURL,
        );

        return View::factory('paginator', $data);
    }
}
