<?php

/**
 * @author agriboed
 * @copyright 2015
 * @url http://v1rus.ru
 * @email alexv1rs@gmail.com
 */

class cWordReplacer
{
    public static $MODULE_ID = "wordreplacer";

    private function getFile()
    {
        return $_SERVER['DOCUMENT_ROOT'] .
            '/bitrix/modules/wordreplacer/cache/cache.csv';
    }
    public function getLink()
    {
        return '/bitrix/modules/wordreplacer/cache/cache.csv';
    }
    public function getChanged()
    {
        if (!is_file(self::getFile()))
            return '-';

        $changed = date("d.m.Y H:i:s", filemtime(self::getFile()));
        return $changed;
    }
    public function replace($common_text)
    {

        $words_all = self::getWords();


        $url = $_SERVER["REQUEST_URI"]; //получаем урл
        $args = '?' . $_SERVER["QUERY_STRING"]; //получаем запрос
        $clear_url = str_replace($args, "", $url);


        $alias = array(
            $url,
            "http://" . $_SERVER['SERVER_NAME'] . $url,
            $_SERVER['SERVER_NAME'] . $url,
            "http://www." . $_SERVER['SERVER_NAME'] . $url,
            "https://www." . $_SERVER['SERVER_NAME'] . $url,
            "https://" . $_SERVER['SERVER_NAME'] . $url,
            $clear_url,
            "http://" . $_SERVER['SERVER_NAME'] . $clear_url,
            $_SERVER['SERVER_NAME'] . $clear_url,
            "http://www." . $_SERVER['SERVER_NAME'] . $clear_url,
            "https://www." . $_SERVER['SERVER_NAME'] . $clear_url,
            "https://" . $_SERVER['SERVER_NAME'] . $clear_url,
            );


        foreach ($words_all as $row) {
			$common_text = $row['txt'].$row['desc'].$row['url'].$row['url_prod'];
            /*foreach ($words as $word) {

                if (!in_array($row['url'], $alias))
                    $common_text = preg_replace("#(\#\n|\s|^|\,|\.|\r|\)|\()(" . str_replace(" ", "\s",
                        $word) . ")(\n|\?|\s|$|\.|\,|\r|\)|\(\#)#" . $params, '$1<a href="' . trim($row['url']) .
                        '">$2</a>$3', $common_text, 1);

            }*/
        }
        return $common_text;
    }

    public function getWords($file = '')
    {

        if (!$file)
            $file = self::getFile();

        if (!file_exists($file))
            return array();

        $content = file($file);

        if (empty($content))
            return array();


        $aFile = array();

        foreach ($content as $str) {
            $return = '';
            $str = trim($str);

            $temp = explode(";", $str);

            if (!empty($temp)) {
                $return['txt'] = $temp[0];
				$return['desc'] = $temp[1];
				$return['url'] = $temp[2];
				$return['url_prod'] = $temp[3];
                //unset($temp[0]);
                //$return['words'] = $temp;
            }

            $aFile[] = $return;
        }
        return $aFile;
    }

    public function writeCache($cache)
    {

        if ($cache) {
            $file = fopen(self::getFile(), "w");

            foreach ($cache as $str) {

                $words = '';
                foreach ($str['words'] as $word) {
                    if ($word)
                        $words .= ';' . $word;
                }
                if ($str['url'])
                    fwrite($file, $str['url'] . $words . PHP_EOL);
            }
            fclose($file);
        }
    }
}

?>