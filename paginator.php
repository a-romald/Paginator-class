<?php

class Paginator
{
    /**
	 * set the number of items per page.
	 *
	 * @var numeric
	*/
	private $perPage;
    
    /**
	 * set get parameter for fetching the page number
	 *
	 * @var string
	*/
	private $instance;
    
    /**
	 * sets the page number.
	 *
	 * @var numeric
	*/
	private $page;
    
    /**
	 * set the total number of records/items.
	 *
	 * @var numeric
	*/
    private $totalRows;

    /**
	 * set the total number of pages.
	 *
	 * @var numeric
	*/
    private $totalPages;
    
    /**
	 * url path to pagination links.
	 *
	 * @var string
	*/
    private $path;

    /**
     *__construct
     * 
     * @param numeric  $_perPage  sets the number of iteems per page
	 * @param numeric  $_instance sets the instance for the GET parameter
	 */
    public function __construct($perPage=10, $instance = 'page'){
        $this->perPage = $perPage;
        $this->instance = $instance;
        $this->set_instance();
        $this->set_path();
    }
    
    /**
	 * set_instance
	 * 
	 * sets the instance parameter, if numeric value is 0 then set to 1
	 *
	 * @var numeric
	*/
	private function set_instance(){
		$this->page = (int) (!isset($_GET[$this->instance]) ? 1 : $_GET[$this->instance]); 
		$this->page = ($this->page == 0 ? 1 : $this->page);
    }
    
    /**
     * set_path
     * 
     * Define path to make links
     * @var string
     */
     private function set_path() {
            $url = $_SERVER['REQUEST_URI'];
            $pos1 = strpos($url, '?');
            if ($pos1) {
                $url = substr($url, 0, $pos1);
            }
            $this->path = $url;
     }
     
    /**
	 * set_total
     * 
     * Setter. Set total number of items
	 *
	 * collect a numberic value and assigns it to the totalRows
	 *
	 * @var numeric
	*/
	public function set_total($totalRows){
		$this->totalRows = $totalRows;
	}
    
    /**
	 * set_total_pages
     * 
     * Setter. Set total number of pages
	 *
	 * @var numeric
	*/
    private function set_total_pages() {
        // Находим общее число страниц
        $this->totalPages = (($this->totalRows - 1) / $this->perPage) + 1;
        $this->totalPages =  intval($this->totalPages);
        if($this->page > $this->totalPages) $this->page = $this->totalPages;
    }
    
    /**
	 * set_start
	 *
	 * creates the starting point for limiting the dataset
	 * @return numeric
	*/
	public function set_start(){
		return ($this->page * $this->perPage) - $this->perPage;
	}
    
    /**
	 * set_limit
	 *
	 * creates the expression LIMIT to include in sql-query
	 * @return string
	*/
    public function set_limit() {
        // следует выводить сообщения
        return "LIMIT ".$this->set_start().", $this->perPage";
    }
    
    
    /**
	 * get_links
	 *
	 * creates links for pagination in view
	 * @return string
	*/
    public function get_links($ext=null) {
        $this->set_total_pages();
        // Check if needed back-arrows
        if ($this->page != 1) $pervpage = '<a href='.$this->path.'?'.$this->instance.'=1'.$ext.'>First</a> <a href='.$this->path.'?'.$this->instance.'='. ($this->page - 1) .$ext.'> << </a> ';
        //  Check if needed forward-arrows
        if ($this->page != $this->totalPages) $nextpage = ' <a href='.$this->path.'?'.$this->instance.'='. ($this->page + 1) .$ext.'> >> </a> <a href='.$this->path.'?'.$this->instance.'='.$this->totalPages.$ext.'>Last</a>';
        
        // Find five closest pages if they exist
        if($this->page - 5 > 0) $page5left = ' <a href='.$this->path.'?'.$this->instance.'='. ($this->page - 5) .$ext.'>'. ($this->page - 5) .'</a> ';
        if($this->page - 4 > 0) $page4left = ' <a href='.$this->path.'?'.$this->instance.'='. ($this->page - 4) .$ext.'>'. ($this->page - 4) .'</a> ';
        if($this->page - 3 > 0) $page3left = ' <a href='.$this->path.'?'.$this->instance.'='. ($this->page - 3) .$ext.'>'. ($this->page - 3) .'</a> ';
        if($this->page - 2 > 0) $page2left = ' <a href='.$this->path.'?'.$this->instance.'='. ($this->page - 2) .$ext.'>'. ($this->page - 2) .'</a> ';
        if($this->page - 1 > 0) $page1left = '<a href='.$this->path.'?'.$this->instance.'='. ($this->page - 1) .$ext.'>'. ($this->page - 1) .'</a> ';
        
        if($this->page + 5 <= $this->totalPages) $page5right = ' <a href='.$this->path.'?'.$this->instance.'='. ($this->page + 5) .$ext.'>'. ($this->page + 5) .'</a>';
        if($this->page + 4 <= $this->totalPages) $page4right = ' <a href='.$this->path.'?'.$this->instance.'='. ($this->page + 4) .$ext.'>'. ($this->page + 4) .'</a>';
        if($this->page + 3 <= $this->totalPages) $page3right = ' <a href='.$this->path.'?'.$this->instance.'='. ($this->page + 3) .$ext.'>'. ($this->page + 3) .'</a>';
        if($this->page + 2 <= $this->totalPages) $page2right = ' <a href='.$this->path.'?'.$this->instance.'='. ($this->page + 2) .$ext.'>'. ($this->page + 2) .'</a>';
        if($this->page + 1 <= $this->totalPages) $page1right = ' <a href='.$this->path.'?'.$this->instance.'='. ($this->page + 1) .$ext.'>'. ($this->page + 1) .'</a>';
        
        // Output menu links if there are more than one page
        
        if ($this->totalPages > 1)
        {
        //error_reporting(E_ALL & ~E_NOTICE);
        error_reporting(0);
        echo "<div class=\"pstrnav\">";
        echo $pervpage.$page5left.$page4left.$page3left.$page2left.$page1left.'<b>'.$this->page.'</b>'.$page1right.$page2right.$page3right.$page4right.$page5right.$nextpage;
        echo "</div>";
        }
    }
    
}


?>