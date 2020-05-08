<?php
/* Classe iwActions
	Classe para criação de botões de ação nas linhas de uma Grid Scriptcase
	Autor: Haroldo B Passos / InfinitusWeb
	Copyrirght: 2020 / 2020 Versão: 1.01.001 
	Fase I : Versão Beta Teste  07/05/2020
	*/

class IWActions
{
	private $lineSeq;

	private $item = [];
	private $id = 0;
	private $condition = TRUE;
	private $imageHeight = 20;
	private $pathImage;
	private $pathAction;
	private $itemSpace = '2';
	private $toolBar = [];
	private $separator = false;
	private $imgSeparator = '';
	private $link = '';
	private $modal = false;
	private $modalStyle = 'max-width: 80%; width: 40%; background: rgb(0, 0, 0); padding: 5px; text-align: center; height: 80%';

	function __construct($lineSeq)
	{
		$this->lineSeq = $lineSeq;
		$dirs = $this->recursiveDir('../_lib/libraries');
		foreach ($dirs as $path) {
			$pos = strpos($path, 'actions-master');
			if (is_numeric($pos)) {
				break;
			}
		}
		$path = substr($path, 0,  $pos - 1);
		$this->pathImage = $path . '/img';
		$this->pathAction = $path . '/actions-master';
	}

	public function setCondition($condition)
	{
		$this->condition = $condition;
	}

	public function setSCImage($imgTrue, $categTrue = 'grp,img', $imgFalse = '', $categFalse = '')
	{
		$categ = explode(',', $categTrue);
		$categ[0] =  strtolower($categ[0]) == 'prj' ? 'grp' : strtolower($categ[0]);
		$imgTrue = $categ[0] . '__NM__' . strtolower($categ[1]) . '__NM__' . $imgTrue;
		$this->item[0] = $this->getSeparator() . "<img src='../_lib/img/$imgTrue' height='{$this->imageHeight}px' style='padding-right: {$this->itemSpace}px'/>";
		if (!empty($imgFalse)) {
			$categ = empty($categFalse) ? $categ : explode(',', $categFalse);
			$categ[0] =  strtolower($categ[0]) == 'prj' ? 'grp' : strtolower($categ[0]);
			$imgFalse = $categ[0] . '__NM__' . strtolower($categ[1]) . '__NM__' . $imgFalse;
			$this->item[1] = $this->getSeparator() . "<img src='../_lib/img/$imgFalse' height='{$this->imageHeight}px' style='padding-right: {$this->itemSpace}px'/>";
		}
	}

	public function setImage($imageTrue, $imageFalse = '')
	{
		$path = $this->pathImage . '/';
		$this->item[0] = $this->getSeparator() . "<img src='$path{$imageTrue}'  height='{$this->imageHeight}px' style='padding-right: {$this->itemSpace}px'/>";
		$this->item[1] = empty($imageFalse) ? '' : $this->getSeparator() . "<img src='.$path{$imageFalse}' height='{$this->imageHeight}px' style='padding-right: {$this->itemSpace}'/>";
	}

	public function setAwesome($fontAwesomeTrue, $colorTrue = '', $fontAwesomeFalse = '', $colorFalse = '')
	{
		$colorTrue = empty($colorTrue) ?: ";color:$colorTrue";
		$colorFalse = empty($colorFalse) ?: ";color:$colorFalse";
		$this->item[0]  = $this->getSeparator() . "<span style='font-size:{$this->imageHeight}px;  $colorTrue; padding-right: {$this->itemSpace}px'><i class='$fontAwesomeTrue'></i></span>";
		$this->item[1]  = $this->getSeparator() . "<span style='font-size:{$this->imageHeight}px;  $colorFalse; padding-right: {$this->itemSpace}px'><i class='$fontAwesomeFalse'></i></span>";
	}

	public function setImageHeight($imageHeight)
	{
		$this->imageHeight = $imageHeight;
	}

	public function setItemSpace($itemSpace)
	{
		$this->itemSpace = $itemSpace;
	}

	public function setText($textTrue, $textFalse = '')
	{
		$this->item[0] = $this->getSeparator() . "<span style='padding-right: {$this->itemSpace}px'>$textTrue</span>";
		$this->item[1] = $this->getSeparator() . "<span style='padding-right: {$this->itemSpace}px'>$textFalse</span>";
	}

	public function setSeparator($flag = 'light')
	{
		if ($flag) {
			$this->separator = $flag;
			$space = $this->itemSpace / 2;
			$this->itemSpace = 0;
			$image = $flag === 'dark' ? 'separator-dark.png' : 'separator-light.png';
			$this->imgSeparator = "<img src='{$this->pathAction}/img/$image' height='{$this->imageHeight}px' style='padding: 0px {$space}px;' />";
		} else {
			$this->imgSeparator = '';
		}
	}

	public function setLink($linkTrue, $linkFalse = '')
	{
		$this->link = ($this->condition) ? $linkTrue : $linkFalse;
	}

	public function setModal($flag = true)
	{
		$this->modal = $flag;
	}

	public function setModalStyle($value = '')
	{
		$p = $this->parsToObj($value, 'maxWidth=80%, width=40%,background=#000,padding=5px,textAlign=center,height=80%');
		$this->modalStyle = "max-width: {$p->maxWidth}; width:{$p->width};height:{$p->height};background:{$p->background};padding:{$p->padding};text-align:{$p->textAlign}";
		$this->modal = true;
	}

	private function getSeparator()
	{
		if ($this->id > 0) {
			return $this->imgSeparator;
		}
	}

	public function close()
	{
		if ($this->modal) {
			$a = "href=#login-form onclick=\"modalIframeSrc('{$this->link}');modalStyle('{$this->modalStyle}')\" rel=modal:open";
		} else {
			$a = "href = '{$this->link}'";
		}
		if ($this->link) {
			if ($this->condition) $this->item[0] = "<a class='action-link' $a>{$this->item[0]}</a>";
		} else {
			if ($this->condition) $this->item[1] = "<a class='action-link' $a'>{$this->item[1]}</a>";
		}
		$this->link = '';
		$this->toolBar[$this->id] = $this->item;
		$this->id++;
	}

	public function createToolBar()
	{
		$html = '';
		foreach ($this->toolBar as $value) {
			$html .= ($this->condition) ? $value[0] : $value[1];
		}
		return $html;
	}

	//By Anton Backer 2006 get_leaf_dirs($dir) 
	private function recursiveDir($dir)
	{
		$array = array();
		$d = dir($dir);
		while (false !== ($entry = $d->read())) {
			if ($entry != '.' && $entry != '..') {
				$entry = $dir . '/' . $entry;
				if (is_dir($entry)) {
					$subdirs = $this->recursiveDir($entry);
					if ($subdirs)
						$array = array_merge($array, $subdirs);
					else
						$array[] = $entry;
				}
			}
		}
		$d->close();
		return $array;
	}


	//Método Mágico -> permite utilizar parametros nomeados nos demais métodos da classe
	//By Haroldo
	private function parsToObj($pars, $default)
	{
		$pars = !empty($pars) ? explode(',', $pars) : [];
		$res = [];
		foreach ($pars as $value) {
			$arr = explode('=', $value);
			$arr[0] = trim($arr[0]);
			$arr[1] = trim($arr[1]);
			if (strpos($arr[1], ';')) {
				$arr[1] = explode(';', $arr[1]);
			}
			$res[$arr[0]] = $arr[1];
		}
		$pars = $res;
		$res = [];
		$default = explode(',', $default);
		foreach ($default as $value) {
			$arr = explode('=', $value);
			$arr[0] = trim($arr[0]);
			$arr[1] = trim($arr[1]);
			if (strpos($arr[1], ';')) {
				$arr[1] = explode(';', $arr[1]);
			}
			$res[$arr[0]] = $arr[1];
		}
		$json = json_encode(array_merge($res, $pars));
		return json_decode($json);
	}
}
