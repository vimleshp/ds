<div class="paginationresult">
    <span id="pageStartNo" style="display:none;">1</span>
<?php
	$maxRows=RECORD_TO_SHOW;
	$bandGap=2;
	$totalPages=ceil($totalRecords/$maxRows);
	$currentPage=$pageStart;
	$pageFrom=1;
	$pageStartFrom=1;
	if($currentPage > 1)
	{
		$pageStartFrom=($currentPage-1)*$maxRows;
		$pageStartFrom++;
	}
	$Pageendlimit=$totalRecords;
	if($maxRows*$currentPage<$totalRecords)
	{
		$Pageendlimit=($pageStartFrom-1)+$maxRows;
	}
    // get template content
    $template_content = get_the_content( "", "", $template_id );
    // replace template placeholders
    if($pageStart <= 1){
    	$template_content = str_replace('$$itemprebuttondisable$$', 'disabled="disabled" class="pageButton prevButton noborder"', $template_content);
    }else{
    	$template_content = str_replace('$$itemprebuttondisable$$', 'class="pageButton prevButton"', $template_content);
    }
    $template_content = str_replace('$$itemTotalCount$$', $totalRecords, $template_content); 
    $template_content = str_replace('$$itemPageStartNo$$', $pageStart, $template_content); 
    $template_content = str_replace('$$itemPageEndNo$$', $pageEnd, $template_content);
	$template_content = str_replace('$$itemPageStartFrom$$', $pageStartFrom, $template_content);
	$template_content = str_replace('$$itemPageendlimit$$', $Pageendlimit, $template_content);
	
	$str_p="";
	$pageFrom=1;
	if (($currentPage-$bandGap) > 2 ) {
		$pageFrom = $currentPage-$bandGap;
		$str_p.='<a class="pageLink" data-page="1"  href="javascript:pagination(1)" class="page-link">1</a>';
		$str_p.='<a class="page-link" href="javascript:null">...</a>';
	}
	$pageTo = $currentPage+$bandGap;
	if ( ( $currentPage + $bandGap ) > $totalPages ) {
		$pageTo = $totalPages;
	}
	
	for($i=$pageFrom;$i<=$pageTo;$i++){
		if ( $currentPage == $i ) {
			$str_p.='<a class="pageLink active" data-page="'.$i.'" href="javascript:void(0);">'.$i.'</a>';
		}
		else{
			$str_p.='<a class="pageLink" data-page="'.$i.'"  href="javascript:void(0);">'.$i.'</a>';
		}
	}
	if ( ( $currentPage + $bandGap) < $totalPages-1) {
		$str_p.='<a class="page-link" href="javascript:null">...</a>';
	}
	if ( ( $currentPage + $bandGap) < $totalPages) {
		$str_p.='<a class="pageLink pageEndNo" data-page="'.$totalPages.'" href="javascript:void(0)">'.$totalPages.'</a>';
	}
	$template_content = str_replace('$$itemStrp$$', $str_p, $template_content); 
    if($numberOfPages == $pageStart){
        $template_content = str_replace('$$itemnextbuttondisable$$', 'disabled="" class="pageButton nextButton noborder"', $template_content);
    }else{
    	$template_content = str_replace('$$itemnextbuttondisable$$', 'class="pageButton nextButton next"', $template_content);
    }
    // shortcode to html
    echo do_shortcode( $template_content ); 
?>
</div>