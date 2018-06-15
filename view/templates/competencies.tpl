<div class="">
{{foreach $competencies as $competencie}}
	{{include file="competencie.tpl"}}
{{/foreach}}
</div>


<br>
<div class="add-competencie" >
<a class="btn" href="{{$addLink}}" title="{{$add}}">{{$add}}</a>
</div>
<div class="add-competencie"></div>