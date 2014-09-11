<?php

class Menu
{

	private static $_instance = null;

	public static function instance()
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new Menu();
		}

		return self::$_instance;
	}

	public function sidebar($options = array())
	{
		$identifier = array(
			'nav'=>array(
				'id'=>'sidebar',
				'class'=>'sidebar nav-collapse collapse'
			),
			'ul'=>array(
				'id'=>'side-nav',
				'class'=>'side-nav'
			),
			'li'=>array(
				'id'=>'',
				'class'=>'',
				'role'=>''
			)
		);

		if(isset($options['nav']))
		{
			$identifier['nav'] = $options['nav'];
		}

		if(isset($options['ul']))
		{
			$identifier['ul'] = $options['ul'];
		}

		if(isset($options['li']))
		{
			$identifier['li'] = $options['li'];
		}


		$ul = ' <nav id="'.$identifier['nav']['id'].'" class="'.$identifier['nav']['class'].'">
    				<ul id="'.$identifier['ul']['id'].'" class="'.$identifier['ul']['class'].'">';


    	foreach($options['data'] as $k=>$v)
    	{
    		if(isset($v['filter']))
    		{
    			if($v['filter']=='*')
    			{
    				$ul .= '<li><a href="'.Uri::base().$v['link'].'">'.$v['name'].'</a></li>';
    			}elseif(in_array(\Auth\Auth::instance()->get('group')->id, $v['filter']))
    			{
					$ul .= '<li><a href="'.Uri::base().$v['link'].'">'.$v['name'].'</a></li>';
    			}


    		}
    	}

    	$ul .= '</ul></nav>';

    	return $ul;
	}

}