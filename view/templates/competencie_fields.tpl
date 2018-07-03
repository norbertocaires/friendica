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

<h3>Nível de Performance</h3>
<hr>
<h4> Nível: </h4>

<select>
  <option value="0">Escolha um nível..</option>
  <option value="Principiante">Principiante</option>
  <option value="Intermediário">Intermediário</option>
  <option value="Avançado">Avançado</option>
  <option value="Especialista">Especialista</option>
</select>

<br>
<br>
<h4> Valor: </h4>
<select>
  <option value="0">Escolha um valor..</option>
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="7">7</option>
  <option value="8">8</option>
  <option value="9">9</option>
  <option value="10">10</option>
</select>

<br>
<br>


<h4> Critérios: </h4>
<br>

<div style="float:left">
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

<div style="float:left">
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

<div style="float:left">
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
<div style="clear:both"></div>

<br>
<div style="float:left">
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

<div style="float:left">
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
<div style="clear:both"></div>

<div class="competencie-submit-wrapper" >
    <input id="event-submit" type="submit" name="submit" value="Salvar" />
</div>
<div class="competencie-submit-end"></div>
</form>
