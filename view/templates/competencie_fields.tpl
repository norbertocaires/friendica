<h3>{{$title}}</h3>

<br>

<form id="competencie-form" name="form1" action="{{$action}}/{{$nick}}" method="post" >
<div>
<label id="competencie-name-label" for="competencie-name" > Título </label>
<br>
<input type="text" size="32" name="competencie_name" id="competencie-name" value="{{$competencie.name}}" /><div class="required">*</div>
</div>

<br>
<div>
<label id="competencie-statement-label" for="competencie-statement"> Descrição </label>
<br>
<textarea rows="10" cols="72" id="competencie_statement" name="competencie_statement" >{{$competencie.statement}}</textarea>
<div class="required">*</div>
</div>

<br>
<div>
<label id="competencie-idnumber-label" for="competencie-idnumber"> Descrição </label>
<br>
<input type="text" size="10" name="competencie_idnumber" id="competencie-idnumber" value="{{$competencie.idnumber}}" /><div class="required">*</div>
</div>

<br>
<div>
  <label id="competencie-idnumber-label"> Autonomo </label>
<div class="required">*</div>
  <div>
    <input type="radio" id="with" name="autonomy" {{if $competencie.autonomy}}checked{{/if}} value="true">
    <label for="with">Com assistência</label>
  </div>
  <div>
    <input type="radio" id="without" name="autonomy" {{if !$competencie.autonomy}}checked{{/if}} value="false">
    <label for="without">Sem assistência</label>
  </div>
</div>

<br>
<div>
  <label id="competencie-idnumber-label"> Frequência </label>
<div class="required">*</div>
  <div>
    <input type="radio" id="with" name="frequency" {{if $competencie.frequency}}checked{{/if}} value="true">
    <label for="with">Em todos os casos</label>
  </div>
  <div>
    <input type="radio" id="without" name="frequency" {{if !$competencie.frequency}}checked{{/if}} value="false">
    <label for="without">Em alguns casos</label>
  </div>
</div>

<br>
<div>
  <label id="competencie-idnumber-label"> Familiaridade </label>
<div class="required">*</div>
  <div>
    <input type="radio" id="with" name="familiarity" {{if $competencie.familiarity}}checked{{/if}} value="true">
    <label for="with">Familiar</label>
  </div>
  <div>
    <input type="radio" id="without" name="familiarity" {{if !$competencie.familiarity}}checked{{/if}} value="false">
    <label for="without">Não Familiar</label>
  </div>
</div>

<br>
<div>
  <label id="competencie-idnumber-label"> Escopo </label>
<div class="required">*</div>
  <div>
    <input type="radio" id="with" name="scope" {{if $competencie.scope}}checked{{/if}} value="true">
    <label for="with">Total</label>
  </div>
  <div>
    <input type="radio" id="without" name="scope" {{if !$competencie.scope}}checked{{/if}} value="false">
    <label for="without">Parcial</label>
  </div>
</div>

<br>
<div>
  <label id="competencie-idnumber-label"> Complexidade </label>
<div class="required">*</div>
  <div>
    <input type="radio" id="with" name="complexity" {{if $competencie.complexity == 'high'}}checked{{/if}} value="high">
    <label for="with">Alta</label>
  </div>
  <div>
    <input type="radio" id="without" name="complexity" {{if $competencie.complexity == 'middle'}}checked{{/if}} value="middle">
    <label for="without">Média</label>
  </div>  <div>
    <input type="radio" id="without" name="complexity" {{if $competencie.complexity == 'weak'}}checked{{/if}} value="weak">
    <label for="without">Baixa</label>
  </div>
</div>


<br>
<div class="competencie-submit-wrapper" >
    <input id="event-submit" type="submit" name="submit" value="Salvar" />
</div>
<div class="competencie-submit-end"></div>
</form>