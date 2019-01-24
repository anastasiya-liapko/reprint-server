<?php
	include "engine/core.php";
	

	class GLOBAL_STORAGE
	{
	   static $parent_object;
	}
	

	$action = $_REQUEST['action'];
	$actions = [];

	define("RPP", 50); //кол-во строк на странице

	function array2csv($array)
	{
	   if (count($array) == 0)
	   {
	     return null;
	   }
	   ob_start();
	   $df = fopen("php://output", 'w');
	   fputcsv($df, array_keys($array[0]));
	   foreach ($array as $row)
	   {
	      fputcsv($df, array_values($row));
	   }
	   fclose($df);
	   return ob_get_clean();
	}

	function download_send_headers($filename)
	{
	    // disable caching
	    $now = gmdate("D, d M Y H:i:s");
	    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
	    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
	    header("Last-Modified: {$now} GMT");

	    // force download
	    header("Content-Type: application/force-download");
	    header("Content-Type: application/octet-stream");
	    header("Content-Type: application/download");

	    // disposition / encoding on response body
	    header("Content-Disposition: attachment;filename={$filename}");
	    header("Content-Transfer-Encoding: binary");
	}

	$actions['csv'] = function()
	{
		if(function_exists("allowCSV"))
		{
			if(!allowCSV())
			{
				die("У вас нет прав на экспорт CSV");
			}
		}
		download_send_headers("data_export_" . date("Y-m-d") . ".csv");
		$data = get_data(true)[0];

		if(function_exists("processCSV"))
		{
			$data = processCSV($data);
		}

		echo array2csv($data);
		die();
	};

	$actions[''] = function()
	{
			
   		$status_values = '[
{"text":"Новый", "value":"new"},
{"text":"Принят в работу", "value":"allow"},
{"text":"Отклонен", "value":"decline"},
{"text":"Отправлен", "value":"shipped"},
{"text":"Завершен", "value":"finished"}
]';
		$status_values_text = "";
		foreach(json_decode($status_values, true) as $opt)
		{
			$status_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$delivery_type_values = '[
{"text":"Курьер", "value":"courier"},
{"text":"Почта", "value":"post"},
{"text":"Самовывоз", "value":"pickup"}
]';
		$delivery_type_values_text = "";
		foreach(json_decode($delivery_type_values, true) as $opt)
		{
			$delivery_type_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		

		list($items, $pagination, $cnt) = get_data();

		$sort_order[$_REQUEST['sort_by']] = $_REQUEST['sort_order'];

$next_order['id']='asc';
$next_order['status']='asc';
$next_order['dt']='asc';
$next_order['total_price']='asc';
$next_order['']='asc';
$next_order['name']='asc';
$next_order['email']='asc';
$next_order['phone']='asc';
$next_order['address']='asc';
$next_order['comment']='asc';
$next_order['delivery_type']='asc';

		if($_REQUEST['sort_order']=='asc')
		{
			$sort_icon[$_REQUEST['sort_by']] = '<span class="fa fa-long-arrow-up" style="margin-left:5px;"></span>';
			$next_order[$_REQUEST['sort_by']] = 'desc';
		}
		else if($_REQUEST['sort_order']=='desc')
		{
			$sort_icon[$_REQUEST['sort_by']] = '<span class="fa fa-long-arrow-down" style="margin-left:5px;"></span>';
			$next_order[$_REQUEST['sort_by']] = '';
		}
		else if($_REQUEST['sort_order']=='')
		{
			$next_order[$_REQUEST['sort_by']] = 'asc';
		}
		$filter_caption = "";
		$show = '
		<script>
				window.onload = function ()
				{
					$(\'.big-icon\').html(\'<i class="fas fa-gift"></i>\');
				};


		</script>
		
		<style>
			html body.concept, html body.concept header, body.concept .table
			{
				background-color:;
				color:;
			}

			#tableMain tr:nth-child(even)
			{
  				background-color: ;
			}
		</style>
		<div class="content-header">
			<div class="btn-wrap">
				<h2><a href="#" class="back-btn"><span class="fa fa-arrow-circle-left"></span></a> '."Заказы".' </h2>
				<button class="btn blue-inline add_button" data-toggle="modal" data-target="#modal-main">ДОБАВИТЬ</button>
				<p class="small res-cnt">Кол-во результатов: <span class="cnt-number-span">'.$cnt.'</span></p>
			</div>
			
			<form class="navbar-form search-form" role="search">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Поиск" name="srch-term" id="srch-term" value="'.$_REQUEST['srch-term'].'">
					<button class="input-group-addon"><i class="fa fa-search"></i></button>
				</div>
			</form>
		</div>
		<div>'.
		""
		.'</div>';

		$show .= filter_divs();

		$show.='

		<div class="table-wrap" data-fl-scrolls>';
		$table='
			<table class="table table-bordered table-clickable" id="tableMain">
			<thead>
				<tr>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=id&sort_order='. ($next_order['id']) .'\' class=\'sort\' column=\'id\' sort_order=\''.$sort_order['id'].'\'>Id'. $sort_icon['id'].'</a>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=status&sort_order='. ($next_order['status']) .'\' class=\'sort\' column=\'status\' sort_order=\''.$sort_order['status'].'\'>Статус'. $sort_icon['status'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" multiple name="status_filter">
							'. $status_values_text .'
							</select>
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=dt&sort_order='. ($next_order['dt']) .'\' class=\'sort\' column=\'dt\' sort_order=\''.$sort_order['dt'].'\'>Время'. $sort_icon['dt'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<input autocomplete="off" type="text" class="form-control daterange filter-date-range" name="dt_filter">
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=total_price&sort_order='. ($next_order['total_price']) .'\' class=\'sort\' column=\'total_price\' sort_order=\''.$sort_order['total_price'].'\'>Всего'. $sort_icon['total_price'].'</a>
			</th>

			<th>
				   Состав
			</th>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=name&sort_order='. ($next_order['name']) .'\' class=\'sort\' column=\'name\' sort_order=\''.$sort_order['name'].'\'>Заказчик'. $sort_icon['name'].'</a>
			</th>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=email&sort_order='. ($next_order['email']) .'\' class=\'sort\' column=\'email\' sort_order=\''.$sort_order['email'].'\'>Email'. $sort_icon['email'].'</a>
			</th>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=phone&sort_order='. ($next_order['phone']) .'\' class=\'sort\' column=\'phone\' sort_order=\''.$sort_order['phone'].'\'>Телефон'. $sort_icon['phone'].'</a>
			</th>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=address&sort_order='. ($next_order['address']) .'\' class=\'sort\' column=\'address\' sort_order=\''.$sort_order['address'].'\'>Адрес'. $sort_icon['address'].'</a>
			</th>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=comment&sort_order='. ($next_order['comment']) .'\' class=\'sort\' column=\'comment\' sort_order=\''.$sort_order['comment'].'\'>Комментарий'. $sort_icon['comment'].'</a>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=delivery_type&sort_order='. ($next_order['delivery_type']) .'\' class=\'sort\' column=\'delivery_type\' sort_order=\''.$sort_order['delivery_type'].'\'>Доставка'. $sort_icon['delivery_type'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="delivery_type_filter">
							'. $delivery_type_values_text .'
							</select>
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>
					<th></th>
				</tr>
		</thead><tbody>';


		if(count($items) > 0)
		{
			foreach($items as $item)
			{
				$master = ($item['master'] == 1) ? 'Да' : 'Нет';

				$tr = "

				<tr pk='{$item['id']}'>
					
					".(function_exists("processTD")?processTD("<td>".htmlspecialchars($item['id'])."</td>", $item, "Id"):"<td>".htmlspecialchars($item['id'])."</td>")."
".(function_exists("processTD")?processTD("<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($status_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=orders' data-pk='{$item['id']}' data-name='status'>".select_mapping($status_values, $item['status'])."</span></td>", $item, "Статус"):"<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($status_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=orders' data-pk='{$item['id']}' data-name='status'>".select_mapping($status_values, $item['status'])."</span></td>")."
".(function_exists("processTD")?processTD("<td><span class='editable '  data-placeholder='' data-inp='date' data-url='engine/ajax.php?action=editable&table=orders' data-pk='{$item['id']}' data-name='dt'>".DateTime::createFromFormat('Y-m-d H:i:s', ($item['dt']?$item['dt']:"1970-01-01 00:00:00") )->format('Y-m-d H:i')."</span></td>", $item, "Время"):"<td><span class='editable '  data-placeholder='' data-inp='date' data-url='engine/ajax.php?action=editable&table=orders' data-pk='{$item['id']}' data-name='dt'>".DateTime::createFromFormat('Y-m-d H:i:s', ($item['dt']?$item['dt']:"1970-01-01 00:00:00") )->format('Y-m-d H:i')."</span></td>")."
".(function_exists("processTD")?processTD("<td>".htmlspecialchars($item['total_price'])."</td>", $item, "Всего"):"<td>".htmlspecialchars($item['total_price'])."</td>")."
".(function_exists("processTD")?processTD("
		<td>
			<div class='text-center'>
				<a href='order_items.php?order_id={$item["id"]}' class='btn btn-primary btn-genesis  '>
					<span class='fa fa-book'></span> 
				</a>
			</div>
		</td>

		", $item, "Состав"):"
		<td>
			<div class='text-center'>
				<a href='order_items.php?order_id={$item["id"]}' class='btn btn-primary btn-genesis  '>
					<span class='fa fa-book'></span> 
				</a>
			</div>
		</td>

		")."
".(function_exists("processTD")?processTD("<td><span class='editable ' data-placeholder='' data-inp='text' data-url='engine/ajax.php?action=editable&table=orders' data-pk='{$item['id']}' data-name='name'>".htmlspecialchars($item['name'])."</span></td>", $item, "Заказчик"):"<td><span class='editable ' data-placeholder='' data-inp='text' data-url='engine/ajax.php?action=editable&table=orders' data-pk='{$item['id']}' data-name='name'>".htmlspecialchars($item['name'])."</span></td>")."
".(function_exists("processTD")?processTD("<td><span class='editable ' data-placeholder='' data-inp='text' data-url='engine/ajax.php?action=editable&table=orders' data-pk='{$item['id']}' data-name='email'>".htmlspecialchars($item['email'])."</span></td>", $item, "Email"):"<td><span class='editable ' data-placeholder='' data-inp='text' data-url='engine/ajax.php?action=editable&table=orders' data-pk='{$item['id']}' data-name='email'>".htmlspecialchars($item['email'])."</span></td>")."
".(function_exists("processTD")?processTD("<td><span class='editable ' data-placeholder='' data-inp='text' data-url='engine/ajax.php?action=editable&table=orders' data-pk='{$item['id']}' data-name='phone'>".htmlspecialchars($item['phone'])."</span></td>", $item, "Телефон"):"<td><span class='editable ' data-placeholder='' data-inp='text' data-url='engine/ajax.php?action=editable&table=orders' data-pk='{$item['id']}' data-name='phone'>".htmlspecialchars($item['phone'])."</span></td>")."
".(function_exists("processTD")?processTD("<td><span class='editable ' data-placeholder='' data-inp='textarea' data-url='engine/ajax.php?action=editable&table=orders' data-pk='{$item['id']}' data-name='address'>".htmlspecialchars($item['address'])."</span></td>", $item, "Адрес"):"<td><span class='editable ' data-placeholder='' data-inp='textarea' data-url='engine/ajax.php?action=editable&table=orders' data-pk='{$item['id']}' data-name='address'>".htmlspecialchars($item['address'])."</span></td>")."
".(function_exists("processTD")?processTD("<td><span class='editable ' data-placeholder='' data-inp='textarea' data-url='engine/ajax.php?action=editable&table=orders' data-pk='{$item['id']}' data-name='comment'>".htmlspecialchars($item['comment'])."</span></td>", $item, "Комментарий"):"<td><span class='editable ' data-placeholder='' data-inp='textarea' data-url='engine/ajax.php?action=editable&table=orders' data-pk='{$item['id']}' data-name='comment'>".htmlspecialchars($item['comment'])."</span></td>")."
".(function_exists("processTD")?processTD("<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($delivery_type_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=orders' data-pk='{$item['id']}' data-name='delivery_type'>".select_mapping($delivery_type_values, $item['delivery_type'])."</span></td>", $item, "Доставка"):"<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($delivery_type_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=orders' data-pk='{$item['id']}' data-name='delivery_type'>".select_mapping($delivery_type_values, $item['delivery_type'])."</span></td>")."
					<td><a href='#' class='edit_btn'><i class='fa fa-edit' style='color:grey;'></i></a> <a href='#' class='delete_btn'><i class='fa fa-trash' style='color:red;'></i></a></td>
				</tr>";

				if(function_exists("processTR"))
				{
					$tr = processTR($tr, $item);
				}

				$table.=$tr;
			}

			$table .= '</tbody></table></div>'.$pagination;

		}
		else
		{
			$table.=' </tbody></table><div class="empty_table">Нет информации</div>';
		}

		if(function_exists("processTable"))
		{
			$table = processTable($table);
		}

		$show.=$table."<div></div>".'';

		if(function_exists("processPage"))
		{
			$show = processPage($show);
		}

		$show.="
		<style></style>
		<script></script>";


		return $show;

	};

	$actions['edit'] = function()
	{
		$id = $_REQUEST['genesis_edit_id'];
		if(isset($id))
		{
			$item = q("SELECT * FROM _orders WHERE id=?",[$id]);
			$item = $item[0];
		}

		

		$html = '
			<form class="form" enctype="multipart/form-data" method="POST">
				<fieldset>'.
					(isset($id)?
					'<input type="hidden" name="id" value="'.$id.'">
					<input type="hidden" name="action" value="edit_execute">'
					:
					'<input type="hidden" name="action" value="create_execute">'
					)
					.'

					
		          <div class="form-group not-editable">
		            <label class="control-label" for="textinput">Id</label>
		            <div>
		            <p>
		              '.$item["id"].'
		            </p>
		            </div>
		          </div>

		          



				<div class="form-group">
					<label class="control-label" for="textinput">Статус</label>
					<div>
						<select id="status" name="status" class="form-control input-md ">
							<option value="new" '.($item["status"]=="new"?"selected":"").'>Новый</option> 
<option value="allow" '.($item["status"]=="allow"?"selected":"").'>Принят в работу</option> 
<option value="decline" '.($item["status"]=="decline"?"selected":"").'>Отклонен</option> 
<option value="shipped" '.($item["status"]=="shipped"?"selected":"").'>Отправлен</option> 
<option value="finished" '.($item["status"]=="finished"?"selected":"").'>Завершен</option> 

						</select>
					</div>
				</div>

			


					<div class="form-group">
						<label class="control-label" for="textinput">Время</label>
						<div>
							<input autocomplete="off" id="dt" placeholder="" name="dt" type="text" class="form-control datepicker "  value="'.(isset($item["dt"])?$item["dt"]:date("Y-m-d H:i")).'"/>
						</div>
					</div>

				

		          <div class="form-group not-editable">
		            <label class="control-label" for="textinput">Новое поле</label>
		            <div>
		            <p>
		              '.$item[""].'
		            </p>
		            </div>
		          </div>

		          


								<div class="form-group">
									<label class="control-label" for="textinput">Заказчик</label>
									<div>
										<input id="name" name="name" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["name"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">Email</label>
									<div>
										<input id="email" name="email" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["email"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">Телефон</label>
									<div>
										<input id="phone" name="phone" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["phone"]).'">
									</div>
								</div>

							


							<div class="form-group">
								<label class="control-label" for="textinput">Адрес</label>
								<div>
									<textarea id="address" name="address" class="form-control input-md  "  >'.htmlspecialchars($item["address"]).'</textarea>
								</div>
							</div>

						


							<div class="form-group">
								<label class="control-label" for="textinput">Комментарий</label>
								<div>
									<textarea id="comment" name="comment" class="form-control input-md  "  >'.htmlspecialchars($item["comment"]).'</textarea>
								</div>
							</div>

						



				<div class="form-group">
					<label class="control-label" for="textinput">Доставка</label>
					<div>
						<select id="delivery_type" name="delivery_type" class="form-control input-md ">
							<option value="courier" '.($item["delivery_type"]=="courier"?"selected":"").'>Курьер</option> 
<option value="post" '.($item["delivery_type"]=="post"?"selected":"").'>Почта</option> 
<option value="pickup" '.($item["delivery_type"]=="pickup"?"selected":"").'>Самовывоз</option> 

						</select>
					</div>
				</div>

			
					<div class="text-center not-editable">
						
					</div>

				</fieldset>
			</form>

		';

		if(function_exists("processEditModalHTML"))
		{
			$html = processEditModalHTML($html);
		}
		die($html);
	};

	$actions['create'] = function()
	{

		

		$html = '
			<form class="form" enctype="multipart/form-data" method="POST">
				<fieldset>
					<input type="hidden" name="action" value="create_execute">
					
		          <div class="form-group not-editable">
		            <label class="control-label" for="textinput">Id</label>
		            <div>
		            <p>
		              '.$item["id"].'
		            </p>
		            </div>
		          </div>

		          



				<div class="form-group">
					<label class="control-label" for="textinput">Статус</label>
					<div>
						<select id="status" name="status" class="form-control input-md ">
							<option value="new" '.($item["status"]=="new"?"selected":"").'>Новый</option> 
<option value="allow" '.($item["status"]=="allow"?"selected":"").'>Принят в работу</option> 
<option value="decline" '.($item["status"]=="decline"?"selected":"").'>Отклонен</option> 
<option value="shipped" '.($item["status"]=="shipped"?"selected":"").'>Отправлен</option> 
<option value="finished" '.($item["status"]=="finished"?"selected":"").'>Завершен</option> 

						</select>
					</div>
				</div>

			


					<div class="form-group">
						<label class="control-label" for="textinput">Время</label>
						<div>
							<input autocomplete="off" id="dt" placeholder="" name="dt" type="text" class="form-control datepicker "  value="'.(isset($item["dt"])?$item["dt"]:date("Y-m-d H:i")).'"/>
						</div>
					</div>

				


								<div class="form-group">
									<label class="control-label" for="textinput">Заказчик</label>
									<div>
										<input id="name" name="name" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["name"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">Email</label>
									<div>
										<input id="email" name="email" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["email"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">Телефон</label>
									<div>
										<input id="phone" name="phone" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["phone"]).'">
									</div>
								</div>

							


							<div class="form-group">
								<label class="control-label" for="textinput">Адрес</label>
								<div>
									<textarea id="address" name="address" class="form-control input-md  "  >'.htmlspecialchars($item["address"]).'</textarea>
								</div>
							</div>

						


							<div class="form-group">
								<label class="control-label" for="textinput">Комментарий</label>
								<div>
									<textarea id="comment" name="comment" class="form-control input-md  "  >'.htmlspecialchars($item["comment"]).'</textarea>
								</div>
							</div>

						



				<div class="form-group">
					<label class="control-label" for="textinput">Доставка</label>
					<div>
						<select id="delivery_type" name="delivery_type" class="form-control input-md ">
							<option value="courier" '.($item["delivery_type"]=="courier"?"selected":"").'>Курьер</option> 
<option value="post" '.($item["delivery_type"]=="post"?"selected":"").'>Почта</option> 
<option value="pickup" '.($item["delivery_type"]=="pickup"?"selected":"").'>Самовывоз</option> 

						</select>
					</div>
				</div>

			
					<div class="text-center not-editable">
						
					</div>
				</fieldset>
			</form>

		';

		if(function_exists("processCreateModalHTML"))
		{
			$html = processCreateModalHTML($html);
		}
		die($html);
	};


	$actions['edit_page'] = function()
	{
		$id = $_REQUEST['genesis_edit_id'];
		if(isset($id))
		{
			$item = q("SELECT * FROM _orders WHERE id=?",[$id]);
			$item = $item[0];
		}
		else
		{
			die("Ошибка. Редактирование несуществующей записи (вы не указали id)");
		}

		


		$html = '
			<h1 style="line-height: 30px"> Редактирование <br /><small>'."Заказы".' #'.$id.'</small></h1>
			<form class="form" enctype="multipart/form-data" method="POST">
				<input type="hidden" name="back" value="'.$_SERVER['HTTP_REFERER'].'">
				<fieldset>'.
					(isset($id)?
					'<input type="hidden" name="id" value="'.$id.'">
					<input type="hidden" name="action" value="edit_execute">'
					:
					'<input type="hidden" name="action" value="create_execute">'
					)
					.'

					
		          <div class="form-group not-editable">
		            <label class="control-label" for="textinput">Id</label>
		            <div>
		            <p>
		              '.$item["id"].'
		            </p>
		            </div>
		          </div>

		          



				<div class="form-group">
					<label class="control-label" for="textinput">Статус</label>
					<div>
						<select id="status" name="status" class="form-control input-md ">
							<option value="new" '.($item["status"]=="new"?"selected":"").'>Новый</option> 
<option value="allow" '.($item["status"]=="allow"?"selected":"").'>Принят в работу</option> 
<option value="decline" '.($item["status"]=="decline"?"selected":"").'>Отклонен</option> 
<option value="shipped" '.($item["status"]=="shipped"?"selected":"").'>Отправлен</option> 
<option value="finished" '.($item["status"]=="finished"?"selected":"").'>Завершен</option> 

						</select>
					</div>
				</div>

			


					<div class="form-group">
						<label class="control-label" for="textinput">Время</label>
						<div>
							<input autocomplete="off" id="dt" placeholder="" name="dt" type="text" class="form-control datepicker "  value="'.(isset($item["dt"])?$item["dt"]:date("Y-m-d H:i")).'"/>
						</div>
					</div>

				

		          <div class="form-group not-editable">
		            <label class="control-label" for="textinput">Новое поле</label>
		            <div>
		            <p>
		              '.$item[""].'
		            </p>
		            </div>
		          </div>

		          


								<div class="form-group">
									<label class="control-label" for="textinput">Заказчик</label>
									<div>
										<input id="name" name="name" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["name"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">Email</label>
									<div>
										<input id="email" name="email" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["email"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">Телефон</label>
									<div>
										<input id="phone" name="phone" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["phone"]).'">
									</div>
								</div>

							


							<div class="form-group">
								<label class="control-label" for="textinput">Адрес</label>
								<div>
									<textarea id="address" name="address" class="form-control input-md  "  >'.htmlspecialchars($item["address"]).'</textarea>
								</div>
							</div>

						


							<div class="form-group">
								<label class="control-label" for="textinput">Комментарий</label>
								<div>
									<textarea id="comment" name="comment" class="form-control input-md  "  >'.htmlspecialchars($item["comment"]).'</textarea>
								</div>
							</div>

						



				<div class="form-group">
					<label class="control-label" for="textinput">Доставка</label>
					<div>
						<select id="delivery_type" name="delivery_type" class="form-control input-md ">
							<option value="courier" '.($item["delivery_type"]=="courier"?"selected":"").'>Курьер</option> 
<option value="post" '.($item["delivery_type"]=="post"?"selected":"").'>Почта</option> 
<option value="pickup" '.($item["delivery_type"]=="pickup"?"selected":"").'>Самовывоз</option> 

						</select>
					</div>
				</div>

			

				</fieldset>
				<div>
					<a href="?'.(http_build_query(array_filter($_REQUEST, function($k){return !in_array($k, ['action', 'genesis_edit_id']);}, ARRAY_FILTER_USE_KEY))).'" class="btn cancel" >Закрыть</a>
					<button type="button" class="btn blue-inline" id="edit_page_save">Сохранить</a>
				</div>
			</form>

		';

		if(function_exists("processEditPageHTML"))
		{
			$html = processEditPageHTML($html);
		}
		return $html;
	};

	$actions['reorder'] = function()
	{
		$line = json_decode($_REQUEST['genesis_ids_in_order'], true);
		for ($i=0; $i < count($line); $i++)
		{
			qi("UPDATE `orders` SET `` = ? WHERE id = ?", [$i, $line[$i]]);
		}


		die(json_encode(['status'=>0]));

	};

	$actions['create_execute'] = function()
	{
		if(function_exists("allowInsert"))
		{
			if(!allowInsert())
			{
				header("Location: ".$_SERVER['HTTP_REFERER']);
				die("");
			}
		}
		$status = $_REQUEST['status'];
$dt = $_REQUEST['dt'];
$name = $_REQUEST['name'];
$email = $_REQUEST['email'];
$phone = $_REQUEST['phone'];
$address = $_REQUEST['address'];
$comment = $_REQUEST['comment'];
$delivery_type = $_REQUEST['delivery_type'];

		$sql = "INSERT INTO orders (`status`, `dt`, `name`, `email`, `phone`, `address`, `comment`, `delivery_type`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		if(function_exists("processInsertQuery"))
		{
			$sql = processInsertQuery($sql);
		}

		qi($sql, [$status, $dt, $name, $email, $phone, $address, $comment, $delivery_type]);
		$last_id = qInsertId();

		if(function_exists("afterInsert"))
		{
			afterInsert($last_id);
		}

		

		header("Location: ".$_SERVER['HTTP_REFERER']);
		die("");

	};

	$actions['edit_execute'] = function()
	{
		$skip = false;
		if(function_exists("allowUpdate"))
		{
			if(!allowUpdate())
			{
				$skip = true;
			}
		}
		if(!$skip)
		{
			$id = $_REQUEST['id'];
			$set = [];

			$set[] = is_null($_REQUEST['status'])?"`status`=NULL":"`status`='".addslashes($_REQUEST['status'])."'";
$set[] = is_null($_REQUEST['dt'])?"`dt`=NULL":"`dt`='".addslashes($_REQUEST['dt'])."'";
$set[] = is_null($_REQUEST['name'])?"`name`=NULL":"`name`='".addslashes($_REQUEST['name'])."'";
$set[] = is_null($_REQUEST['email'])?"`email`=NULL":"`email`='".addslashes($_REQUEST['email'])."'";
$set[] = is_null($_REQUEST['phone'])?"`phone`=NULL":"`phone`='".addslashes($_REQUEST['phone'])."'";
$set[] = is_null($_REQUEST['address'])?"`address`=NULL":"`address`='".addslashes($_REQUEST['address'])."'";
$set[] = is_null($_REQUEST['comment'])?"`comment`=NULL":"`comment`='".addslashes($_REQUEST['comment'])."'";
$set[] = is_null($_REQUEST['delivery_type'])?"`delivery_type`=NULL":"`delivery_type`='".addslashes($_REQUEST['delivery_type'])."'";

			if(count($set)>0)
			{
				$set = implode(", ", $set);
				$sql = "UPDATE orders SET $set WHERE id=?";
				if(function_exists("processUpdateQuery"))
				{
					$sql = processUpdateQuery($sql);
				}

				qi($sql, [$id]);
				if(function_exists("afterUpdate"))
				{
					afterUpdate();
				}
			}
		}

		if(isset($_REQUEST['back']))
		{
			header("Location: {$_REQUEST['back']}");
		}
		else
		{
			header("Location: ".$_SERVER['HTTP_REFERER']);
		}
		die("");
	};



	$actions['delete'] = function()
	{
		if(function_exists("allowDelete"))
		{
			if(!allowDelete())
			{
				die("0");
			}
		}

		$id = $_REQUEST['id'];
		try
		{
			qi("DELETE FROM orders WHERE id=?", [$id]);
			if(function_exists("afterDelete"))
			{
				afterDelete();
			}
			echo "1";
		}
		catch (Exception $e)
		{
			echo "0";
		}

		die("");
	};

	function filter_query($srch)
	{
		$filters = [];
		
		if(isset2($_REQUEST['status_filter']))
		{
			$status_filter_array = array_map(function($i)
			{
				return "'$i'";
			},$_REQUEST['status_filter']);

			$status_filter_string = implode(', ', $status_filter_array);
			$filters[] = "`status` IN ({$status_filter_string})";
		}
				

		if(isset2($_REQUEST['dt_filter_from']) && isset2($_REQUEST['dt_filter_to']))
		{
			$filters[] = "dt >= '{$_REQUEST['dt_filter_from']}' AND dt <= '{$_REQUEST['dt_filter_to']}'";
		}

		

		if(isset2($_REQUEST['delivery_type_filter']))
		{
			$filters[] = "`delivery_type` = '{$_REQUEST['delivery_type_filter']}'";
		}
				

		$filter="";
		if(count($filters)>0)
		{
			$filter = implode(" AND ", $filters);
			if($srch=="")
			{
				$filter = " WHERE $filter";
			}
			else
			{
				$filter = " AND ($filter)";
			}
		}
		return $filter;
	}

	function filter_divs()
	{
		$status_values = '[
{"text":"Новый", "value":"new"},
{"text":"Принят в работу", "value":"allow"},
{"text":"Отклонен", "value":"decline"},
{"text":"Отправлен", "value":"shipped"},
{"text":"Завершен", "value":"finished"}
]';
		$status_values_text = "";
		foreach(json_decode($status_values, true) as $opt)
		{
			$status_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
$delivery_type_values = '[
{"text":"Курьер", "value":"courier"},
{"text":"Почта", "value":"post"},
{"text":"Самовывоз", "value":"pickup"}
]';
		$delivery_type_values_text = "";
		foreach(json_decode($delivery_type_values, true) as $opt)
		{
			$delivery_type_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
		}

		
		



		if(isset2($_REQUEST['status_filter']))
		{

			$text_option = array_filter(json_decode($status_values, true), function($i)
			{
				return in_array($i['value'], $_REQUEST['status_filter']);
			});

			$text_option = array_map(function($item)
			{
				return $item['text'];
			}, $text_option);

			$text_option = implode(', ', $text_option);

			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='status_filter' value='{$_REQUEST['status_filter']}'>
					<span class='fa fa-times remove-tag'></span> Статус: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		if(isset2($_REQUEST['dt_filter_from']))
		{
			$from = date('d.m.Y', strtotime($_REQUEST['dt_filter_from']));
			$to = date('d.m.Y', strtotime($_REQUEST['dt_filter_to']));
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='dt_filter_from' value='{$_REQUEST['dt_filter_from']}'>
					<input type='hidden' class='filter' name='dt_filter_to' value='{$_REQUEST['dt_filter_to']}'>
					<span class='fa fa-times remove-tag'></span> Время: <b>{$from}–{$to}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		$text_option = array_filter(json_decode($delivery_type_values, true), function($i)
		{
			return $i['value']==$_REQUEST['delivery_type_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['delivery_type_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='delivery_type_filter' value='{$_REQUEST['delivery_type_filter']}'>
					<span class='fa fa-times remove-tag'></span> Доставка: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				
		$show = $filter_caption.$filter_divs;

		return $show;
	}


	function get_data($force_kill_pagination=false)
	{
		if(function_exists("allowSelect"))
		{
			if(!allowSelect())
			{
				die("У вас нет доступа к данной странице");
			}
		}

		$pagination = 1;
		if($force_kill_pagination==true)
		{
			$pagination = 0;
		}
		$items = [];

		$srch = "";
		
			if($_REQUEST['srch-term'])
			{
				$srch = "WHERE ((`name` LIKE '%{$_REQUEST['srch-term']}%') or (`email` LIKE '%{$_REQUEST['srch-term']}%') or (`phone` LIKE '%{$_REQUEST['srch-term']}%') or (`address` LIKE '%{$_REQUEST['srch-term']}%') or (`comment` LIKE '%{$_REQUEST['srch-term']}%'))";
			}

		$filter = filter_query($srch);
		$where = "";
		if($where != "")
		{
			if($filter!='' || $srch !='')
			{
				$where = " AND ($where)";
			}
			else
			{
				$where = " WHERE ($where)";
			}
		}


		
				$default_sort_by = 'dt';
				$default_sort_order = 'desc';
			

		if(isset($default_sort_by) && $default_sort_by)
		{
			$order = "ORDER BY $default_sort_by $default_sort_order";
		}

		if(isset($_REQUEST['sort_by']) && $_REQUEST['sort_by']!="")
		{
			$order = "ORDER BY {$_REQUEST['sort_by']} {$_REQUEST['sort_order']}";
		}


		if($pagination == 1)
		{
			$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM (SELECT  main_table.*  FROM _orders main_table) temp $srch $filter $where $order LIMIT :start, :limit";
			if(function_exists("processSelectQuery"))
			{
				$sql = processSelectQuery($sql);
			}

			$items = q($sql,
				[
					'start' => MAX(($_GET['page']-1), 0)*RPP,
					'limit' => RPP
				]);
			$cnt = qRows();
			$pagination = pagination($cnt);
		}
		else
		{
			$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM (SELECT main_table.*  FROM _orders main_table) temp $srch $filter $where $order";
			if(function_exists("processSelectQuery"))
			{
				$sql = processSelectQuery($sql);
			}
			$items = q($sql, []);
			$cnt = qRows();
			$pagination = "";
		}

		if(function_exists("processData"))
		{
			$items = processData($items);
		}

		return [$items, $pagination, $cnt];
	}

	

	$content = $actions[$action]();
	echo masterRender("Заказы", $content, 8);

	
