<?php
/* Classe iwActions
	Classe para criação de botões de ação nas linhas de uma Grid Scriptcase
	Autor: Haroldo B Passos / InfinitusWeb
	Copyrirght: 2020 / 2020 Versão: 1.01.001 
	
	*/

class IWActions
{
	private $lineSeq;

	private $item = [];
	private $id = 0;
	private $condition = TRUE;
	private $imageWidth = 20;
	private $itemSpace = '1px';
	private $toolBar = [];


	function __construct($lineSeq)
	{
		$this->lineSeq = $lineSeq;
	}

	public function setContition($condition)
	{
		$this->condition = $condition;
	}

	public function setSCImage($imgTrue, $categTrue = 'grp,img', $imgFalse = '', $categFalse = 'grp,img')
	{
		$categ = empty($categ) ? ['grp', 'img'] : explode(',', $categTrue);
		$categ[0] =  strtolower($categ[0]) == 'prj' ? 'grp' : strtolower($categ[0]);
		$imgTrue = $categ[0] . '__NM__' . strtolower($categ[1]) . '__NM__' . $imgTrue;
		$this->item[0] = "<img src='../_lib/img/$imgTrue' width='{$this->imageWidth}px' />";
		if (!empty($imgFalse)) {
			$categ = empty($categ) ? ['grp', 'img'] : explode(',', $categFalse);
			$categ[0] =  strtolower($categ[0]) == 'prj' ? 'grp' : strtolower($categ[0]);
			$imgFalse = $categ[0] . '__NM__' . strtolower($categ[1]) . '__NM__' . $imgFalse;
			$this->item[1] = "<img src='../_lib/img/$imgFalse' width='{$this->imageWidth}px' />";
		}
	}

	public function setImage($imageTrue, $imageFalse = '', $path = 'grp')
	{
		$path = strtolower($path) == 'prj' ? 'grp' : strtolower($path);
		$this->item[0] = "<img src='../_lib/libraries/$path/actions/img/$imageTrue'  width='{$this->imageWidth}px' />";
		$this->item[1] = "<img src='../_lib/libraries/$path/actions/img/$imageFalse' width='{$this->imageWidth}px' />";
	}

	public function setAwesome($fontAwesomeTrue, $colorTrue = '', $fontAwesomeFalse = '', $colorFalse = '')
	{
		$colorTrue = empty($colorTrue) ?: ";color:$colorTrue";
		$colorFalse = empty($colorFalse) ?: ";color:$colorFalse";
		$this->item[0]  = "<span style='fontsize:{$this->imageWidth}px  $colorTrue'><i class='$fontAwesomeTrue'></i></span>";
		$this->item[1]  = "<span style='fontsize:{$this->imageWidth}px  $colorFalse'><i class='$fontAwesomeFalse'></i></span>";
	}

	public function setCondition($condition)
	{
		$this->condition = $condition;
	}

	public function setImageWidth($imageWidth)
	{
		$this->imageWidth = $imageWidth;
	}

	public function setItemSpace($itemSpace)
	{
		$this->itemSpace = $itemSpace;
	}

	public function setText($textTrue, $textFalse = '')
	{
		$this->item[0] = $textTrue;
		$this->item[1] = $textFalse;
	}

	public function close()
	{
		$this->tollBar[$this->id] = $this->item;
		$this->id++;
	}

	public function createToolBar()
	{
		$html = '';
		//echo "CreateToobar<br>";
		foreach ($this->tollBar as $value) {
			echo "<pre>";
			print_r($value);
			echo "</pre>";
			$html .= ($this->condition) ? $value[0] : !isset($value[1]) ? '' : $value[1];
		}
		return $html;
	}
}
