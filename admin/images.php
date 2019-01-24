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
			
   		$is_cover_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
			$is_cover_values_text = "";
			foreach(json_decode($is_cover_values, true) as $opt)
			{
			  $is_cover_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
			}
				  

		list($items, $pagination, $cnt) = get_data();

		$sort_order[$_REQUEST['sort_by']] = $_REQUEST['sort_order'];

$next_order['id']='asc';
$next_order['img']='asc';
$next_order['is_cover']='asc';

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
  				background-color: #F8F8F8;
			}
		</style>
		<div class="content-header">
			<div class="btn-wrap">
				<h2><a href="#" class="back-btn"><span class="fa fa-arrow-circle-left"></span></a> '."Изображения {$_REQUEST["book_name"]}".' </h2>
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
<th></th>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=id&sort_order='. ($next_order['id']) .'\' class=\'sort\' column=\'id\' sort_order=\''.$sort_order['id'].'\'>ID'. $sort_icon['id'].'</a>
			</th>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=img&sort_order='. ($next_order['img']) .'\' class=\'sort\' column=\'img\' sort_order=\''.$sort_order['img'].'\'>Изображение'. $sort_icon['img'].'</a>
			</th>

			<th>
				   <a href=\'?'.get_query().'&srch-term='.$_REQUEST['srch-term'].'&sort_by=is_cover&sort_order='. ($next_order['is_cover']) .'\' class=\'sort\' column=\'is_cover\' sort_order=\''.$sort_order['is_cover'].'\'>Обложка'. $sort_icon['is_cover'].'</a>
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
					<td style='width:1px;' class='sortable-handle'><i class='fas fa-bars'></i></td>
					".(function_exists("processTD")?processTD("<td>".htmlspecialchars($item['id'])."</td>", $item, "ID"):"<td>".htmlspecialchars($item['id'])."</td>")."
".(function_exists("processTD")?processTD("<td>
					". ($item['img']?"<a href='#' data-featherlight='{$item['img']}'>":"") ."
						<img class='' src='".($item['img']?$item['img']:"style/placeholder.jpg")."' style='max-width:200px; max-height:200px;' />
					". ($item['img']?"</a>":"") ."
				</td>", $item, "Изображение"):"<td>
					". ($item['img']?"<a href='#' data-featherlight='{$item['img']}'>":"") ."
						<img class='' src='".($item['img']?$item['img']:"style/placeholder.jpg")."' style='max-width:200px; max-height:200px;' />
					". ($item['img']?"</a>":"") ."
				</td>")."
".(function_exists("processTD")?processTD("<td><span class=' '>".renderRadioGroup("is_cover", $is_cover_values, "images", $item['id'], $item['is_cover'])."</td>", $item, "Обложка"):"<td><span class=' '>".renderRadioGroup("is_cover", $is_cover_values, "images", $item['id'], $item['is_cover'])."</td>")."
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
			$item = q("SELECT * FROM images WHERE id=?",[$id]);
			$item = $item[0];
		}

		$is_cover_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';

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
							<label class="control-label" for="textinput">Изображение</label>
							<div class="">
								<img src="'.$item["img"].'" style="max-width:200px; max-height:200px;" /><label for="img" class="file"> Выберите изображение <input type="file" name="img" id="img" /></label></div>
						</div>

					



            <div class="form-group">
              <label class="control-label" for="textinput">Обложка</label>
              <div class="" >'.renderEditRadioGroup("is_cover", $is_cover_values, $item["is_cover"]).'
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

		$is_cover_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';

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
							<label class="control-label" for="textinput">Изображение</label>
							<div class="">
								<img src="'.$item["img"].'" style="max-width:200px; max-height:200px;" /><label for="img" class="file"> Выберите изображение <input type="file" name="img" id="img" /></label></div>
						</div>

					



            <div class="form-group">
              <label class="control-label" for="textinput">Обложка</label>
              <div class="" >'.renderEditRadioGroup("is_cover", $is_cover_values, $item["is_cover"]).'
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
			$item = q("SELECT * FROM images WHERE id=?",[$id]);
			$item = $item[0];
		}
		else
		{
			die("Ошибка. Редактирование несуществующей записи (вы не указали id)");
		}

		$is_cover_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';


		$html = '
			<h1 style="line-height: 30px"> Редактирование <br /><small>'."Изображения {$_REQUEST["book_name"]}".' #'.$id.'</small></h1>
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
							<label class="control-label" for="textinput">Изображение</label>
							<div class="">
								<img src="'.$item["img"].'" style="max-width:200px; max-height:200px;" /><label for="img" class="file"> Выберите изображение <input type="file" name="img" id="img" /></label></div>
						</div>

					



            <div class="form-group">
              <label class="control-label" for="textinput">Обложка</label>
              <div class="" >'.renderEditRadioGroup("is_cover", $is_cover_values, $item["is_cover"]).'
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
			qi("UPDATE `images` SET `orderby` = ? WHERE id = ?", [$i, $line[$i]]);
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
		

								$img = $_FILES['img'];
								if(isset($img) && $img['name']!=="")
								{
									$ignore=0;
									@mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads');
									chmod($_SERVER['DOCUMENT_ROOT'].'/uploads',0777);
	                if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads'))
	                {
	                  die ("Не удается создать папку uploads в корневой директории. Создайте ее самостоятельно и предоставьте системе доступ к ней.");
	                }
	                $tm = time();
	                $ext = ".".pathinfo($img['name'], PATHINFO_EXTENSION);
									$target_file = $_SERVER['DOCUMENT_ROOT']."/uploads/".$tm."_".md5($img['name']).$ext;
									if(move_uploaded_file($img['tmp_name'], $target_file))
	                {
									    $img = "/uploads/".$tm."_".md5($img['name']).$ext;
	                }
	                else
	                {
	                    $set[] = "`img`=''";
	                    buildMsg("Не удается загрузить изображение. Попробуйте отправить файл меньшего размера.", "danger");
	                }
								}
	              else
	              {
	                $img="";
	              }


								
$is_cover = $_REQUEST['is_cover'];
$book_id = $_REQUEST['book_id'];

		$sql = "INSERT INTO images (`img`, `is_cover`, `book_id`) VALUES (?, ?, ?)";
		if(function_exists("processInsertQuery"))
		{
			$sql = processInsertQuery($sql);
		}

		qi($sql, [$img, $is_cover, $book_id]);
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

			

									$img = $_FILES['img'];
									if(isset($_FILES['img']) && $img['name']!=="")
									{
										$ignore=0;
										@mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads');
										chmod($_SERVER['DOCUMENT_ROOT'].'/uploads',0777);
		                if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads'))
		                {
		                  die ("Не удается создать папку uploads в корневой директории. Создайте ее самостоятельно и предоставьте системе доступ к ней.");
		                }
		                $tm = time();
		                $ext = ".".pathinfo($img['name'], PATHINFO_EXTENSION);
										$target_file = $_SERVER['DOCUMENT_ROOT']."/uploads/".$tm."_".md5($img['name']).$ext;
										if(move_uploaded_file($img['tmp_name'], $target_file))
		                {
										    $set[] = "`img`='".("/uploads/".$tm."_".md5($img['name'])).$ext."'";
		                }
		                else
		                {
		                    $set[] = "`img`=''";
		                    buildMsg("Не удается загрузить изображение. Попробуйте отправить файл меньшего размера.", "danger");
		                }
									}
		              else {
		                $img = "";
		              }

									
$set[] = is_null($_REQUEST['is_cover'])?"`is_cover`=NULL":"`is_cover`='".addslashes($_REQUEST['is_cover'])."'";
$set[] = is_null($_REQUEST['book_id'])?"`book_id`=NULL":"`book_id`='".addslashes($_REQUEST['book_id'])."'";

			if(count($set)>0)
			{
				$set = implode(", ", $set);
				$sql = "UPDATE images SET $set WHERE id=?";
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
			qi("DELETE FROM images WHERE id=?", [$id]);
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
		$is_cover_values = '[{"text":"Да", "value":"1"},{"text":"Нет", "value":"0"}]';
			$is_cover_values_text = "";
			foreach(json_decode($is_cover_values, true) as $opt)
			{
			  $is_cover_values_text.="<option value=\"{$opt['value']}\">{$opt['text']}</option>";
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

		$pagination = 0;
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


		
				$default_sort_by = 'orderby';
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
			$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM (SELECT  main_table.*  FROM images main_table) temp $srch $filter $where $order LIMIT :start, :limit";
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
			$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM (SELECT main_table.*  FROM images main_table) temp $srch $filter $where $order";
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
	echo masterRender("Изображения {$_REQUEST["book_name"]}", $content, 11);

	
