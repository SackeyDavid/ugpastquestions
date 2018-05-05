@if($pasquos->count())
<br>
<style type="text/css">
	
ul li    {
	margin:0;
  padding:0;
  
}

</style>

<div class="col-md-8 col-md-offset-2" style="padding-bottom: 0%;">
<div class="well" style="padding-bottom: 0%;padding-left: 0%;">
	
			
			<div class="row" style="margin-top: -2%;padding-bottom: 0%;">

			<p style="color: #ccc;" > search results for {{ $search_item }}</p>  
                    <ul class ="list-unstyled" style="margin-top: -1%; ">
                    @foreach($pasquos as $pasquo) 
                    
                    <span><b style="color: #040F97;">{{ $pasquo->course_title }}</b></span>
                     <span ><ul class="list-inline">
                            <li><b>Course code: </b> {{ $pasquo->course_code }}</li>
                            <li><b>Department: </b> {{ $pasquo->department }}</li>
                        
                            <li><b>Level: </b> {{ $pasquo->level }}</li>
                            <li><b>Year: </b> {{ $pasquo->year }}</li>
                        
                     
                     <li><ul class="list-inline">
                            <li><a href="'/uploads/'.{{ $pasquo->path }}" class="btn btn-md btn-info" target="_blank">open</a></li>
                            <li><form method="get" action="'/uploads/'.{{ $pasquo->path }}">
                             <button class="btn btn-md btn-success" type="submit">Download!</button></form>

                             </li>
                             <li><i style="color: lightblue;" class="fa fa-check-circle"></i></li>
                             </ul>
                     </li>
                     </ul>
                         </span>
                     <br><br>
                    @endforeach
            	</ul>
            

		  <center  style="padding-bottom: 0%;">
		  {{ $pasquos->links() }}
		  </center >
          </div>
	
		
	</div>
</div>

@else
<div class="col-md-8 col-md-offset-2">
	<br>
<div class="well">
<div class="row">
	
		
				<b>{{ $search_item }} not found</b>
</div>		
	</div>
</div>

@endif