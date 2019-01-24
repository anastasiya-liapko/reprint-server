<?php
	include "engine/core.php";
	

	class GLOBAL_STORAGE
	{
	   static $parent_object;
	}
	GLOBAL_STORAGE::$parent_object = q1('SELECT * FROM books WHERE id = ?', ["{$_REQUEST["book_id"]}"]);

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
			
   		$cover_id_values = json_encode(q("SELECT name as text, id as value FROM covers", []));
				  $cover_id_values_text = "";
			foreach(json_decode($cover_id_values, true) as $opt)
			{
			  $cover_id_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
			}
$is_default_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
			$is_default_values_text = "";
			foreach(json_decode($is_default_values, true) as $opt)
			{
			  $is_default_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
			}
				  

		list($items, $pagination, $cnt) = get_data();

		$sort_order[$_REQUEST['sort_by']] = $_REQUEST['sort_order'];

$next_order['id']='asc';
$next_order['cover_id']='asc';
$next_order['price']='asc';
$next_order['is_default']='asc';

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
					$(\'.big-icon\').html(\'<i class="fas fa-"></i>\');
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
				<h2><a href="#" class="back-btn"><span class="fa fa-arrow-circle-left"></span></a> '."Переплеты для {$_REQUEST["book_name"]}".' </h2>
				<button class="btn blue-inline add_button" data-toggle="modal" data-target="#modal-main">ДОБАВИТЬ</button>
				<p class="small res-cnt">Кол-во результатов: <span class="cnt-number-span">'.$cnt.'</span></p>
			</div>
			
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
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=cover_id&sort_order='. ($next_order['cover_id']) .'\' class=\'sort\' column=\'cover_id\' sort_order=\''.$sort_order['cover_id'].'\'>Наименование'. $sort_icon['cover_id'].'</a>
			</th>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=price&sort_order='. ($next_order['price']) .'\' class=\'sort\' column=\'price\' sort_order=\''.$sort_order['price'].'\'>Цена'. $sort_icon['price'].'</a>
			</th>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=is_default&sort_order='. ($next_order['is_default']) .'\' class=\'sort\' column=\'is_default\' sort_order=\''.$sort_order['is_default'].'\'>Оригинал'. $sort_icon['is_default'].'</a>
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
".(function_exists("processTD")?processTD("<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($cover_id_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=book_covers' data-pk='{$item['id']}' data-name='cover_id'>".select_mapping($cover_id_values, $item['cover_id'])."</span></td>", $item, "Наименование"):"<td><span class='editable ' data-inp='select' data-type='select' data-source='".htmlspecialchars($cover_id_values, ENT_QUOTES, 'UTF-8')."' data-url='engine/ajax.php?action=editable&table=book_covers' data-pk='{$item['id']}' data-name='cover_id'>".select_mapping($cover_id_values, $item['cover_id'])."</span></td>")."
".(function_exists("processTD")?processTD("<td><span class='editable ' data-placeholder='' data-inp='decimal' data-url='engine/ajax.php?action=editable&table=book_covers' data-pk='{$item['id']}' data-name='price'>".htmlspecialchars($item['price'])."</span></td>", $item, "Цена"):"<td><span class='editable ' data-placeholder='' data-inp='decimal' data-url='engine/ajax.php?action=editable&table=book_covers' data-pk='{$item['id']}' data-name='price'>".htmlspecialchars($item['price'])."</span></td>")."
".(function_exists("processTD")?processTD("<td><span class=' '>".renderRadioGroup("is_default", $is_default_values, "book_covers", $item['id'], $item['is_default'])."</td>", $item, "Оригинал"):"<td><span class=' '>".renderRadioGroup("is_default", $is_default_values, "book_covers", $item['id'], $item['is_default'])."</td>")."
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
			$item = q("SELECT * FROM book_covers WHERE id=?",[$id]);
			$item = $item[0];
		}

		
			$cover_id_options = q("SELECT name as text, id as value FROM covers",[]);
			$cover_id_options_html = "";
			foreach($cover_id_options as $o)
			{
				$cover_id_options_html .= "<option value=\"{$o['value']}\" ".($o["value"]==$item["cover_id"]?"selected":"").">{$o['text']}</option>";
			}
		
$is_default_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';

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
				<label class="control-label" for="textinput">Наименование</label>
				<div>
					<select id="cover_id" name="cover_id" class="form-control input-md " >
						'.$cover_id_options_html.'
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
              <label class="control-label" for="textinput">Оригинал</label>
              <div class="" >'.renderEditRadioGroup("is_default", $is_default_values, $item["is_default"]).'
              </div>
            </div>

          

					<input id="book_id" name="book_id" type="hidden" value="'.htmlspecialchars("{$_REQUEST["book_id"]}").'">
		
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

		
			$cover_id_options = q("SELECT name as text, id as value FROM covers",[]);
			$cover_id_options_html = "";
			foreach($cover_id_options as $o)
			{
				$cover_id_options_html .= "<option value=\"{$o['value']}\" ".($o["value"]==$item["cover_id"]?"selected":"").">{$o['text']}</option>";
			}
		
$is_default_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';

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
				<label class="control-label" for="textinput">Наименование</label>
				<div>
					<select id="cover_id" name="cover_id" class="form-control input-md " >
						'.$cover_id_options_html.'
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
              <label class="control-label" for="textinput">Оригинал</label>
              <div class="" >'.renderEditRadioGroup("is_default", $is_default_values, $item["is_default"]).'
              </div>
            </div>

          

					<input id="book_id" name="book_id" type="hidden" value="'.htmlspecialchars("{$_REQUEST["book_id"]}").'">
		
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
			$item = q("SELECT * FROM book_covers WHERE id=?",[$id]);
			$item = $item[0];
		}
		else
		{
			die("Ошибка. Редактирование несуществующей записи (вы не указали id)");
		}

		
			$cover_id_options = q("SELECT name as text, id as value FROM covers",[]);
			$cover_id_options_html = "";
			foreach($cover_id_options as $o)
			{
				$cover_id_options_html .= "<option value=\"{$o['value']}\" ".($o["value"]==$item["cover_id"]?"selected":"").">{$o['text']}</option>";
			}
		
$is_default_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';


		$html = '
			<h1 style="line-height: 30px"> Редактирование <br /><small>'."Переплеты для {$_REQUEST["book_name"]}".' #'.$id.'</small></h1>
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
				<label class="control-label" for="textinput">Наименование</label>
				<div>
					<select id="cover_id" name="cover_id" class="form-control input-md " >
						'.$cover_id_options_html.'
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
              <label class="control-label" for="textinput">Оригинал</label>
              <div class="" >'.renderEditRadioGroup("is_default", $is_default_values, $item["is_default"]).'
              </div>
            </div>

          

					<input id="book_id" name="book_id" type="hidden" value="'.htmlspecialchars("{$_REQUEST["book_id"]}").'">
		

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
			qi("UPDATE `book_covers` SET `` = ? WHERE id = ?", [$i, $line[$i]]);
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
		$cover_id = $_REQUEST['cover_id'];
$price = $_REQUEST['price'];
$is_default = $_REQUEST['is_default'];
$book_id = $_REQUEST['book_id'];

		$sql = "INSERT INTO book_covers (`cover_id`, `price`, `is_default`, `book_id`) VALUES (?, ?, ?, ?)";
		if(function_exists("processInsertQuery"))
		{
			$sql = processInsertQuery($sql);
		}

		qi($sql, [$cover_id, $price, $is_default, $book_id]);
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

			$set[] = is_null($_REQUEST['cover_id'])?"`cover_id`=NULL":"`cover_id`='".addslashes($_REQUEST['cover_id'])."'";
$set[] = is_null($_REQUEST['price'])?"`price`=NULL":"`price`='".addslashes($_REQUEST['price'])."'";
$set[] = is_null($_REQUEST['is_default'])?"`is_default`=NULL":"`is_default`='".addslashes($_REQUEST['is_default'])."'";
$set[] = is_null($_REQUEST['book_id'])?"`book_id`=NULL":"`book_id`='".addslashes($_REQUEST['book_id'])."'";

			if(count($set)>0)
			{
				$set = implode(", ", $set);
				$sql = "UPDATE book_covers SET $set WHERE id=?";
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
			qi("DELETE FROM book_covers WHERE id=?", [$id]);
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
		$cover_id_values = json_encode(q("SELECT name as text, id as value FROM covers", []));
				  $cover_id_values_text = "";
			foreach(json_decode($cover_id_values, true) as $opt)
			{
			  $cover_id_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
			}
$is_default_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
			$is_default_values_text = "";
			foreach(json_decode($is_default_values, true) as $opt)
			{
			  $is_default_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
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
		

		$filter = filter_query($srch);
		$where = "book_id={$_REQUEST["book_id"]}";
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


		
				$default_sort_by = '';
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
			$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM (SELECT  main_table.*  FROM book_covers main_table) temp $srch $filter $where $order LIMIT :start, :limit";
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
			$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM (SELECT main_table.*  FROM book_covers main_table) temp $srch $filter $where $order";
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
	echo masterRender("Переплеты для {$_REQUEST["book_name"]}", $content, 6);

	
