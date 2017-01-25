<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_Pagination{
	var $req_page;				// HOLD THE PAGE NAME WHOSE PAGINATION IS DONE
	var $no_of_records;			// HOLD TOTAL NUMBER OF RECORDS
	var $no_of_pages;			// HOLD NUMBER OF PAGES
	var $current_page;			// HOLD THE CURRENT OPENED PAGE NUMBER
	var $CI;
	
	
	// CONSTRUCTOR TO ASSING CURRENT PAGE URL AND TO SET CURRENT PAGE NUMBER
	function CI_Pagination(){
		$this->CI =& get_instance();
		
		$this->req_page = $this->CI->config->item('base_url').substr($_SERVER["REQUEST_URI"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);	// ASSIGN OPENED PAGE NAME
		//echo $this->req_page = $this->agent->referrer();
		
		if(!$this->req_page)
			$this->req_page = 'index.php';
			
		if(isset($_GET['page'])){
			$this->current_page = $_GET['page'];
			$this->req_page = substr($this->req_page,0,strrpos($this->req_page,"page")-1);
		}
		else
			$this->current_page = 1;
		if(strrpos($this->req_page,"?"))
			$this->req_page .= "&";
		else
			$this->req_page .= "?";
	}
	
	// FUNCTION USED TO GET NUMBER OF PAGES AND SEND BACK THE LIMIT TO BE USED
	function limit($total_rows, $page_limit = 15){
		$this->no_of_records = $total_rows;
		$this->no_of_pages = ceil($total_rows / $page_limit);
		if($this->no_of_pages < $this->current_page)
			$this->current_page = 1;
		if($this->current_page==1){
			$start_limit = 0;
		}
		else{
			$page = $this->current_page;
			$start_limit = $page * $page_limit - $page_limit;
		}
		$query = " LIMIT ".$start_limit." , ".$page_limit;
		return $query;
	}
	
	// FUNCTION TO SHOW THE LINKS TO ALL PAGES ACCORDING TO VARIABLE PASSED TO IT
	function links($show_links = 6){
		// SET IF LINKS TO SHOW ARE MORE THAN THE TOTAL NO OF PAGES
		if($show_links > $this->no_of_pages)
			$show_links = $this->no_of_pages;

		$inc = ceil($show_links / 2) - 1;
		$i_start = 1;																				// VARIABLE USED TO START LOOP
		$i_end = $show_links;																		// VARIABLE USED TO END LOOP
		if($i_end > 1){
			if($inc < $this->current_page && $show_links != $this->no_of_pages){						// IS EXECUTED IF PAGED OPENED IS GREATER THE HALF OF THE LINKS SHOWN ON PAGE
				$i_start = $this->current_page - $inc;
				$i_end = $i_start + $show_links - 1;
				if($this->current_page+$inc >= $this->no_of_pages){										// IS EXECUTED TO CONTROL EXTRA SHOWN LINKS AFTER THE LAST PAGE
					$i_end = $this->no_of_pages;
				}
			} ?>
			<table id="pagination" cellspacing="1" cellpadding="0">
				<tr>
					<?php //if($this->current_page > $inc + 1 && $show_links != $this->no_of_pages){
																									// LINK TO LAST PAGE SHOWN ON PAGES AFTER HALF OF LINKS SHOWN FROM FIRST PAGE
					?>
					<td><?php echo '<a href="'.$this->req_page.'page=1">&lt; First</a>'; ?></td>
					<?php //}			
						for($i=$i_start; $i<=$i_end; $i++){											// MAIN LISTED LINKS
							if($i == $this->current_page) { ?>
								<td><div class="active"><?php echo $i; ?></div></td>
							<?php } else { ?>
								<td><?php echo '<a href="'.$this->req_page.'page='.$i.'">'.$i.'</a>'; ?></td>
							<?php } 
						}
						//if($this->current_page < $this->no_of_pages - $inc && $show_links != $this->no_of_pages){
																									// LINK TO FIRST PAGE SHOWN ON PAGES BEFORE HALF OF LINKS SHOWN FROM LAST PAGE
					?>
					<td><?php echo '<a href="'.$this->req_page.'page='.$this->no_of_pages.'">Last &gt;</a>'; ?></td>
					<?php //} ?>
				</tr>
			</table>
	<?php }
	}
}

?>