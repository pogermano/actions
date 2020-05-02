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
	private $scImage = NULL;
	private $image = Null;
	private $fontAweSome = NULL;
	private $text = NULL;
	private $toolBar = [];
	private $condition = TRUE;
	private $imageWidth = 20;
	private $itemSpace = '1px';

	function __construct($lineSeq)
	{
		$this->lineSeq = $lineSeq;
	}

	public function setContition($condition)
	{
		$this->condition = $condition;
	}

	public function setSCImage($imgTrue, $categTrue = 'grp,img', $imgFalse = NULL, $categFalse = 'grp,img')
	{
		//$categ = ['sys' => 'sys__NM__', 'prj' => 'grp__NM__ ', 'usr' => 'usr__NM__'];
		//$type =  ['bg' => 'sys__NM__', 'prj' => 'grp__NM__ ', 'usr' => 'usr__NM__'];
		$categ = explode(',', $categTrue);
		$imgTrue = strtoupper($categ[0]) . '__NM__' . strtoupper($categ[1]) . '__NM__' . $imgTrue;
		$this->item[0] = "<img src='../../../../img/$imgTrue' width={$this->imageWidth}/>";
		if (!is_null($imgFalse)) {
			$categ = explode(',', $categFalse);
			$imgFalse = strtoupper($categ[0]) . '__NM__' . strtoupper($categ[1]) . '__NM__' . $imgFalse;
			$this->item[1] = "<img src='../../../../img/$imgFalse' width={$this->imageWidth}/>";
		}

		$this->image = Null;
		$this->fontAweSome = NULL;
		$this->text = NULL;
	}

	public function setCondition($condition)
	{
		$this->condition = $condition;
	}

	public function close()
	{
		$this->tollBar[$this->id] = $this->item;
		$this->item = [];
		$this->image = Null;
		$this->fontAweSome = NULL;
		$this->text = NULL;
		$this->scImage = NULL;
		$this->id++;
	}

	public function createToolBars()
	{
		$html = '';
		foreach ($this->tollBar as $key => $value) {
			if ($this->condition) $html .= $value[0];
			else $html.= $value[1]
		}
		return $html;
	}
}
