<h3>{{$title}}</h3>

<br>
<div>
<label id="competencie-title-label" for="competencie-title" > Título </label>
<br>
<input type="text" size="32" name="profile_name" id="competencie-title" value="{{$competencie.title}}" /><div class="required">*</div>
</div>

<br>
<div>
<label id="competencie-description-label" for="competencie-description"> Descrição </label>
<br>
<textarea rows="10" cols="72" id="competencie-description" name="contact" >{{$competencie.description}}</textarea>
<div class="required">*</div>
</div>

<br>
<div class="competencie-submit-wrapper" >
<a class="btn" href="{{$saveLink}}" title="{{$save}}">{{$save}}</a>
</div>
<div class="competencie-submit-end"></div>