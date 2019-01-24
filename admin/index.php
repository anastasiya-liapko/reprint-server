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
			
   		$section_id_values = json_encode(q("SELECT name as text, id as value FROM sections", []));
				  $section_id_values_text = "";
			foreach(json_decode($section_id_values, true) as $opt)
			{
			  $section_id_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
			}
$is_showed_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
			$is_showed_values_text = "";
			foreach(json_decode($is_showed_values, true) as $opt)
			{
			  $is_showed_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
			}
				  

		list($items, $pagination, $cnt) = get_data();

		$sort_order[$_REQUEST['sort_by']] = $_REQUEST['sort_order'];

$next_order['id']='asc';
$next_order['name']='asc';
$next_order['author']='asc';
$next_order['section_id']='asc';
$next_order['price']='asc';
$next_order['is_showed']='asc';
$next_order['']='asc';
$next_order['']='asc';
$next_order['']='asc';
$next_order['']='asc';

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
					$(\'.big-icon\').html(\'<i class="fas fa-book"></i>\');
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
  				background-color: #F8F8F8;
			}
		</style>
		<div class="content-header">
			<div class="btn-wrap">
				<h2><a href="#" class="back-btn"><span class="fa fa-arrow-circle-left"></span></a> '."Книги".' </h2>
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
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=id&sort_order='. ($next_order['id']) .'\' class=\'sort\' column=\'id\' sort_order=\''.$sort_order['id'].'\'>ID'. $sort_icon['id'].'</a>
			</th>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=name&sort_order='. ($next_order['name']) .'\' class=\'sort\' column=\'name\' sort_order=\''.$sort_order['name'].'\'>Название'. $sort_icon['name'].'</a>
			</th>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=author&sort_order='. ($next_order['author']) .'\' class=\'sort\' column=\'author\' sort_order=\''.$sort_order['author'].'\'>Автор'. $sort_icon['author'].'</a>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=section_id&sort_order='. ($next_order['section_id']) .'\' class=\'sort\' column=\'section_id\' sort_order=\''.$sort_order['section_id'].'\'>Секция'. $sort_icon['section_id'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="section_id_filter">
							'. $section_id_values_text .'
							</select>
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=price&sort_order='. ($next_order['price']) .'\' class=\'sort\' column=\'price\' sort_order=\''.$sort_order['price'].'\'>Цена'. $sort_icon['price'].'</a>
			</th>

			<th>
				<nobr>
					<a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=is_showed&sort_order='. ($next_order['is_showed']) .'\' class=\'sort\' column=\'is_showed\' sort_order=\''.$sort_order['is_showed'].'\'>Доступна'. $sort_icon['is_showed'].'</a>
					
			<span class=\'fa fa-filter filter btn btn-default\' data-placement=\'bottom\' data-content=\'<div class="input-group">
							<select class="form-control filter-select" name="is_showed_filter">
							'. $is_showed_values_text .'
							</select>
							<span class="input-group-btn">
								<button class="btn btn-primary add-filter" type="button"><span class="fa fa-filter"></a></button>
							</span>
						</div>\'>
			</span>
				</nobr>
			</th>

			<th>
				   Типы бумаги
			</th>

			<th>
				   Переплеты
			</th>

			<th>
				   Форматы
			</th>

			<th>
				   Изображения
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
					
					".(function_exists("processTD")?processTD("<td>".htmlspecialchars($item['id'])."</td>", $item, "ID"):"<td>".htmlspecialchars($item['id'])."</td>")."
".(function_exists("processTD")?processTD("<td><span class='editable ' data-placeholder='' data-inp='text' data-url='engine/ajax.php?action=editable&table=books' data-pk='{$item['id']}' data-name='name'>".htmlspecialchars($item['name'])."</span></td>", $item, "Название"):"<td><span class='editable ' data-placeholder='' data-inp='text' data-url='engine/ajax.php?action=editable&table=books' data-pk='{$item['id']}' data-name='name'>".htmlspecialchars($item['name'])."</span></td>")."
".(function_exists("processTD")?processTD("<td><span class='editable ' data-placeholder='' data-inp='text' data-url='engine/ajax.php?action=editable&table=books' data-pk='{$item['id']}' data-name='author'>".htmlspecialchars($item['author'])."</span></td>", $item, "Автор"):"<td><span class='editable ' data-placeholder='' data-inp='text' data-url='engine/ajax.php?action=editable&table=books' data-pk='{$item['id']}' data-name='author'>".htmlspecialchars($item['author'])."</span></td>")."
".(function_exists("processTD")?processTD("<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($section_id_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=books' data-pk='{$item['id']}' data-name='section_id'>".select_mapping($section_id_values, $item['section_id'])."</span></td>", $item, "Секция"):"<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($section_id_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=books' data-pk='{$item['id']}' data-name='section_id'>".select_mapping($section_id_values, $item['section_id'])."</span></td>")."
".(function_exists("processTD")?processTD("<td><span class='editable ' data-placeholder='' data-inp='decimal' data-url='engine/ajax.php?action=editable&table=books' data-pk='{$item['id']}' data-name='price'>".htmlspecialchars($item['price'])."</span></td>", $item, "Цена"):"<td><span class='editable ' data-placeholder='' data-inp='decimal' data-url='engine/ajax.php?action=editable&table=books' data-pk='{$item['id']}' data-name='price'>".htmlspecialchars($item['price'])."</span></td>")."
".(function_exists("processTD")?processTD("<td><span class=' '>".renderRadioGroup("is_showed", $is_showed_values, "books", $item['id'], $item['is_showed'])."</td>", $item, "Доступна"):"<td><span class=' '>".renderRadioGroup("is_showed", $is_showed_values, "books", $item['id'], $item['is_showed'])."</td>")."
".(function_exists("processTD")?processTD("
		<td>
			<div class='text-center'>
				<a href='book_types.php?book_id={$item["id"]}&book_name={$item["name"]}' class='btn btn-primary btn-genesis  '>
					<span class='fa fa-file'></span> 
				</a>
			</div>
		</td>

		", $item, "Типы бумаги"):"
		<td>
			<div class='text-center'>
				<a href='book_types.php?book_id={$item["id"]}&book_name={$item["name"]}' class='btn btn-primary btn-genesis  '>
					<span class='fa fa-file'></span> 
				</a>
			</div>
		</td>

		")."
".(function_exists("processTD")?processTD("
		<td>
			<div class='text-center'>
				<a href='book_covers.php?book_id={$item["id"]}&book_name={$item["name"]}' class='btn btn-primary btn-genesis  '>
					<span class='fa fa-bookmark'></span> 
				</a>
			</div>
		</td>

		", $item, "Переплеты"):"
		<td>
			<div class='text-center'>
				<a href='book_covers.php?book_id={$item["id"]}&book_name={$item["name"]}' class='btn btn-primary btn-genesis  '>
					<span class='fa fa-bookmark'></span> 
				</a>
			</div>
		</td>

		")."
".(function_exists("processTD")?processTD("
		<td>
			<div class='text-center'>
				<a href='book_formats.php?book_id={$item["id"]}&book_name={$item["name"]}' class='btn btn-primary btn-genesis  '>
					<span class='fa fa-arrows-alt'></span> 
				</a>
			</div>
		</td>

		", $item, "Форматы"):"
		<td>
			<div class='text-center'>
				<a href='book_formats.php?book_id={$item["id"]}&book_name={$item["name"]}' class='btn btn-primary btn-genesis  '>
					<span class='fa fa-arrows-alt'></span> 
				</a>
			</div>
		</td>

		")."
".(function_exists("processTD")?processTD("
		<td>
			<div class='text-center'>
				<a href='images.php?book_id={$item["id"]}&book_name={$item["name"]}' class='btn btn-primary btn-genesis  '>
					<span class='fa fa-image'></span> 
				</a>
			</div>
		</td>

		", $item, "Изображения"):"
		<td>
			<div class='text-center'>
				<a href='images.php?book_id={$item["id"]}&book_name={$item["name"]}' class='btn btn-primary btn-genesis  '>
					<span class='fa fa-image'></span> 
				</a>
			</div>
		</td>

		")."
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
			$item = q("SELECT * FROM books WHERE id=?",[$id]);
			$item = $item[0];
		}

		
			$section_id_options = q("SELECT name as text, id as value FROM sections",[]);
			$section_id_options_html = "";
			foreach($section_id_options as $o)
			{
				$section_id_options_html .= "<option value=\"{$o['value']}\" ".($o["value"]==$item["section_id"]?"selected":"").">{$o['text']}</option>";
			}
		
$is_showed_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';

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
		            <label class="control-label" for="textinput">ID</label>
		            <div>
		            <p>
		              '.$item["id"].'
		            </p>
		            </div>
		          </div>

		          


								<div class="form-group">
									<label class="control-label" for="textinput">Название</label>
									<div>
										<input id="name" name="name" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["name"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">Автор</label>
									<div>
										<input id="author" name="author" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["author"]).'">
									</div>
								</div>

							

			<div class="form-group">
				<label class="control-label" for="textinput">Секция</label>
				<div>
					<select id="section_id" name="section_id" class="form-control input-md " >
						'.$section_id_options_html.'
						</select>
				</div>
			</div>

		


	               <div class="form-group">
	                 <label class="control-label" for="textinput">Цена</label>
	                 <div>
	                   <input id="price" name="price" type="number" step="0.01" class="form-control input-md " placeholder=""  value="'.htmlspecialchars($item["price"]).'">
	                 </div>
	               </div>

	             



            <div class="form-group">
              <label class="control-label" for="textinput">Доступна</label>
              <div class="" >'.renderEditRadioGroup("is_showed", $is_showed_values, $item["is_showed"]).'
              </div>
            </div>

          


							<div class="form-group">
								<label class="control-label" for="textinput">Описание</label>
								<div>
									<textarea id="dsc" name="dsc" class="form-control input-md  ckeditor"  >'.htmlspecialchars($item["dsc"]).'</textarea>
								</div>
							</div>

						


							<div class="form-group">
								<label class="control-label" for="textinput">Дополнительно</label>
								<div>
									<textarea id="extra" name="extra" class="form-control input-md  ckeditor"  >'.htmlspecialchars($item["extra"]).'</textarea>
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

		
			$section_id_options = q("SELECT name as text, id as value FROM sections",[]);
			$section_id_options_html = "";
			foreach($section_id_options as $o)
			{
				$section_id_options_html .= "<option value=\"{$o['value']}\" ".($o["value"]==$item["section_id"]?"selected":"").">{$o['text']}</option>";
			}
		
$is_showed_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';

		$html = '
			<form class="form" enctype="multipart/form-data" method="POST">
				<fieldset>
					<input type="hidden" name="action" value="create_execute">
					
		          <div class="form-group not-editable">
		            <label class="control-label" for="textinput">ID</label>
		            <div>
		            <p>
		              '.$item["id"].'
		            </p>
		            </div>
		          </div>

		          


								<div class="form-group">
									<label class="control-label" for="textinput">Название</label>
									<div>
										<input id="name" name="name" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["name"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">Автор</label>
									<div>
										<input id="author" name="author" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["author"]).'">
									</div>
								</div>

							

			<div class="form-group">
				<label class="control-label" for="textinput">Секция</label>
				<div>
					<select id="section_id" name="section_id" class="form-control input-md " >
						'.$section_id_options_html.'
						</select>
				</div>
			</div>

		


	               <div class="form-group">
	                 <label class="control-label" for="textinput">Цена</label>
	                 <div>
	                   <input id="price" name="price" type="number" step="0.01" class="form-control input-md " placeholder=""  value="'.htmlspecialchars($item["price"]).'">
	                 </div>
	               </div>

	             



            <div class="form-group">
              <label class="control-label" for="textinput">Доступна</label>
              <div class="" >'.renderEditRadioGroup("is_showed", $is_showed_values, $item["is_showed"]).'
              </div>
            </div>

          


							<div class="form-group">
								<label class="control-label" for="textinput">Описание</label>
								<div>
									<textarea id="dsc" name="dsc" class="form-control input-md  ckeditor"  >'.htmlspecialchars($item["dsc"]).'</textarea>
								</div>
							</div>

						


							<div class="form-group">
								<label class="control-label" for="textinput">Дополнительно</label>
								<div>
									<textarea id="extra" name="extra" class="form-control input-md  ckeditor"  >'.htmlspecialchars($item["extra"]).'</textarea>
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
			$item = q("SELECT * FROM books WHERE id=?",[$id]);
			$item = $item[0];
		}
		else
		{
			die("Ошибка. Редактирование несуществующей записи (вы не указали id)");
		}

		
			$section_id_options = q("SELECT name as text, id as value FROM sections",[]);
			$section_id_options_html = "";
			foreach($section_id_options as $o)
			{
				$section_id_options_html .= "<option value=\"{$o['value']}\" ".($o["value"]==$item["section_id"]?"selected":"").">{$o['text']}</option>";
			}
		
$is_showed_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';


		$html = '
			<h1 style="line-height: 30px"> Редактирование <br /><small>'."Книги".' #'.$id.'</small></h1>
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
		            <label class="control-label" for="textinput">ID</label>
		            <div>
		            <p>
		              '.$item["id"].'
		            </p>
		            </div>
		          </div>

		          


								<div class="form-group">
									<label class="control-label" for="textinput">Название</label>
									<div>
										<input id="name" name="name" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["name"]).'">
									</div>
								</div>

							


								<div class="form-group">
									<label class="control-label" for="textinput">Автор</label>
									<div>
										<input id="author" name="author" type="text"  placeholder="" class="form-control input-md " value="'.htmlspecialchars($item["author"]).'">
									</div>
								</div>

							

			<div class="form-group">
				<label class="control-label" for="textinput">Секция</label>
				<div>
					<select id="section_id" name="section_id" class="form-control input-md " >
						'.$section_id_options_html.'
						</select>
				</div>
			</div>

		


	               <div class="form-group">
	                 <label class="control-label" for="textinput">Цена</label>
	                 <div>
	                   <input id="price" name="price" type="number" step="0.01" class="form-control input-md " placeholder=""  value="'.htmlspecialchars($item["price"]).'">
	                 </div>
	               </div>

	             



            <div class="form-group">
              <label class="control-label" for="textinput">Доступна</label>
              <div class="" >'.renderEditRadioGroup("is_showed", $is_showed_values, $item["is_showed"]).'
              </div>
            </div>

          


							<div class="form-group">
								<label class="control-label" for="textinput">Описание</label>
								<div>
									<textarea id="dsc" name="dsc" class="form-control input-md  ckeditor"  >'.htmlspecialchars($item["dsc"]).'</textarea>
								</div>
							</div>

						


							<div class="form-group">
								<label class="control-label" for="textinput">Дополнительно</label>
								<div>
									<textarea id="extra" name="extra" class="form-control input-md  ckeditor"  >'.htmlspecialchars($item["extra"]).'</textarea>
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
			qi("UPDATE `books` SET `` = ? WHERE id = ?", [$i, $line[$i]]);
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
		$name = $_REQUEST['name'];
$author = $_REQUEST['author'];
$section_id = $_REQUEST['section_id'];
$price = $_REQUEST['price'];
$is_showed = $_REQUEST['is_showed'];
$dsc = $_REQUEST['dsc'];
$extra = $_REQUEST['extra'];

		$sql = "INSERT INTO books (`name`, `author`, `section_id`, `price`, `is_showed`, `dsc`, `extra`) VALUES (?, ?, ?, ?, ?, ?, ?)";
		if(function_exists("processInsertQuery"))
		{
			$sql = processInsertQuery($sql);
		}

		qi($sql, [$name, $author, $section_id, $price, $is_showed, $dsc, $extra]);
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

			$set[] = is_null($_REQUEST['name'])?"`name`=NULL":"`name`='".addslashes($_REQUEST['name'])."'";
$set[] = is_null($_REQUEST['author'])?"`author`=NULL":"`author`='".addslashes($_REQUEST['author'])."'";
$set[] = is_null($_REQUEST['section_id'])?"`section_id`=NULL":"`section_id`='".addslashes($_REQUEST['section_id'])."'";
$set[] = is_null($_REQUEST['price'])?"`price`=NULL":"`price`='".addslashes($_REQUEST['price'])."'";
$set[] = is_null($_REQUEST['is_showed'])?"`is_showed`=NULL":"`is_showed`='".addslashes($_REQUEST['is_showed'])."'";
$set[] = is_null($_REQUEST['dsc'])?"`dsc`=NULL":"`dsc`='".addslashes($_REQUEST['dsc'])."'";
$set[] = is_null($_REQUEST['extra'])?"`extra`=NULL":"`extra`='".addslashes($_REQUEST['extra'])."'";

			if(count($set)>0)
			{
				$set = implode(", ", $set);
				$sql = "UPDATE books SET $set WHERE id=?";
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
			qi("DELETE FROM books WHERE id=?", [$id]);
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
		
		if(isset2($_REQUEST['section_id_filter']))
		{
			$filters[] = "`section_id` = '{$_REQUEST['section_id_filter']}'";
		}
				

		if(isset2($_REQUEST['is_showed_filter']))
		{
			$filters[] = "`is_showed` = '{$_REQUEST['is_showed_filter']}'";
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
		$section_id_values = json_encode(q("SELECT name as text, id as value FROM sections", []));
				  $section_id_values_text = "";
			foreach(json_decode($section_id_values, true) as $opt)
			{
			  $section_id_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
			}
$is_showed_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
			$is_showed_values_text = "";
			foreach(json_decode($is_showed_values, true) as $opt)
			{
			  $is_showed_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
			}
				  
		
		$text_option = array_filter(json_decode($section_id_values, true), function($i)
		{
			return $i['value']==$_REQUEST['section_id_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['section_id_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='section_id_filter' value='{$_REQUEST['section_id_filter']}'>
					<span class='fa fa-times remove-tag'></span> Секция: <b>{$text_option}</b>
			</div>";

			$filter_caption = "Фильтры: ";
		}
				

		$text_option = array_filter(json_decode($is_showed_values, true), function($i)
		{
			return $i['value']==$_REQUEST['is_showed_filter'];
		});
		$text_option = array_values($text_option)[0]['text'];
		if(isset2($_REQUEST['is_showed_filter']))
		{
			$filter_divs .= "
			<div class='filter-tag'>
					<input type='hidden' class='filter' name='is_showed_filter' value='{$_REQUEST['is_showed_filter']}'>
					<span class='fa fa-times remove-tag'></span> Доступна: <b>{$text_option}</b>
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
				$srch = "WHERE ((`name` LIKE '%{$_REQUEST['srch-term']}%') or (`author` LIKE '%{$_REQUEST['srch-term']}%') or (`dsc` LIKE '%{$_REQUEST['srch-term']}%') or (`extra` LIKE '%{$_REQUEST['srch-term']}%'))";
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


		
				$default_sort_by = 'name';
				$default_sort_order = '';
			

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
			$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM (SELECT  main_table.*  FROM books main_table) temp $srch $filter $where $order LIMIT :start, :limit";
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
			$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM (SELECT main_table.*  FROM books main_table) temp $srch $filter $where $order";
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
	echo masterRender("Книги", $content, 4);

	
