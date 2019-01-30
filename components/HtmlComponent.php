<?php

class HtmlComponent
{

    /**
     * $page - текущая страница
     * $total - общее число элементов
     * $limit - число элементов на странице
     * $link_params - параметры для формирования ссылок 
     * $othersParams - настройки визуализации
     */
    public static function pagination($page, $total, $limit, $link_params, $othersParams = [])
    {
        $num_pages = ceil($total / $limit); 
        if($num_pages < 2) { 
            return '';
        }

        $defaultParams = [
            'text_first' => '&lt;&lt;',
            'text_last' => '&gt;&gt;',
            'text_next' => '&gt;',
            'text_prev' => '&lt;',
            'num_links' => 8,   //максимальное число отображаемых страниц
            'cssLink' => '',
            'cssArrowLink' => '',
            'cssActive' => 'active',
            'cssBlock' => 'pagination',
        ];

        $params = array_merge($defaultParams, $othersParams);

        $output = '<ul class="'.$params['cssBlock'].'">';

        if ($page > 1) {
            if($params['text_first']) {             
                $output .= '<li><a class="'.$params['cssArrowLink'].'" href="' .  ControllerComponent::link($link_params, ['page' => 1]) . '">' . $params['text_first'] . '</a></li>';
            }            			
            
            if($params['text_prev']) {                
                $output .= '<li><a class="'.$params['cssArrowLink'].'" href="' . ControllerComponent::link($link_params, ['page' => $page - 1]) . '">' . $params['text_prev'] . '</a></li>';
            }			
		}

        if ($num_pages <= $params['num_links']) {
            $start = 1;
            $end = $num_pages;
        } else {
            $start = $page - floor($params['num_links'] / 2);
            $end = $page + floor($params['num_links'] / 2);

            if ($start < 1) {
                $end += abs($start) + 1;
                $start = 1;
            }

            if ($end > $num_pages) {
                $start -= ($end - $num_pages);
                $end = $num_pages;
            }
        }

        for ($i = $start; $i <= $end; $i++) {
            if ($page == $i) {
                $output .= '<li><span class="'.$params['cssActive'].'">' . $i . '</span></li>';
            } else {
                $output .= '<li><a class="'.$params['cssLink'].'" href="' . ControllerComponent::link($link_params, ['page' => $i]) . '">' . $i . '</a></li>';                
            }
        }

        if ($page < $num_pages) {
            if($params['text_next']) {
                $output .= '<li><a class="'.$params['cssArrowLink'].'" href="' . ControllerComponent::link($link_params, ['page' => $page + 1]) . '">' . $params['text_next'] . '</a></li>';
            }
            
            if($params['text_last']) {         
                $output .= '<li><a class="'.$params['cssArrowLink'].'" href="' . ControllerComponent::link($link_params, ['page' => $num_pages]) . '">' . $params['text_last'] . '</a></li>';
            }
		}

        $output .= '</ul>';

        return $output;

    }


    public static function priceFormat($num)
    {
        $dec = (($num > (int)$num) ? 2 : 0);
        return number_format($num, $dec, ',', ' ');
    }

}