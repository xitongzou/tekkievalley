<?php

//begin myXMLnode class
class myXMLnode {

	var $name;
	var $attributes;
	var $children;
	var $value;
	var $countvalue;

//------------------------------------------------------------------------------
// constructor myXMLnode
//------------------------------------------------------------------------------
	function myXMLnode( $xml_name, $xml_attributes ) {

		 $this->name		= $xml_name			;
		 $this->attributes	= $xml_attributes	;
		 $this->children 	= array()			;
		 $this->value		= array()			;
		 $this->countvalue	= 0					;

	}

//------------------------------------------------------------------------------
// pushvalue
//------------------------------------------------------------------------------
	function pushvalue( $xml_value ) 
	{
		$this->value[$this->countvalue++] = $xml_value;		
	}	
	
//------------------------------------------------------------------------------
// getvalue
//------------------------------------------------------------------------------
	function getvalue($delim = "\n") 
	{
	 if( $this->countvalue==0 ) return "";
	 if( $this->countvalue==1 ) return $this->value[0];	
	 
	 return join($delim, $this->value);
	}
	
}
//end myXMLnode class
  
  

//------------------------------------------------------------------------------
//--------------	myXML	----------------------------------------------------
//------------------------------------------------------------------------------
//begin myXML class
class myXML {

 var $root;
 var $parentnode;
 var $childnode;
 var $depth;
 var $stack_i;
//------------------------------------------------------------------------------
// constructor myXML
//------------------------------------------------------------------------------
	function myXML( $xml_doc ) {
	
		
		$this->childnode = array();
		$this->depth = 0;
		
		for($i=0;$i<100;$i++) {
			$this->stack_i[$i] = 0;
		}	
		
		    $xml_parser = xml_parser_create();
		    xml_set_object($xml_parser,$this);
			xml_parser_set_option($xml_parser , XML_OPTION_SKIP_WHITE   , 1 );
		    xml_parser_set_option($xml_parser , XML_OPTION_CASE_FOLDING , 1 );
		    xml_set_element_handler($xml_parser, "begNode", "endNode");
		    xml_set_character_data_handler($xml_parser, "characterData");
		
		    if (!xml_parse($xml_parser, $xml_doc)) {
		        die(sprintf("XML error: %s at line %d\n",
		                    xml_error_string(xml_get_error_code($xml_parser)),
		                    xml_get_current_line_number($xml_parser)));
		    }		
			
			xml_parser_free($xml_parser);
			
			$this->root = $this->parentnode[0];
			
			$this->parentnode = array();
			$this->childnode = array();
			$this->stack_i = array();
			unset ( $this->depth );
			unset ( $this->stack_i );
	}

function begNode( $parser, $name, $attribs ) {
	
	$curnode = new myXMLnode( $name , $attribs );
	$this->parentnode[$this->depth] = &$curnode;
	$this->childnode[$this->depth][$this->stack_i[$this->depth]++] = &$curnode;
	$this->depth++;
}

function endNode( $parser, $name ) {

	$this->depth--;
	$this->parentnode[$this->depth]->children = $this->childnode[$this->depth+1];
	$this->stack_i[$this->depth+1]=0;
	unset($this->childnode[$this->depth+1]);
}
 
function characterData( $parser, $data ) {
		if ( trim($data)!="" ) 
		{
		    $this->parentnode[$this->depth-1]->pushvalue($data);
		}	
}
}//end myXML class

?>