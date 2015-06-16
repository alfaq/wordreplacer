<?
$module_id = "wordreplacer";
$POST_RIGHT = $APPLICATION->GetGroupRight($module_id);
if($POST_RIGHT>="R"):
CModule::IncludeModule("wordreplacer");
CJSCore::Init(array("jquery")); ?>
<style>
#LR #developer_help, #LR #seo_help, #import {
    display: none;
}
#LR table {
    width: 100%;
    border-spacing: 0;
}
#LR table  td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
	width: 25%;
}
#LR table th {
padding: 15px;
background: linear-gradient(to bottom, #FFFFFF,#E5E5E5);
}
#LR h2 a {
    text-decoration: none;
    border-bottom: 1px dotted;
}
#LR input[type=text] {
    width: 90%;
}

#LR textarea{
    width: 90%;
	min-height: 80px;
}
#LR .message {
font-weight: bold;
text-align: center;
font-size: 20px;
border: 1px solid #ddd;
width: 40%;
margin: 20px auto;
padding: 10px;
background: linear-gradient(to bottom,#fff,#f2f2f2);
}
</style>
<h1>Настройка модуля WordRreplacer</h1>
<div id="LR">
<?
if (isset($_FILES['file'])) {
    if (is_uploaded_file($_FILES["file"]["tmp_name"])) {
        $cache = cWordReplacer::getWords($_FILES["file"]["tmp_name"]);
        cWordReplacer::writeCache($cache);
        echo "<div class=message>Файл загружен</div>";
    }
}

if (isset($_POST['post'])) {
    echo "<div class=message>Сохранено</div>";
    cWordReplacer::writeCache($_POST['post']);
}

$words = cWordReplacer::getWords();
$i = 0;
?>

<form action="" method="post">
<table>
<th>Текст</th><th>Краткое описание</th><th>Ссылка</th><th>Ссылка на каталог</th>
<? if ($words):?>
<?
foreach ($words as $str) {
    echo "<tr>
		<td><input type='text' name='post[$i][txt]' value='" . $str['txt']. "'></td>
		<td><textarea name='post[<?=$i?>][desc]'>" . $str['desc']. "</textarea>
		<td><input type='text' name='post[$i][url]' value='" . $str['url']. "'></td>
		<td><input type='text' name='post[$i][url_prod]' value='" . $str['url_prod']. "'></td>
		</tr>";
    /*foreach ($str['words'] as $word) {
        echo "<input type='text' name='post[$i][words][]' value='" . $word . "'><br>";
    }
    echo "<div id='addInput$i'></div><a href='#' onclick='addInput($i);return false'>добавить</a></td></tr>";
	*/
    $i++;
}
?>
<?endif;?>
<tr>
<td><input type='text' name='post[<?=$i?>][txt]' value=''></td>
<td><textarea name='post[<?=$i?>][desc]'></textarea>
<td><input type='text' name='post[<?=$i?>][url]' value=''></td>
<td><input type='text' name='post[<?=$i?>][url_prod]' value=''></td>
</td>
</tr>
<tr>
<td><input type='text' name='post[<?=$i+1?>][txt]' value=''></td>
<td><textarea name='post[<?=$i+1?>][desc]'></textarea>
<td><input type='text' name='post[<?=$i+1?>][url]' value=''></td>
<td><input type='text' name='post[<?=$i+1?>][url_prod]' value=''></td>
</td>
</tr>
<tr>
<td><input type='text' name='post[<?=$i+2?>][txt]' value=''></td>
<td><textarea name='post[<?=$i+2?>][desc]'></textarea>
<td><input type='text' name='post[<?=$i+2?>][url]' value=''></td>
<td><input type='text' name='post[<?=$i+2?>][url_prod]' value=''></td>
</td>
</tr>
<tr>
	<td colspan="2">Заполнено слов: <?=$i-3;?></td>
	<td colspan="2">Изменено: <?=cWordReplacer::getChanged()?></td>
</tr>
<tr><td style="text-align: right;" colspan="4"><input type="submit" class="adm-btn-save" value="Сохранить">  <input type="reset" value="Отменить"></td></tr>
</table>
</form>


    <h2><a href="<?= cWordReplacer::getLink(); ?>" target=_blank>Скачать файл</a></h2>
    <h2><a href="#" onclick="$('#import').toggle('slow');return false;">Импортировать файл</a></h2>
<div id="import">
Формат файла для импорта:<br />
<ul>
<li>расширение файла <b>.CSV</b></li>
<li>кодировка файла <b>UTF-8</b></li>
<li>разделите столбцов <b>;</b></li>
<li><b>первый столбец</b> содержит ссылку</li>
<li>все <b>последующие столбцы</b> содержат ключевые слова</li>
</ul>
<p>
Пример файла:<br><br>
<b>http://site.ru/adapter/;Адаптер;адаптер;адаптер беспроводной;</b>
</p>

<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="file">
<input type="submit" value="Загрузить">
    </form>
  <p> <b>Внимание!</b> Все текущие изменения будут заменены.</p>
</div>
    <h2><a href="#" onclick="$('#seo_help').toggle('slow');return false;">Информация по редактированию</a></h2>
<div id="seo_help">
<p>Добавляйте ключевые слова, которые нужно изменить на ссылки при выводе текста на сайте. Старайтесь использовать первыми длинные связки слов <i>"адаптер беспроводной связи"</i>, затем <i>"адаптер беспроводной"</i>, и в последнюю очередь конкретное слово <i>"адаптер"</i>.</p>
<p>Таким образом скрипт сначала найдет первое вхождение и заменит его, в противном случае продолжит поиск второго вхождения и т.д. Если разместить первым в списке <i>"адаптер"</i>, а затем <i>"адаптер беспроводной"</i>, то при выводе в тексте скрипт найдет первое вхождение и заменит ТОЛЬКО его, а "беспроводной" на ссылку исправлено не будет.</p>
<p>Для <b>удаления</b> ключевого слова, либо ссылки целиком - просто оставьте поле пустым</p>
<p>Ключевые слова <b>чуствительны к регистру</b></p>
</div>
    <h2><a href="#" onclick="$('#developer_help').toggle('slow');return false;">Для разработчиков</a></h2>
<div id="developer_help">
<p>Чтобы включить модуль, к примеру, в компоненте <b>bitrix.news</b>, создайте в папке news.detail этого шаблона файл result_modifier.php.</p>
<p>Добавить следующий код:</p>
<p>
<b>&lt;?php<br />
if (CModule::IncludeModule("wordreplacer"))<br />
{<br />
 $arResult['DETAIL_TEXT'] = cWordReplacer::replace($arResult['DETAIL_TEXT']);
<br />}<br />
?&gt;</b></p>
<p>Таким образом, модуль сможет модифицировать содержимое $arResult['DETAIL_TEXT'] перед выводом и заменить все вхождения на ссылки.</p>
</div>
</div>
<script>
/*function addInput(id) {
    $('#addInput'+id).append('<input type="text" name="post['+id+'][words][]" value="">');
}*/
$('.message').delay(5000).hide('slow');
</script>
<?endif;?>