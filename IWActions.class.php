<?php
/* Classe iwActions
	Classe para criação de botões de ação nas linhas de uma Grid Scriptcase
	Autor: Haroldo B Passos / InfinitusWeb
	Copyrirght: 2020 / 2020 Versão: 1.00.004 
	Fase II : Versão Beta Teste 12/05/2020 1.01.005 ...
*/

class IWActions
{
	private $lineSeq;
	private $item = '';
	private $id = 0;
	private $condition = TRUE;
	private $imageHeight = 20;
	private $pathImage;
	private $pathAction;
	private $itemSpace = '2';
	private $color = '';
	private $textStyle = '';
	private $toolBar = [];
	private $toolTip = false;
	private $itemSeparator = "<div Style ='float: left; display: inline-block;padding-right: 2px'></div>";
	private $link = '';
	private $modal = false;
	private $modalStyle = 'max-width: 80%; width: 40%; background: rgb(0, 0, 0); padding: 5px; text-align: center; height: 80%';
	private $cursorClass = '';

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

	public function setItemSpace($itemSpace)
	{
		$this->itemSpace = $itemSpace;
		$this->itemSeparator = "<div Style ='float: left; display: inline-block;padding-right:{$this->itemSpace}px'></div>";
	}

	public function setSeparator($flag = 'light')
	{
		if ($flag) {
			$space = $this->itemSpace / 2;
			$image = $flag === 'dark' ? 'separator-dark.png' : 'separator-light.png';
			$this->itemSeparator = "<div Style = 'float: left; display: inline-block;'><img src='{$this->pathAction}/img/$image' height='{$this->imageHeight}px' style='padding: 0px {$space}px;' /></div>";
		} else {
			$this->itemSeparator = "<div Style ='float: left; display: inline-block;padding-right: {$this->itemSpace}px'></div>";
		}
	}

	public function setImageHeight($imageHeight)
	{
		$this->imageHeight = $imageHeight;
	}

	public function setCondition($condition)
	{
		$this->condition = $condition;
	}

	public function setColor($colorTrue, $colorFalse = '')
	{
		$this->color = ($this->condition) ? $colorTrue : $colorFalse;
	}

	public function setSCImage($imgTrue, $categTrue = 'grp,img', $imgFalse = '', $categFalse = '')
	{
		if ($this->condition) {
			$categ = explode(',', $categTrue);
			$image = $imgTrue;
		} else {
			$categ = empty($categFalse) ? explode(',', $categTrue) : explode(',', $categFalse);
			$image = $imgFalse;
		}
		if ($image) {
			$categ[0] =  strtolower($categ[0]) == 'prj' ? 'grp' : strtolower($categ[0]);
			$image = $categ[0] . '__NM__' . strtolower($categ[1]) . '__NM__' . $image;
			$this->item = "<img src='../_lib/img/$image' height='{$this->imageHeight}px'/>";
		}
	}

	public function setImage($imageTrue, $imageFalse = '')
	{
		$path = $this->pathImage . '/';
		$image = ($this->condition) ? $imageTrue : $imageFalse;
		if ($image) {
			$this->item = "<img src='$path{$image}'  height='{$this->imageHeight}px' />";
		}
	}

	public function setAwesome($fontAwesomeTrue, $fontAwesomeFalse = '')
	{
		$fontAwesome = ($this->condition) ? $fontAwesomeTrue : $fontAwesomeFalse;
		$color = ($this->color) ? 'color: ' . $this->color : '';
		$this->item  = "<span style='font-size:{$this->imageHeight}px;$color;'><i class='$fontAwesome'></i></span>";
	}

	public function setTextStyle($styleTrue, $styleFalse = '')
	{
		$this->textStyle = ($this->condition) ? $this->parsToStyle($styleTrue) : $this->parsToStyle($styleFalse);
	}

	public function setText($textTrue, $textFalse = '')
	{
		if ($this->textStyle) {
			$style = $this->textStyle;
		} else {
			$style = ($this->color) ? "style= 'color: {$this->color};'" : '';
		}
		$text = ($this->condition) ? $textTrue : $textFalse;
		if ($text) $this->item =  "<span $style>$text</span>";
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

	public function setCursor($cursorTrue = '', $cursorFalse = '')
	{
		$cursor = $this->condition ? $cursorTrue : $cursorFalse;
		$cursor = ($cursor) ? 'cursor:' . $cursor : '';
		if ($cursor) $this->cursorClass = $cursor;
	}

	public function setToolTipBottom()
	{
		$this->toolTip[1] = 'tooltiptext_bottom';
	}
	public function setToolTipLeft()
	{
		$this->toolTip[1] = 'tooltiptext_left';
	}

	public function setToolTip($hintTrue, $hintFalse = '')
	{
		$this->toolTip[1] = (isset($this->toolTip[1])) ? $this->toolTip[1] : 'tooltiptext';
		$hint = ($this->condition) ? $hintTrue : $hintFalse;
		$this->toolTip[0] = $hint;
	}

	public function close()
	{
		if ($this->link) {
			if ($this->modal) {
				$a = "href=#login-form onclick=\"modalIframeSrc('{$this->link}');modalStyle('{$this->modalStyle}')\" rel=modal:open";
			} else {
				$a = "href = '{$this->link}'";
			}
			$this->item = "<a class='action-link' $a>{$this->item}</a>";
		}

		if ($this->toolTip[0]) {
			$style = "Style = 'float: left; {$this->cursorClass}'";
			$this->item = "<div class='tooltip' $style>{$this->item}<span class='{$this->toolTip[1]}'>{$this->toolTip[0]}</span></div>";
		} else {
			$style = "Style = 'float: left; display: inline-block;{$this->cursorClass}'";
			$this->item = "<div $style>{$this->item}</div>";
		}

		$this->link = '';
		$this->cursorClass = '';
		$this->color = '';
		$this->textStyle = '';
		$this->toolTip = false;
		$this->toolBar[$this->id] = $this->item;
		$this->item = '';
		$this->id++;
	}

	private function setReset()
	{
		$this->item = '';
		$this->id = 0;
		$this->condition = TRUE;
		$this->imageHeight = 20;
		$this->itemSpace = '2';
		$this->toolBar = [];
		$this->separator = false;
		$this->imgSeparator = '';
		$this->color = '';
		$this->textStyle = '';
		$this->link = '';
		$this->toolTip = false;
		$this->modal = false;
		$this->modalStyle = 'max-width: 80%; width: 40%; background: rgb(0, 0, 0); padding: 5px; text-align: center; height: 80%';
		$this->cursorClass = '';
	}

	public function createToolBar()
	{
		$html = '';
		foreach ($this->toolBar as $key => $value) {
			$strip_tags = trim(strip_tags($value, '<img><i>'));
			$value = ($strip_tags) ? $value : '';
			$html .= ($key > 0 && !empty($value)) ? $this->itemSeparator . $value : $value;
		}
		$this->setReset();
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


	private function parsToStyle($style)
	{
		$style = 'style = ' . str_replace(['=', ','], [':', ';'], $style);
		return $style;
	}

	//Método Mágico -> permite utilizar parametros nomeados nos demais métodos da classe
	//By Haroldo
	private function parsToObj($pars, $default)
	{
		$pars = !empty($pars) ? explode(',', $pars) : [];
		$res = [];
		foreach ($pars as $value) {
			$arr = explode('=', $value);
			if (is_numeric(strpos($arr[0], '-'))) {
				$atr = explode('-', $arr[0]);
				$arr[0] = $atr[0] . ucfirst($atr[1]);
			}
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
