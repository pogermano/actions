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
	public $condition = FALSE;
	public $imageWidth = 20;

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
		$tagImg = "<img src='../../../../img/$imgTrue' width={$this->imageWidth}/>";
		if (!is_null($imgFalse)) {
			$categ = explode(',', $categFalse);
			$imgFalse = strtoupper($categ[0]) . '__NM__' . strtoupper($categ[1]) . '__NM__' . $imgFalse;
			$tagImg = [$imgTrue, "<img src='../../../../img/$imgFalse' width={$this->imageWidth}/>"];
		}

		$this->item = $tagImg;
		$this->image = Null;
		$this->fontAweSome = NULL;
		$this->text = NULL;
	}

	public function close()
	{
		$this->tollBar[$this->id] = $this->item;
		$this->item = NULL;
		$this->image = Null;
		$this->fontAweSome = NULL;
		$this->text = NULL;
		$this->scImage = NULL;
		$this->id++;
	}
}
