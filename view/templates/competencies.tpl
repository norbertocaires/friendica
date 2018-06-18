<div class="">
{{if $competencies}}
{{foreach $competencies as $competencie}}
	{{include file="competencie.tpl"}}
{{/foreach}}
{{else}}
Nenhuma competencia adicionada
{{/if}}
</div>


<br>
<div class="add-competencie" >
<a class="btn" href="{{$addLink}}" title="{{$add}}">{{$add}}</a>
</div>
<div class="add-competencie"></div>