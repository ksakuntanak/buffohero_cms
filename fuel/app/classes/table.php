<?php
class Table
{
	private static $_instance = null;
	private $_key = null;



	public static function instance()
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new Table();
		}

		return self::$_instance;
	}

	public function render($model,$key=array(),$options=null)
	{


		$identifier = array(
			'table'=>array(
				'class'=>'table table-striped	',
				'id'=>''
			),
			'tr'=>array(
				'id'=>'',
				'class'=>'',
				'role'=>''
			),
			'td'=>array(
				'id'=>'',
				'class'=>'',
				'role'=>''
			),
			'filter'=>array(),
			'actions'=>true,
			'controller'=>'',
            'pagination'=>array(
                'model'=>'',
                'controller'=>'',
                'page'=>'',
                'show'=>false
            )
		);

		if(isset($options['table']))
		{
			$identifier['table'] = $options['table']+$identifier['table'];
		}

		if(isset($options['tr']))
		{
			$identifier['tr'] = $options['tr']+$identifier['tr'];
		}

		if(isset($options['td']))
		{
			$identifier['td'] = $options['td']+$identifier['td'];
		}

		if(isset($options['controller']))
		{
			$identifier['controller'] = $options['controller'];
		}

        if(isset($options['pagination']))
        {
            $identifier['pagination'] = $options['pagination']+$identifier['pagination'];
        }

		$table = '<table class="'.$identifier['table']['class'].'" id="'.$identifier['table']['id'].'">';
		$table .= '<thead><tr>';

		foreach($key as $k=>$v)
		{
			if(strpos($v, '.'))
			{
				$need = explode('.',$v);
				$v = $need[0];		
			}
			$table .= '<th>'.$v.'</th>';
		}

		$table .= '</tr></thead>';
		$x=count($key);

		foreach($model as $k=>$v)
		{	
			$table .= '<tr>';
			for($i=0;$i<$x;$i++)
			{

				$key[$i] = strtolower($key[$i]);

				if(strpos($key[$i], '.'))
				{
					$need = explode('.',$key[$i]);
					$key[$i] = $need[0];	
				}

				if(isset($v->$key[$i]))	
				{
					if(is_object($v->$key[$i]))
					{
						$table .= '<td>'.$v->$key[$i]->$need[1].'</td>';
					}else{
						$table .= '<td>'.$v->$key[$i].'</td>';
					}
				}elseif($key[$i]=='#'){
					$table .= '<td>'.$v->id.'</td>';
				}else{
					$table .= '<td></td>';
				}
			}

			if($identifier['actions']==true){
				$table .= '<td>';
				$table .= '<a href="'.Uri::base().'backend/'.$identifier['controller'].'/view/'.$v->id.'" class="btn btn-small btn-primary"> View</a>';
				$table .= '<a href="'.Uri::base().'backend/'.$identifier['controller'].'/edit/'.$v->id.'" class="btn btn-small btn-warning">Edit</a>';
                $table .= '</td>';
			}

			$table .='</tr>';
			
		}

		$table .= '</table>';

        if($identifier['pagination']['show']==true)
        {
            $table .= $this->pagination($model,$identifier['pagination']);
        }

		return $table;
	}

	private function pagination($model,$options)
	{
		$config = array(
		    'pagination_url' => Uri::base().$options['controller'].'/'.$options['page'],
		    'total_items'    => count($model),
		    'per_page'       => isset($options['per_page'])?$options['per_page']:'',
		    'uri_segment'    => 'page',
            'wrapper'        => '<div class="clearfix"><div class="pagination no-margin">{pagination}</div></div>',
            'first'          => '<li class="first">{link}</li>',
            'fist-marker'    => 'First',
            'first-link'     => '<a href="{uri}">{page}</a>',
            'previous'       => '<li class="previous">{link}</li>',
            'previous-marker'=> 'Previous',
            'previous-link'  => '<a href="{uri}">{page}</a>',
            'previous-inactive'=>'<li class="previous-inactive">{link}</li>',
            'previous-inactive-link'=>'<a href="{uri}" rel="prev">{page}</a>',
            'regular'        => '<li>{link}</li>',
            'regular-link'   => '<a href="{uri}">{page}</a>',
            'active'         => '<li class="active">{link}</li>',
            'active-link'    => '<a href="{uri}">{page}</a>',
            'next'           => '<li class="next">{link}</li>',
            'next-marker'    => 'Next',
            'next-link'      => '<a href="{uri}" rel="next">{page}</a>',
            'next-inactive'  => '<li class="next-inactive">{link}</li>',
            'next-inactive-link' => '<a href="{uri}" rel="next">{page}</a>',
            'last'           => '<li class="last">{link}</li>',
            'last-marker'    => 'Last',
            'last-link'      => '<a href="{uri}">{page}</a>',
		);

        $pagination = Pagination::forge('table', $config);

        $data = $options['model']::query()
            ->rows_offset($pagination->per_page)
            ->rows_limit($pagination->offset)
            ->get();

        return $pagination->render();


	}
}