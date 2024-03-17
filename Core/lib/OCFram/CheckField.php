<?php
namespace OCFram;

class CheckField extends Field
{
  protected $data;
  
  public function buildWidget()
  {
    $widget = '';
    
    if (!empty($this->errorMessage))
    {
      $widget .= $this->errorMessage.'<br />';
    }
    
    $widget .= '<label>'.$this->label.'</label><input type="checkbox" name="'.$this->name.'"';
    
	if($this->value)
		$widget .= ' checked ';
	
    return $widget .= ' value="true" />';
  }
  
  public function setData($data)
  {
    $this->data = $data;
  }
}