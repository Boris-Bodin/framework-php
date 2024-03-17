<?php
namespace OCFram;

class SelectField extends Field
{
  protected $data;
  
  public function buildWidget()
  {
    $widget = '';
    
    if (!empty($this->errorMessage))
    {
      $widget .= $this->errorMessage.'<br />';
    }
    
    $widget .= '<label>'.$this->label.'</label><select name="'.$this->name.'"';
    
    if (!empty($this->data))
    {
      foreach ($this->data as $item)
	  {
		if($this->value == $item['id'] ||$this->value == $item['label'])
			$widget .= '<option value="'.$item['id'].'" selected>'.$item['label'].'</option>';
		else
			$widget .= '<option value="'.$item['id'].'">'.$item['label'].'</option>';
	  }
    }
    
    return $widget .= '</select>';
  }
  
  public function setData($data)
  {
    $this->data = $data;
  }
}