<?php
class helpApplication extends App
{
	function run()
	{
		parent::run();
		$data = $this->params;
		if(empty($data)) $data = 'help';
		$helptext = '';
		if(!is_file('data/docs/'.$data.'.txt'))
		{
			$helptext = 'No documentation for '.$data;	
		}
		else 
		{
			$helptext = file_get_contents('data/docs/'.$data.'.txt');
		}
		$this->outputResults($helptext,$_GET['environment']);
	}
}
?>